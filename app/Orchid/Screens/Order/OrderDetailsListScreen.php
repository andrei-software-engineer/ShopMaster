<?php

namespace App\Orchid\Screens\Order;

use App\Models\Base\Status;
use App\Models\Base\SystemFile;
use App\Models\Order\Order;
use App\Models\Order\OrderForm;
use App\Models\Order\OrderMessage;
use App\Models\Order\OrderProduct;
use App\Orchid\Screens\BaseListScreen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class OrderDetailsListScreen extends BaseListScreen
{
    public $targetClass = false;
    public $params = array();

    public function __construct()
    {
        $this->specialView = 'Orchid.base';
        $this->targetClass = Order::GetObj();
    }


    public static function getOrderDetails($id){
        
        $params['order'] = Order::_get($id, array('_full' => '1'));
        
        if($params['order']){
            $params['url'] = route('web.orderDetails', ['uid' => $params['order']->uuid]);
            $params['backUrl'] = route('platform.orderdetails.list', ['id' => $params['order']->id]);
            
            $params['orderTable'] = self::orderTable($params);
            $params['orderDetailsTable'] = self::orderDetailsTable($params);
            $params['orderActionsTable'] = self::orderActionsTable($params);
            $params['orderProductsTable'] = self::orderProductsTable($params);
            $params['orderJournalTable'] = self::orderJournalTable($params);
            $params['orderMessageTable'] = self::orderMessageTable($params);
    
            return $params;
        }else{
            return false;
        }

    }



    public function query(): array
    {
        $id = request()->get('id');
        $params = self::getOrderDetails($id);

        return [
            'data' => $params,
        ];
    }

    public static function orderTable($params)
    {
        return view('Orchid.Order.orderTable', ['data' => $params]);
    }

    public static function orderDetailsTable($params)
    {
        return view('Orchid.Order.orderDetailsTable', ['data' => $params]);
    }

    public static function orderActionsTable($params)
    {
        return view('Orchid.Order.orderActionsTable', ['data' => $params]);
    }

    public static function orderProductsTable($params)
    {
        return view('Orchid.Order.orderProductsTable', ['data' => $params]);
    }

    public static function orderJournalTable($params)
    {
        return view('Orchid.Order.orderJournalTable', ['data' => $params]);
    }

    public static function orderMessageTable($params)
    {
        return view('Orchid.Order.orderMessageTable', ['data' => $params]);
    }


    public function deleteOrderProduct()
    {
        $id = request()->get('id');
        $obj = OrderProduct::_get($id, array('_full' => '1'));

        $obj->delete();

        Alert::info('You have successfully deleted the product');

        if (request()->get('backUrl')) {
            return redirect()->to(request()->get('backUrl'));
        }
    }

    public function execOrderMessage()
    {
        $order = Order::_get(request()->get('idorder'));
        $obj = new OrderMessage();

        if($order->iduser == Auth::user()->id)
        {
            $obj->idorder = $order->id;
            $obj->visibilitytype = Status::USER;
            $obj->ordermessagetype = Status::USER;
            $obj->data = time();
            $obj->message = request()->get('message');
            $obj->idfile = SystemFile::saveFiles(request()->file('fileX'), $obj->idfile);

            $obj->_save();
        }

        
        return redirect()->to(request()->get('backUrl'));

    }

    // ORDER STATUS ===================================================================================
    public function setNew()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::NEW;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order new', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setPending()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::PENDING;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order in pending', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setVerified()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::VERIFIED;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order verified', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setInProcess()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::INPROCESS;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order in process', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setProcessed()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::PROCESSED;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order processed', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setOnTransit()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::ONTRANSIT;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order on transit', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setOnDelivery()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::ONDELIVERY;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order on delivery', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setDelivered()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::DELIVERED;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order delivered', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setConfirmed()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::CONFIRMED;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order confirmed', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setCanceled()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::CANCELED;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order Canceled', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setArhived()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->status = Status::ARHIVED;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('status' => $obj->status));
        OrderForm::saveOrderJournal($obj, $obj->status, 'Order arhived', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }


    // ORDER PAYMENT STATUTS ===================================================================================
    public function setUnpaid()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->paystatus = Status::PAYSTATUS_UNPAID;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('paystatus' => $obj->paystatus));
        OrderForm::saveOrderJournal($obj, $obj->paystatus, 'Order unpaid', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setPaid()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->paystatus = Status::PAYSTATUS_PAID;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('paystatus' => $obj->paystatus));
        OrderForm::saveOrderJournal($obj, $obj->paystatus, 'Order paid', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setNeedReturn()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->paystatus = Status::PAYSTATUS_NEEDRETURN;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('paystatus' => $obj->paystatus));
        OrderForm::saveOrderJournal($obj, $obj->paystatus, 'Order need return', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setReturned()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->paystatus = Status::PAYSTATUS_RETURNED;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('paystatus' => $obj->paystatus));
        OrderForm::saveOrderJournal($obj, $obj->paystatus, 'Order returned', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }

    public function setPaymentCanceled()
    {
        $id = request()->get('idorder');

        $obj = Order::_get($id, array());
        $obj->paystatus = Status::PAYSTATUS_CANCELED;

        $obj->save();

        DB::table('orderproducts')->where('idorder', $id)->update(array('paystatus' => $obj->paystatus));
        OrderForm::saveOrderJournal($obj, $obj->paystatus, 'Order payment canceled', 0);
        
        return redirect()->to(request()->get('backUrl'));
    }



    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::view('Orchid.Order.orderDetails'),
        ];
    }
}
