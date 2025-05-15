<?php
  
namespace App\Http\Controllers\Order;

use App\Models\Order\Order;
use App\Models\Base\Status;
use App\Models\Base\Exceptions;
use App\Models\Paynet\PaynetEcomAPI;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Payment\Paynetwallet;
use App\Models\Payment\Paynettransaction;
use App\Models\Payment\Paynettransactionjurnal;
use App\Http\Controllers\Order\PaymentController;

class PaynetController extends Controller
{
    // --------------------------------------------
    private static $MainObj = false;
 
    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new PaynetController;
       return self::$MainObj;
    }  

    // ============================================================================
    public function cancelpayment()
    {
        // -----------------------------------------------------------------------------
        $paynettransaction = Paynettransaction::_get(request()->id, array());

        if (!$paynettransaction){
            $info = Exceptions::errorNotFoundHTML(_GL('Nu exista transactia paynet pentru cumanda cu id-ul '.request()->id));
            return MyOrdersController::GetObj()->myOrders($info);
        } 

        if (!request()->id) {
            return PaymentController::GetObj()->order_cancelpayment(request()->id);
        }

        // -----------------------------------------------------------------------------
        $paynettransaction->status = status::PAYNET_TRANSACTION_CANCEL;
        $paynettransaction->save();

        // -----------------------------------------------------------------------------
        $paynettransactionjurnal = new Paynettransactionjurnal();

        $paynettransactionjurnal->idpaynettransaction = $paynettransaction->id;
        $paynettransactionjurnal->date = time();
        $paynettransactionjurnal->transactionjurnaltype = Status::TRANSACTION_CANCEL;
        $paynettransactionjurnal->idrole = (!Auth::user()) ? Status::GUEST : Status::USER;
        $paynettransactionjurnal->iduser = Auth::user()->id;
        $paynettransactionjurnal->status = $paynettransaction->status;
        $paynettransactionjurnal->note = $paynettransaction->EventType;

        $paynettransactionjurnal->save();
        
        // Send email ------------------------------------------------------------------------------
        PaymentController::execStatusNotificationAdmin($paynettransaction);
        PaymentController::execStatusNotificationUser($paynettransaction);


        return  PaymentController::GetObj()->order_cancelpayment($paynettransaction->idparentclass);
    }


    // ============================================================================
    public function successpayment()
    {
        $paynettransaction = Paynettransaction::_get(request()->id);

        if (!$paynettransaction) return Exceptions::errorNotFoundHTML(_GL('Nu exista transactia paynet'));
        
        $this->notifypayment_checktransaction($paynettransaction);

        return  PaymentController::GetObj()->order_successpayment($paynettransaction->idparentclass);

    }


    // =============================================================================
    protected function notifypayment_checktransaction($paynettransaction, &$err = NULL)
    {

        $err = false;

        $oldstatus = $paynettransaction->status;

        // -----------------------------------------------------------------------------
        $checktransaction = $this->checktransaction($paynettransaction, false, $content);


        if ($checktransaction != 'paid') {
            $err = false;
            return 200;
        }  
        $content = reset($content);
        // -----------------------------------------------------------------------------
        $paynettransaction->status = Status::PAYNET_TRANSACTION_SUCCESS;
        // $paynettransaction->EventType = $content->EventType;
        $paynettransaction->PaymentSaleAreaCode = $content['SaleAreaCode'];
        $paynettransaction->PaymentCustomer = $content['Customer'];
        $paynettransaction->PaymentStatusDate = $content['Status'];
        $paynettransaction->PaymentAmount = $content['Amount'];
        $paynettransaction->PaymentMerchant = $content['MerchantCode'];
        $paynettransaction->save();

        // -----------------------------------------------------------------------------
        $paynettransactionjurnal = new Paynettransactionjurnal();

        $paynettransactionjurnal->idpaynettransaction = $paynettransaction->id;
        $paynettransactionjurnal->date = time();
        $paynettransactionjurnal->transactionjurnaltype = Status::TRANSACTION_CONFIRMED;
        $paynettransactionjurnal->idrole = (!Auth::user()) ? Status::GUEST : Status::USER;
        $paynettransactionjurnal->iduser = Auth::user()->id;
        $paynettransactionjurnal->status = $paynettransaction->status;
        $paynettransactionjurnal->note = '';

        $paynettransactionjurnal->save();
        
        // Send email -----------------------------------------------------------------------------
        PaymentController::execStatusNotificationAdmin($paynettransaction);
        PaymentController::execStatusNotificationUser($paynettransaction);

        // -----------------------------------------------------------------------------
        if ($oldstatus != Status::PAYNET_TRANSACTION_SUCCESS) {
            self::GL_setobjectpayed($paynettransaction, $paynettransaction->idparentclass);   
        }

        $err = false;
        return 200;
    }

    // ============================================================================
    protected function checktransaction($paynettransaction, $api = false, &$content = false)
    {
        $tr = $this->gettransaction($paynettransaction, $api, $content);

        if ($tr === false) return false;

        if ($tr['Status'] == 4) {
            if ($tr['Confirmed'] && $tr['Processed']) {
                return 'paid';
            }
            return 'unpaid';
        }

        if (strtotime($tr['ExpiryDate']) < time()) {
            return 'expired';
        }

        return 'unpaid';
    }

    // ============================================================================
    protected function gettransaction($paynettransaction, $api = false, &$content = false)
    {

        if (!$api) {
            // -----------------------------------------------------------------------------
            $paynetwallet = Paynetwallet::_get($paynettransaction->idpaynetwallet, array());
        
            if (!$paynetwallet) return Exceptions::errorNotFoundHTML(_GL('Portofel Paynet neacceptat'));
            
            // -----------------------------------------------------------------------------
            $api = new PaynetEcomAPI(
                $paynetwallet->merchant_code,
                $paynetwallet->merchant_secretkey,
                $paynetwallet->merchant_user,
                $paynetwallet->merchant_userpass,
                $paynetwallet->notification_secretkey
            );
        }


        // -----------------------------------------------------------------------------
        $rez = $api->PaymentGet($paynettransaction->id);
        if (!$rez) return false;
        if (!$rez->Data) return false;
        if (!is_array($rez->Data)) return false;
        if (!count($rez->Data)) return false;

        $content = $rez->Data;


        foreach ($rez->Data as $v) {
            if ($v['LinkUrlSuccess'] != \config('app.app_url') . '/successpayment/' . $paynettransaction->id) continue;
            return $v;
        }

        return false;
    }


    // ============================================================================
    public static function GL_setobjectpayed($obj, $idorder)
    {
        $order = Order::_get($idorder, array());

        if (!$order->can_pay) return true;

        $order->total_achitat += $obj->value;
        $order->total_datorie  = $order->total_achitat - $order->total_datorie;
        $order->save();

        $obj->status  = Status::PAYNET_TRANSACTION_SUCCESS;
        
        $obj->save();
    }

}