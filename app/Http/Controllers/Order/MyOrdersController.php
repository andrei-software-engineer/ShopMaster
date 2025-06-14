<?php
  
namespace App\Http\Controllers\Order;

use App\Models\Order\Order;
use App\Models\Base\Paginate;
use App\Models\Base\SystemMenu;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MyOrdersController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new MyOrdersController;
       return self::$MainObj;
    } 

    protected function pageDetailSetBreadcrumbsOrders($params, $info = []){
        $params['_breadcrumbs'] = [];

        $prd = new SystemMenu();
        $prd->_name =  _GL('My Orders');
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }

    public function myOrders($infos = null)
    {
		$params = array();
        $f = array();
        $f['_where']['iduser'] = Auth::user()->id;
        $total = Order::_getCount($f);

        $procesedPage = Paginate::getParams(request(), $total);
        $f['_start'] = $procesedPage->start;
        $f['_limit'] = $procesedPage->limit;

        $orders = Order::_getAll($f, array('_full' => '1', '_musttranslate' => 1 , '_musttranslate' => 1));
        // --------------------------
        
        $urlprefix = route('web.myOrders').'?page=';
        $urlsufix = '';

        $params = array();
        $params['left_params']['usermenu'] = [];
        $params['_infosParams'] = '';
        if($infos) $params['_infosParams'] = $infos;
        $params['orders'] = $orders;
        $params['paginate'] = Paginate::getPaginateHtml($procesedPage->currPag, $procesedPage->totalpag, $urlprefix, $urlsufix);
        $params = $this->pageDetailSetBreadcrumbsOrders($params);

        // dd($params);
        return $this->GetView('BaseSite.Order.myOrders', $params);
    }

    protected function pageDetailSetBreadcrumbsOrderDetails($params, $info = []){

        $params['_breadcrumbs'] = [];
        $prd = new SystemMenu();
        $prd->_name =  'order-'.$params['order']->id;
        $prd->url = '';
        
        $prdd = new SystemMenu();
        $prdd->_name =  'myOrders';
        $prdd->url = route('web.myOrders');
        
        $params['_breadcrumbs'][] = $prdd;
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }


    public function orderDetails($uid)
    {
        $order = Order::_getByUuid($uid, array('_full' => '1', '_usecache' => '0'));

        if($order){
            $params = array();
            $params['order'] = $order;
            $params['url'] = route('web.orderDetails', ['uid' => $order->uuid]);
            $params['backUrl'] = route('web.orderDetails', ['uid' => $order->uuid]);

            $params['orderTable'] = $this->orderTable($params);
            $params['orderDetailsTable'] = $this->orderDetailsTable($params);
            $params['orderProductsTable'] = $this->orderProductsTable($params);
            $params['orderJournalTable'] = $this->orderJournalTable($params);
            $params['orderMessageTable'] = $this->orderMessageTable($params);

            $params['left_params']['usermenu'] = [];
            $params = $this->pageDetailSetBreadcrumbsOrderDetails($params);

            return $this->GetView('BaseSite.Order.OrderDetails.orderDetails', $params);

        }else{

            return view('BaseSite.Empty.empty');
        }

    }


    public function orderTable($params)
    {
        return view('BaseSite.Order.OrderDetails.orderTable', $params);
    }

    public function orderDetailsTable($params)
    {
        return view('BaseSite.Order.OrderDetails.orderDetailsTable', $params);
    }

    public function orderProductsTable($params)
    {
        return view('BaseSite.Order.OrderDetails.orderProductsTable', $params);
    }

    public function orderJournalTable($params)
    {
        return view('BaseSite.Order.OrderDetails.orderJournalTable', $params);
    }

    public function orderMessageTable($params)
    {
        return view('BaseSite.Order.OrderDetails.orderMessageTable', $params);
    }

}