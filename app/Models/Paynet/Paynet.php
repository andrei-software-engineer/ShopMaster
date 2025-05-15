<?php

namespace App\Models\Paynet;

use App\Http\Controllers\Order\MyOrdersController;
use App\Models\Base\Exceptions;
use App\Models\Base\Lang;
use App\Models\Base\Status;
use Illuminate\Support\Facades\Auth;
use App\Models\Paynet\PaynetEcomAPI;
use App\Models\Payment\Paynetwallet;
use App\Models\Paynet\PaynetRequest;
use App\Models\Payment\Paynettransaction;
use App\Models\Payment\Paynettransactionjurnal;
use App\Http\Controllers\Order\PaymentController;

class Paynet
{
    // ============================================================================
    public static function getpayform($obj)
    {
        // dd($obj);
        // ---------------------------------------------------------------------
        if (!$obj || !$obj->total_datorie){
            return MyOrdersController::GetObj()->myOrders();
        } 

        // ---------------------------------------------------------------------
        $params['obj'] = $obj;
        $paynetwallet = Paynetwallet::get_paynetwallet();

        if (!$paynetwallet) return Exceptions::errorNotFoundHTML(_GL('Portofel Paynet neacceptat'));


        // ---------------------------------------------------------------------
        $f = array();
        $f['_where']['parentclass'] = 'order';
        $f['_where']['idparentclass'] = $obj->id;
        $f['_where']['status'] = Status::PAYNET_TRANSACTION_NEW;

        $c = Paynettransaction::_getCount($f, array('_admin' => '1'));

        if ($c) {
            return Exceptions::errorNotFoundHTML(_GL('In asteptare'));
        }

        // -----------------------------------------------------------------------------
        $paynettransaction = new Paynettransaction();

        $paynettransaction->parentclass = 'order';
        $paynettransaction->idparentclass = $obj->id;
        $paynettransaction->idpaynetwallet = $paynetwallet->id;
        $paynettransaction->status = Status::PAYNET_TRANSACTION_NEW;
        $paynettransaction->tr_amount = $obj->total_datorie * 100;
        $paynettransaction->site_amount = $obj->total_datorie;
        $paynettransaction->date = time();
        $paynettransaction->EventType = '';
        $paynettransaction->PaymentSaleAreaCode = '';
        $paynettransaction->PaymentCustomer = '';
        $paynettransaction->PaymentStatusDate = '';
        $paynettransaction->PaymentAmount = $obj->total_datorie;
        $paynettransaction->PaymentMerchant = '';

        $paynettransaction->save();

        // -----------------------------------------------------------------------------
        $paynettransactionjurnal = new Paynettransactionjurnal();

        $paynettransactionjurnal->idpaynettransaction = $paynettransaction->id;
        $paynettransactionjurnal->date = time();
        $paynettransactionjurnal->transactionjurnaltype = Status::TRANSACTION_CREATED;
        $paynettransactionjurnal->idrole = (!Auth::user()) ? Status::GUEST : Status::USER;
        $paynettransactionjurnal->iduser = Auth::user()->id;
        $paynettransactionjurnal->status = $paynettransaction->status;
        $paynettransactionjurnal->note = $paynettransaction->EventType;

        $paynettransactionjurnal->save();
        
        // Send email ------------------------------------------------------------------------------
        PaymentController::execStatusNotificationAdmin($paynettransaction);
        PaymentController::execStatusNotificationUser($paynettransaction);

        // -----------------------------------------------------------------------------
        $api = new PaynetEcomAPI(
            $paynetwallet->merchant_code,
            $paynetwallet->merchant_secretkey,
            $paynetwallet->merchant_user,
            $paynetwallet->merchant_userpass,
            $paynetwallet->notification_secretkey
        );



        // -----------------------------------------------------------------------------
        $prequest = new PaynetRequest();
        $prequest->ExternalID =  $paynettransaction->id;
        $prequest->LinkSuccess = \config('app.app_url') . '/successpayment/' . $paynettransaction->id;
        $prequest->LinkCancel = \config('app.app_url') . '/cancelpayment/' . $paynettransaction->id;
        $prequest->Lang = (Lang::_getLangNAME()) ? Lang::_getLangNAME() : 'ro';


        $prequest->Products = array(
            array(
                'LineNo' => '1',
                'Code' => 'order' . $obj->id,
                'Barcode' => $obj->id,
                'Name' => _GL('comanda nr') . ' ' . $obj->id,
                'Description' => _GL('achitarea prin paynet a comenzii nr') . ' ' . $obj->id,
                'Quantity' => 100,     // // 200 = 2.00  two 				
                'UnitPrice' => $paynettransaction->tr_amount
            )
        );

        $prequest->Amount = $paynettransaction->site_amount;

        $prequest->Service = array(
            array(
                'Name'         => _GL('Shop name PayNet'),
                'Description' => _GL('Shop description PayNet'),
                //                                            'Amount'	=> $paynettransaction->tr_amount,
                //                                            'Amount'	=> 0,
                'Amount'    => $prequest->Amount,
                'Products'    => $prequest->Products
            )
        );

        $prequest->Customer = array(
            'Code'          => ''
            //                                    , 'Address'     => ''
            //                                    , 'Name'        => ''
            //                                    , 'NameFirst'   => ''
            //                                    , 'NameLast'    => ''
            //                                    , 'email'       => ''
            //                                    , 'PhoneNumber' => ''
            //                                    , 'Country'     => ''
            //                                    , 'City'        => ''
        );

        $paymentRegObj = $api->PaymentReg($prequest);

        $params['formprefix'] = $paymentRegObj->DataTruncated;

        return view('BaseSite.Paynet.paynet_getpayform', $params);
    }

    
}