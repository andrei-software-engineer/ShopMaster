<?php

namespace App\Models\Order;


use App\Models\Base\Slug;
use Orchid\Screen\AsSource;
use App\Models\Base\Status;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use App\Models\Base\BaseModel;
use App\Models\Base\DT;
use App\Models\Location\Location;
use Orchid\Filters\Types\Like;
use App\Models\Product\Product;
use App\Models\User;
use Symfony\Component\Uid\Uuid;
use Orchid\Screen\Fields\ViewField;

class Order extends BaseModel 
{
    use RoleAccess, Filterable, AsSource, Chartable;

    /**
     * @var array
     */

    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new Order;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'order';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'iduser',
        'uuid',
        'status',
        'paystatus',
        'idpaymenthod',
        'data',
        'idmetodalivrare',
        'dataplata',
        'idorderpartener',

        'total_real_pricewotvat',
        'total_discount_value',
        'total_real_vat',
        'total_real_price',
        'total_achitat',
        'total_datorie',
        
        'comments',
        'destinatar_name',
        'destinatar_company',
        'destinatar_phone',
        'destinatar_email',
        'destinatar_address',
        'destinatar_idlocation',
        'destinatar_delivery_number',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'iduser',
        'uuid',
        'status',
        'paystatus',
        'idpaymenthod',
        'data',
        'idmetodalivrare',
        'dataplata',
        'idorderpartener',

        'total_real_pricewotvat',
        'total_discount_value',
        'total_real_vat',
        'total_real_price',
        'total_achitat',
        'total_datorie',
        
        'comments',
        'destinatar_name',
        'destinatar_company',
        'destinatar_phone',
        'destinatar_email',
        'destinatar_address',
        'destinatar_idlocation',
        'destinatar_delivery_number',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'iduser',
        'uuid',
        'status',
        'paystatus',
        'idpaymenthod',
        'data',
        'idmetodalivrare',
        'dataplata',
        'idorderpartener',

        'total_real_pricewotvat',
        'total_discount_value',
        'total_real_vat',
        'total_real_price',
        'total_achitat',
        'total_datorie',
        
        'comments',
        'destinatar_name',
        'destinatar_company',
        'destinatar_phone',
        'destinatar_email',
        'destinatar_address',
        'destinatar_idlocation',
        'destinatar_delivery_number',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('identifier', 'type'),
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->paymenthod_text = Status::GL($obj->idpaymenthod);
            $obj->metodalivrare_text = Status::GL($obj->idmetodalivrare);
            $obj->paystatus_text = Status::GL($obj->paystatus);
            $user = User::query()->where('id', $obj->iduser)->first();
            $obj->user_name = $user->name;
            $obj->order_data = DT::GDT_T($obj->data, true, DT::DATE_ROMANIAN);
            $obj->order_dataplata = DT::GDT_T($obj->dataplata, true, DT::DATE_ROMANIAN);
            $obj->destinatar_location = 'Chisinau'; // de procesat
            $f = array();
            $f['_where']['idorder'] = $obj->id;
            $obj->products = OrderProduct::_getAll($f, array('_full' => '1', '_musttranslate' => 1));
            $obj->order_journal= OrderJurnal::_getAll($f, array('_full' => '1', '_musttranslate' => 1));
            $obj->order_message= OrderMessage::_getAll($f, array('_full' => '1'));
            $obj->datapaid = DT::GDT_T($obj->dataplata, true, DT::DATE_ROMANIAN);

            // ORDER STATUS ---------------------------------------------------------------------------------------------------------------------------
            $obj->can_pending = true;
            if ($obj->can_pending && !in_array($obj->status, Status::_GAS('order_status_can_pending')))  $obj->can_pending = false;   
            if ($obj->can_pending && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_pending')))  $obj->can_pending = false;       

            $obj->can_new = true;
            if ($obj->can_new && !in_array($obj->status, Status::_GAS('order_status_can_new')))  $obj->can_new = false; 
            if ($obj->can_new && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_new')))  $obj->can_new = false;       

            $obj->can_verified = true;
            if ($obj->can_verified && !in_array($obj->status, Status::_GAS('order_status_can_verified')))  $obj->can_verified = false;   
            if ($obj->can_verified && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_verified')))  $obj->can_verified = false;       

            $obj->can_inprocess = true;
            if ($obj->can_inprocess && !in_array($obj->status, Status::_GAS('order_status_can_inprocess')))  $obj->can_inprocess = false;  
            if ($obj->can_inprocess && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_inprocess')))  $obj->can_inprocess = false;       

            $obj->can_processed = true;
            if ($obj->can_processed && !in_array($obj->status, Status::_GAS('order_status_can_processed')))  $obj->can_processed = false;  
            if ($obj->can_processed && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_processed')))  $obj->can_processed = false;       

            $obj->can_ontransit = true;
            if ($obj->can_ontransit && !in_array($obj->status, Status::_GAS('order_status_can_ontransit')))  $obj->can_ontransit = false;    
            if ($obj->can_ontransit && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_ontransit')))  $obj->can_ontransit = false;       

            $obj->can_ondelivery = true;
            if ($obj->can_ondelivery && !in_array($obj->status, Status::_GAS('order_status_can_ondelivery')))  $obj->can_ondelivery = false;  
            if ($obj->can_ondelivery && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_ondelivery')))  $obj->can_ondelivery = false;       

            $obj->can_delivered = true;
            if ($obj->can_delivered && !in_array($obj->status, Status::_GAS('order_status_can_delivered')))  $obj->can_delivered = false;     
            if ($obj->can_delivered && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_delivered')))  $obj->can_delivered = false;       

            $obj->can_confirmed = true;
            if ($obj->can_confirmed && !in_array($obj->status, Status::_GAS('order_status_can_confirmed')))  $obj->can_confirmed = false;     
            if ($obj->can_confirmed && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_confirmed')))  $obj->can_confirmed = false;       

            $obj->can_canceled = true;
            if ($obj->can_canceled && !in_array($obj->status, Status::_GAS('order_status_can_canceled')))  $obj->can_canceled = false;     
            if ($obj->can_canceled && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_canceled')))  $obj->can_canceled = false;       

            $obj->can_arhived = true;
            if ($obj->can_arhived && !in_array($obj->status, Status::_GAS('order_status_can_arhived')))  $obj->can_arhived = false;     
            if ($obj->can_arhived && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_arhived')))  $obj->can_arhived = false;       

            // ORDER PAY STATUS---------------------------------------------------------------------------------------------------------------------------
            $obj->can_unpayed = true;
            if ($obj->can_unpayed && !in_array($obj->status, Status::_GAS('order_status_can_unpayed')))  $obj->can_unpayed = false;     
            if ($obj->can_unpayed && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_unpayed')))  $obj->can_unpayed = false;       
 
            $obj->can_pay = true;
            if ($obj->can_pay && !in_array($obj->status, Status::_GAS('order_status_can_pay')))  $obj->can_pay = false;     
            if ($obj->can_pay && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_pay')))  $obj->can_pay = false;       
 
            $obj->can_needreturn = true;
            if ($obj->can_needreturn && !in_array($obj->status, Status::_GAS('order_status_can_needreturn')))  $obj->can_needreturn = false;     
            if ($obj->can_needreturn && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_needreturn')))  $obj->can_needreturn = false;       
 
            $obj->can_return = true;
            if ($obj->can_return && !in_array($obj->status, Status::_GAS('order_status_can_return')))  $obj->can_return = false;     
            if ($obj->can_return && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_return')))  $obj->can_return = false;       
 
            $obj->can_cancel_payment = true;
            if ($obj->can_cancel_payment && !in_array($obj->status, Status::_GAS('order_status_can_cancel_payment')))  $obj->can_cancel_payment = false;     
            if ($obj->can_cancel_payment && !in_array($obj->paystatus, Status::_GAS('order_paystatus_can_cancel_payment')))  $obj->can_cancel_payment = false;       
 

            // dd($obj);    


            $obj->url = Slug::prepareUrl('', $obj->uuid, 'web.orderDetails'); 
            $obj->canDelete = $obj->_canDelete();
        }

        return $obj;
    }

    public static function getProducts()
    {

        $session = request()->session()->all();

        if(!array_key_exists('cart', $session))
        {
            $session['cart'] = [];
        }else{
            $cartItems = $session['cart'];
            if($cartItems == [])
            {
                return [];
            }else
            {
                foreach($cartItems as $item)
                {
                    $product= Product::_get($item['idproduct'], array('_full'=> 1,'_musttranslate' => 1));
                    $arr[] = ['product' => $product, 'quantity' => $item['quantity'], '_backUrl' => route('web.checkout')];
                }
                
                return $arr;
            }
        }
        
    }

    public static function getCartItems()
    {
        $session = request()->session()->all();

        if(!array_key_exists('cart', $session))
        {
            $session['cart'] = []; 

            return count( $session['cart']);
        }else{
            $cartItems = $session['cart'];
            if($cartItems == [])
            {
                return 0;
            }else
            {
                foreach($cartItems as $item)
                {
                    $product= Product::_get($item['idproduct'], array('_full'=> 1,'_musttranslate' => 1));
                    $arr[] = ['product' => $product, 'quantity' => $item['quantity'], '_backUrl' => route('web.checkout')];
                }
                return count($arr);
            }
        }

        
    }

    public function _canDelete()
    {       
        $t =  parent::_canDelete();
        if(!$t){
            return false;
        }
        return true;
    }

    public static function locationselect($name = '', $selected = 0, $cilds = '', $idparent = 0)
	{
        $r = request();
        $params = array();
        $params['chids'] =  $cilds;
        $title = _GLA('Select Location');
		if ($r->get('name')) $name = $r->get('name');
		$idparent = ($r->get('idlparent')) ? (int)$r->get('idlparent') : $idparent;
        
		if (!$name) return view('BaseSite.Empty.empty');

		if ($idparent == -1) 
		{		
			return view('BaseSite.Empty.empty'); 
		}
        
		if ($selected)
		{
			$obj = Location::_get($selected ,array('_admin' => '1', '_musttranslate' => 1));
                        
			if ($obj->idparent)
			{
				$params['name'] = $name;
				$params['id'] = 'id_sel_' . $name;
				$params['targid'] = $name . '_targid_' . $idparent;
	
				$params['chids'] = $cilds;
				$params['selected'] = (int)$selected;
                
				$params['prefLink'] = 'platform.execselectadminorder';
				$params['title'] = $title;

                $f = array();
                $f['_where']['idparent'] = $obj->idparent;
                $all = Location::_getAll($f, array('_admin' => '1', '_musttranslate' => 1, '_usecache' => '0'));
                $params['objects'] = $all;
                $cilds = (!count($all)) ? view('BaseSite.Empty.empty')->render() : ViewField::make('obj.' . $name)
                    ->view('Orchid.selectGeneral')
                    ->set('params', $params)->render();
                

                return self::locationselect($name, $obj->idparent, $cilds, 0);
			}
           
		}
        
		$preparedname = str_replace('[','_',$name);
		$preparedname = str_replace(']','_',$preparedname);
		$params['name'] = $name;
		$params['id'] = Uuid::v4();
		$params['targid'] = $preparedname . '_targid_' . $idparent;
	
		$params['chids'] = $cilds;
		$params['selected'] = (int)$selected;
        $params['title'] = $title;
		$params['prefLink'] = 'platform.execselectadminorder';
        
        $f = array();
        $f['_where']['idparent'] = $idparent;
		$all = Location::_getAll($f, array('_admin' => '1', '_musttranslate' => 1, '_usecache' => '0'));
        if(!count($all)) return view('BaseSite.Empty.empty'); 
       
		$params['objects'] = $all;

        return  ViewField::make('obj.'. $name)
                    ->view('Orchid.selectGeneral')
                    ->class('js_CA_select')
                    ->set('params', $params);
	}	
}