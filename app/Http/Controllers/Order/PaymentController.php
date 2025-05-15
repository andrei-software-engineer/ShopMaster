<?php
  
namespace App\Http\Controllers\Order;


use App\Models\Base\Lang;
use App\Models\Page\Page;
use App\Models\Base\Status;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Models\Paynet\Paynet;
use App\Models\Base\SystemMenu;
use App\Http\Controllers\Controller;
use App\Models\Notification\EmailTemplate;
use App\Models\Notification\Notification;
use App\Models\Notification\NotificationType;
use App\Models\Notification\NotificationAttributes;

class PaymentController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;
 
    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new PaymentController;
       return self::$MainObj;
    }  
 
    public function paymentPage(Request $request){

        $params = array();

        $params['left_params']['usermenu'] = [];
        $params = $this->paymentPageSetBreadcrumbs($params);

        return $this->GetView('BaseSite.Payment.paymentPage', $params);
    }


    public function paymentCheckPage(Request $request)
    {
        $obj = Order::_get($request->id, array('_full' => '1'));
        // dd($obj);

        if (!$obj)
        {
            return MyOrdersController::GetObj()->myOrders(); 
        }

        if (!$obj->can_pay)
        {
            return MyOrdersController::GetObj()->orderDetails($obj->uuid); 
        }

        if($obj->idpaymenthod == Status::PAYMETHOD_PAYNET){
            return $this->orderPaynetMethod($request, $obj);
        }
        if($obj->idpaymenthod == Status::PAYMETHOD_BANK_TRANSFER){
            return $this->orderBankTransferMethod($request, $obj);
        }
        if($obj->idpaymenthod == Status::PAYMETHOD_DELIVERY){
            return $this->orderDeliveryMethod($request, $obj);
        }

        return MyOrdersController::GetObj()->orderDetails($obj->uuid); 
    }


    protected function paymentPageSetBreadcrumbs($params, $info = []){
        $params['_breadcrumbs'] = [];

        $prd = new SystemMenu();
        $prd->_name =  _GL('Payment ');
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }


    public function orderBankTransferMethod(Request $request,Order $obj){
        $params = array();
        $params['left_params']['usermenu'] = [];
        $params['order'] = $obj;
        $params['obj'] = Page::_get(\config('app.id_page_bank_transfer'), array('_full' => '1'));

        $params = $this->orderDeliverySetBreadcrumbsProfile($params);
        
        return $this->GetView('BaseSite.Payment.orderBankTransfer', $params);
    }
    
    protected function orderBankTransferSetBreadcrumbsProfile($params, $info = []){
        $params['_breadcrumbs'] = [];

        $prd = new SystemMenu();
        $prd->_name =  _GL('Bank Transfer');
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }

    public  function orderDeliveryMethod(Request $request,Order $obj){
        $params = array();
        $params['left_params']['usermenu'] = [];
        $params['order'] = $obj;
        $params['obj'] = Page::_get(\config('app.id_page_delivery'), array('_full' => '1'));

        $params = $this->orderDeliverySetBreadcrumbsProfile($params);

        return $this->GetView('BaseSite.Payment.orderDeliveryMethod', $params);
    }


    protected function orderDeliverySetBreadcrumbsProfile($params, $info = []){
        $params['_breadcrumbs'] = [];

        $prd = new SystemMenu();
        $prd->_name =  _GL('Livrare');
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }


    public function orderPaynetMethod(Request $request, Order $obj){

        return Paynet::getpayform($obj);
    }


    // ============================================================================
    public function order_cancelpayment($id)
    {
        $order = Order::_get($id);

        $order->status = Status::CANCELED;
        $order->paystatus = Status::PAYSTATUS_CANCELED;
        $order->save();

        $params = array();
        $params['left_params']['usermenu'] = [];
        $params['order'] = Order::_get($id, array('_full' => '1'));
        $params['obj'] = Page::_get(\config('app.id_page_anulateplata'), array('_full' => '1'));
        $params = $this->orderSetBreadcrumbsProfile($params);
        
        return $this->GetView('BaseSite.Payment.cancelPayment', $params);
    }	


    // ============================================================================
    public function order_successpayment($id)
    {
        $order = Order::_get($id, array());

        $order->status = Status::CONFIRMED;
        $order->paystatus = Status::PAYSTATUS_PAID;
        $order->save();

        $params = array();
        $params['left_params']['usermenu'] = [];
        $params['order'] = $order;
        $params['obj'] = Page::_get(\config('app.id_page_plata_achitata'), array('_full' => '1'));
        $params = $this->orderSetBreadcrumbsProfile($params);
        
        return $this->GetView('BaseSite.Payment.successPayment', $params);
    }	

    
    protected function orderSetBreadcrumbsProfile($params, $info = []){
        $params['_breadcrumbs'] = [];

        $prd = new SystemMenu();
        $prd->_name =  _GL('Order');
        $prd->url = '';
        
        $params['_breadcrumbs'][] = $prd;
        
        return $params;
    }

    public static function execStatusNotificationAdmin($paynettransaction){
        $order = Order::_get($paynettransaction->idparentclass, array('_full' => '1'));

        $obj = new Notification();
        $obj->type = NotificationType::ADMIN_ORDER_PAYMENT;
        $obj->destination = NotificationType::EMAIL;
        if (!$obj->idlang) $obj->idlang = Lang::_getSessionId();
        if (!$obj->priority) $obj->priority = NotificationType::getpriority($obj->type);
        $obj->status = Status::_NEW;

        $identifier = 'admin_' . 'order_' . strtolower(Status::getConstant($order->status)) . '_'. strtolower(Status::getConstant($order->paystatus));
        $obj->idtemplate = EmailTemplate::getIdFromIdentifier($identifier);

        $obj->parentmodel = '';
        $obj->_save();

        $params = array();

        $params['##id##'] = Status::GL($order->id);
        $params['##iduser##'] = Status::GL($order->iduser);
        $params['##idpaymenthod##'] = Status::GL($order->idpaymenthod);
        $params['##total_achitat##'] = Status::GL($order->total_achitat);
        $params['##total_datorie##'] = Status::GL($order->total_datorie);
        $params['##status##'] = Status::GL($order->status);
        $params['##paystatus##'] = Status::GL($order->paystatus);

        $params = (array) $params;
        foreach ($params as $k => $v) {
            $notificationattr = new NotificationAttributes();
            $notificationattr->idnotification = $obj->id;
            $notificationattr->key = $k;
            $notificationattr->value = $v;

            $notificationattr->_save();
        }
    }

    public static function execStatusNotificationUser($paynettransaction){
        $order = Order::_get($paynettransaction->idparentclass, array('_full' => '1'));

        $obj = new Notification();
        $obj->type = NotificationType::USER_ORDER_PAYMENT;
        $obj->destination = NotificationType::EMAIL;
        if (!$obj->idlang) $obj->idlang = Lang::_getSessionId();
        if (!$obj->priority) $obj->priority = NotificationType::getpriority($obj->type);
        $obj->status = Status::_NEW;

        $identifier = 'user_' . 'order_' . Status::getConstant($order->status) . Status::getConstant($order->paystatus);
        $obj->idtemplate = EmailTemplate::getIdFromIdentifier($identifier);

        $obj->parentmodel = '';
        $obj->_save();

        $params = array();

        $params['##id##'] = Status::GL($order->id);
        $params['##iduser##'] = Status::GL($order->iduser);
        $params['##idpaymenthod##'] = Status::GL($order->idpaymenthod);
        $params['##total_achitat##'] = Status::GL($order->total_achitat);
        $params['##total_datorie##'] = Status::GL($order->total_datorie);
        $params['##status##'] = Status::GL($order->status);
        $params['##paystatus##'] = Status::GL($order->paystatus);

        $params = (array) $params;
        foreach ($params as $k => $v) {
            $notificationattr = new NotificationAttributes();
            $notificationattr->idnotification = $obj->id;
            $notificationattr->key = $k;
            $notificationattr->value = $v;

            $notificationattr->_save();
        }
    }


}