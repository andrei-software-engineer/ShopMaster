<?php

namespace App\Models\Order;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Base\BaseModel;
use App\Models\Base\Status;
use App\Models\Product\Offer;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;

class OrderForm extends BaseModel 
{
    public static function createOrder($arr = [])
    {
        $obj = new Order();
        $obj->iduser = Auth::user()->id;
        $obj->uuid = Str::uuid()->toString();
        $obj->comments = request()->get('comments');
        $obj->status = Status::PENDING;
        $obj->paystatus = Status::PAYSTATUS_UNPAID;
        $obj->data = Carbon::now()->getTimestamp();
        $obj->dataplata = 0;

        // $destinatar_idlocation = array_filter(request()->get('destinatar_idlocation')); // Remove any falsey values
        // $destinatar_idlocation = array_reverse($destinatar_idlocation); // Reverse the order of the remaining values
        $destinatar_idlocation = "1";

        $obj->total_real_pricewotvat = 0;
        $obj->total_discount_value = 0;   
        $obj->total_real_vat = 0;   
        $obj->total_real_price = 0;   
        $obj->total_achitat = 0;   
        $obj->total_datorie = 0;   

        $arr = (array) $arr;
        $arr['destinatar_name'] = (isset($arr['destinatar_name'])) ? $arr['destinatar_name'] : request()->get('destinatar_name');
        $arr['destinatar_company'] = (isset($arr['destinatar_company'])) ? $arr['destinatar_company'] : request()->get('destinatar_company');
        $arr['destinatar_phone'] = (isset($arr['destinatar_phone'])) ? $arr['destinatar_phone'] : request()->get('destinatar_phone');
        $arr['destinatar_delivery_number'] = (isset($arr['destinatar_delivery_number'])) ? $arr['destinatar_delivery_number'] : request()->get('destinatar_delivery_number');
        $arr['destinatar_email'] = (isset($arr['destinatar_email'])) ? $arr['destinatar_email'] : request()->get('destinatar_email');
        $arr['destinatar_address'] = (isset($arr['destinatar_address'])) ? $arr['destinatar_address'] : request()->get('destinatar_address');
        $arr['destinatar_idlocation'] = (isset($arr['destinatar_idlocation'])) ? $arr['destinatar_idlocation'] : $destinatar_idlocation;


        $arr['idlivrare'] = (isset($arr['idlivrare'])) ? $arr['idlivrare'] : request()->get('idlivrare');
        $arr['idpaymenthod'] = (isset($arr['idpaymenthod'])) ? $arr['idpaymenthod'] : request()->get('idpaymenthod');

        if (isset($arr['destinatar_name'])) $obj->destinatar_name = $arr['destinatar_name'];
        if (isset($arr['destinatar_company'])) $obj->destinatar_company = $arr['destinatar_company'];
        if (isset($arr['destinatar_phone'])) $obj->destinatar_phone = $arr['destinatar_phone'];
        if (isset($arr['destinatar_delivery_number'])) $obj->destinatar_delivery_number = $arr['destinatar_delivery_number'];
        if (isset($arr['destinatar_email'])) $obj->destinatar_email = $arr['destinatar_email'];
        if (isset($arr['destinatar_address'])) $obj->destinatar_address = $arr['destinatar_address'];
        if (isset($arr['destinatar_idlocation'])) $obj->destinatar_idlocation = $arr['destinatar_idlocation'];

        if (isset($arr['idlivrare'])) $obj->idmetodalivrare = $arr['idlivrare'];
        if (isset($arr['idpaymenthod'])) $obj->idpaymenthod = $arr['idpaymenthod'];

        $obj->_save();

        OrderForm::saveOrderJournal($obj, Status::PENDING,'', 0);

        return $obj;
    }


    public static function saveOrderProducts($order, $idProduct, $quantity)
    {
        $product = Product::_get($idProduct, array('_full'=> 1,'_musttranslate' => 1));

		$obj = new OrderProduct();

        $obj->idorder = $order->id;
        $obj->idproduct = $product->id;
        $obj->type = Status::NEW;
        $obj->quantity = $quantity;
        $obj->status = $order->status;
        $obj->paystatus = $order->paystatus;
        $obj->idpaymethod = $order->idpaymenthod;
        $obj->description = "";


        //---------------------------------------------------------------
        $preparedPrice = Offer::prepareOffer($idProduct, $quantity);

        if($preparedPrice)
        {
            $obj->pricewoutvat = $preparedPrice->pricewoutvat;
            $obj->real_pricewotvat = $preparedPrice->real_pricewotvat;
            $obj->discount_percent = $preparedPrice->discount_percent;
            $obj->discount_value = $preparedPrice->discount_value;
            $obj->real_vat = $preparedPrice->real_vat;
            $obj->real_price = $preparedPrice->real_price;
        }else{
            $obj->pricewoutvat = 0;
            $obj->real_pricewotvat = 0;
            $obj->discount_percent = 0;
            $obj->discount_value = 0;
            $obj->real_vat = 0;
            $obj->real_price = 0;
        }
        

        //---------------------------------------------------------------
        $obj->total_real_pricewotvat = $obj->real_pricewotvat * $quantity;
        $obj->total_discount_value = $obj->discount_percent * $quantity;
        $obj->total_real_vat = $obj->real_vat * $quantity;
        $obj->total_real_price = $obj->real_price * $quantity;
        $obj->total_datorie = $obj->total_real_price;
        $obj->total_achitat = 0;

        $obj->_save();
        
        self::calculatPrices($order);

        OrderForm::saveOrderJournal($order, Status::NEW, $product->_name, 0);
    }
    

    public static function saveOrderJournal($order, $jurnalType, $note = '', $idRole = 0)
    {
		$obj = new OrderJurnal();
        
        $obj->idorder = $order->id;
        $obj->data = Carbon::now()->getTimestamp();
        $obj->orderjurnaltype = $jurnalType;
        $obj->idrole = $idRole;
        $obj->iduser = Auth::user()->id;
        $obj->status = $order->status;
        $obj->paystatus = $order->paystatus;
        $obj->idpaymethod = $order->idpaymenthod;
        $obj->note = $note;

        $obj->_save();
    }


    public static function calculatPrices($order)
    {

        $obj = $order;

        $f = array();
        $f['_where']['idorder'] = $order->id;

        $products = OrderProduct::_getAll($f);
        foreach($products as $item)
        {
            $obj->total_real_pricewotvat += $item->total_real_pricewotvat;
            $obj->total_discount_value += $item->total_discount_value;   
            $obj->total_real_vat += $item->total_real_vat;  
            $obj->total_real_price += $item->total_real_price;  
            $obj->total_achitat += $item->total_achitat;  
            $obj->total_datorie += $item->total_datorie;  
        }

        $obj->status = Status::NEW;
        $obj->paystatus = Status::PAYSTATUS_UNPAID;
        
        $obj->_save();
    }
    
}