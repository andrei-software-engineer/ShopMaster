<?php

namespace App\Models\Base;

use Illuminate\Support\Facades\DB;

class Status extends BaseModel
{
    // Constante

    const ACTIVE = 1;
    const INACTIVE = 2;

    const _NEW = 3;

    const USER = 4;
    const ADMIN = 5;
    const NEEDPROCESS = 6;
    const GUEST = 7;

    const YES = 10;
    const NO = 11;

    const UNPROCESSED = 16;

    const LABEL_TYPE_SYSTEM = 20;
    const LABEL_TYPE_ADMIN = 21;
    const LABEL_TYPE_SITE = 22;
    const LABEL_TYPE_MESSAGE = 23;
    const LABEL_TYPE_API = 24;

    const PAGE_GENERAL = 30;
    const PAGE_COMPONENT = 31;


    const MENU_SECTION_TOP = 70;
    const MENU_SECTION_MAIN = 71;
    const MENU_SECTION_BOTTOM = 72;

    const MENU_TYPE_CUSTOM = 90;
    const MENU_TYPE_SPECIALLINK = 91;
    const MENU_TYPE_LINKTOPAGE = 92;
    const MENU_TYPE_NOLINK = 93;

    const FAQ_TYPE = 100;

    const ADV_TYPE_IMAGE = 105;
    const ADV_TYPE_CTA   = 106;
    const ADV_TYPE_VIDEO   = 107;

    const ADV_SECTION_TOP = 110;
    const ADV_SECTION_MAIN = 111;
    const ADV_SECTION_BOTTOM = 112;

    const CENTRAL = 118;
    const FILIALA = 119;

    const SPECIAL_CATEGORY_CATEGORY_AUTO = 130;
    const SPECIAL_CATEGORY_CATEGORY_TRUCK = 131;
    const SPECIAL_CATEGORY_CATEGORY_BIKE = 132;
    const SPECIAL_CATEGORY_CATEGORY_TRANSPORTER = 133;
    const SPECIAL_CATEGORY_CATEGORY_BULDOZER = 134;
    const SPECIAL_CATEGORY_CATEGORY_TRACTOR = 135;

    const FILTER_TYPE_RANGE = 140;
    const FILTER_TYPE_VALUE = 141;
    const FILTER_TYPE_STRING = 142;

    // ORDER ==================================================================
    const ORDER_PRODUCT_TYPE = 78;

    const ORDER_BY_NAME_ASC = 150;
    const ORDER_BY_NAME_DESC = 151;
    const ORDER_BY_PRICE_ASC = 152;
    const ORDER_BY_PRICE_DESC = 153;

    const NEW = 154;
    const PENDING = 155;
    const VERIFIED = 156;
    const INPROCESS = 157;
    const PROCESSED = 158;
    const ONTRANSIT = 159;
    const ONDELIVERY = 160;
    const DELIVERED = 161;
    const CONFIRMED = 162;
    const CANCELED = 163;
    const ARHIVED = 164;

    const PICKUP_DEPOSIT = 165;
    const DESTINATION_DELIVERY= 166;
    
    const PAYSTATUS_UNPAID = 167;
    const PAYSTATUS_PAID = 168;
    const PAYSTATUS_NEEDRETURN = 169;
    const PAYSTATUS_RETURNED = 170;
    const PAYSTATUS_CANCELED = 171;



    // PAYMENT ORDER ==================================================================
    const PAYMETHOD_PAYNET = 172;
    const PAYMETHOD_BANK_TRANSFER = 173;
    const PAYMETHOD_DELIVERY = 174;

    const PAYMENT_SUPLINIRE_CONT = 180;
    const PAYMENT_ACHITARE_COMANDA = 181;
    
    // TRANSACTION ==================================================================
    const TRANSACTION_CREATED 	    	    = 182;	// 
	const TRANSACTION_CANCEL 	    	    = 183;	// 
	const TRANSACTION_NOTIFICATION  	    = 184;	// 
	const TRANSACTION_CONFIRMED  			    = 185;	// 
    
    // PAYNET TRANSACTION ==================================================================
    const PAYNET_TRANSACTION_NEW				         = 190;
    const PAYNET_TRANSACTION_SUCCESS  		             = 191;
    const PAYNET_TRANSACTION_TECHNICAL_ERROR	         = 192;
    const PAYNET_TRANSACTION_DATABASE_ERROR	             = 193;
    const PAYNET_TRANSACTION_USERNAME_OR_PASSWORD_WRONG  = 194;
    const PAYNET_TRANSACTION_CONNECTION_ERROR	         = 195;
    const PAYNET_TRANSACTION_CANCEL	                     = 196;
    const PAYNET_TRANSACTION_MANUAL_SET_PAYED            = 197;


    // return array
    public static function GA($key = 'all', $withempty = false)
    {
        $rez = array(self::ACTIVE, self::INACTIVE);


        


        if ($key == 'lang') $rez = array(self::ACTIVE, self::INACTIVE);
        if ($key == 'yesno') $rez = array(self::YES, self::NO);
        if ($key == 'label') $rez = array(self::PROCESSED, self::UNPROCESSED);
        if ($key == 'labeltype') $rez = array(
            self::LABEL_TYPE_SITE, 
            self::LABEL_TYPE_ADMIN, 
            self::LABEL_TYPE_SYSTEM, 
            self::LABEL_TYPE_MESSAGE, 
            self::LABEL_TYPE_API
        );

        if ($key == 'car_filter') $rez = array(
            self::SPECIAL_CATEGORY_CATEGORY_AUTO, 
            self::SPECIAL_CATEGORY_CATEGORY_TRUCK, 
            self::SPECIAL_CATEGORY_CATEGORY_BIKE, 
            self::SPECIAL_CATEGORY_CATEGORY_TRANSPORTER, 
            self::SPECIAL_CATEGORY_CATEGORY_BULDOZER,
            self::SPECIAL_CATEGORY_CATEGORY_TRACTOR,
        );

        if ($key == 'product_order_by') $rez = array(
            self::ORDER_BY_NAME_ASC, 
            self::ORDER_BY_NAME_DESC, 
            self::ORDER_BY_PRICE_ASC, 
            self::ORDER_BY_PRICE_DESC, 
        );
        

        if ($key == 'prd_fyl_ctg_status') $rez = array(self::ACTIVE, self::INACTIVE, self::NEEDPROCESS );
        
        if ($key == 'payment_status') $rez = array(self::PAYMENT_SUPLINIRE_CONT, self::PAYMENT_ACHITARE_COMANDA);

        if ($key == 'paynet_transaction_type') $rez = array(self::TRANSACTION_CREATED, self::TRANSACTION_CANCEL,self::TRANSACTION_NOTIFICATION, self::TRANSACTION_CONFIRMED);

        if ($key == 'filter_type') $rez = array(self::FILTER_TYPE_RANGE, self::FILTER_TYPE_VALUE, self::FILTER_TYPE_STRING);

        if ($key == 'visibility_type') $rez = array(self::USER, self::ADMIN);
        if ($key == 'ordermessage_type') $rez = array(self::USER, self::ADMIN);

        if ($key == 'order_paystatus') $rez = array(self::PAYSTATUS_UNPAID, self::PAYSTATUS_PAID, self::PAYSTATUS_NEEDRETURN, self::PAYSTATUS_RETURNED, self::PAYSTATUS_CANCELED);
        if ($key == 'order_paymethod') $rez = array(self::PAYMETHOD_PAYNET, self::PAYMETHOD_BANK_TRANSFER, self::PAYMETHOD_DELIVERY);
        if ($key == 'order_delivery_method') $rez = array(self::PICKUP_DEPOSIT, self::DESTINATION_DELIVERY);
       
        if ($key == 'order_product_type') $rez = array(self::ORDER_PRODUCT_TYPE);

        // ORDER STATUS ==============================================================================================================================
        if ($key == 'order_status_can_pending')    $rez = array();
        if ($key == 'order_status_can_new')        $rez = array(self::PENDING);
        if ($key == 'order_status_can_verified')   $rez = array(self::NEW);
        if ($key == 'order_status_can_inprocess')  $rez = array(self::VERIFIED);
        if ($key == 'order_status_can_processed')  $rez = array(self::INPROCESS);
        if ($key == 'order_status_can_ontransit')  $rez = array(self::PROCESSED);
        if ($key == 'order_status_can_ondelivery') $rez = array(self::ONTRANSIT);
        if ($key == 'order_status_can_delivered')  $rez = array(self::ONDELIVERY);
        if ($key == 'order_status_can_confirmed')  $rez = array(self::DELIVERED);
        if ($key == 'order_status_can_arhived')    $rez = array(self::CONFIRMED);
        if ($key == 'order_status_can_canceled')   $rez = array(self::NEW, self::PENDING, self::VERIFIED , self::INPROCESS, self::PROCESSED, self::ONTRANSIT, self::ONDELIVERY);
        
        if ($key == 'order_paystatus_can_pending')   $rez = array(self::PAYSTATUS_PAID,self::PAYSTATUS_UNPAID);
        if ($key == 'order_paystatus_can_new')       $rez = array(self::PAYSTATUS_PAID,self::PAYSTATUS_UNPAID);
        if ($key == 'order_paystatus_can_verified')  $rez = array(self::PAYSTATUS_PAID,self::PAYSTATUS_UNPAID);
        if ($key == 'order_paystatus_can_inprocess') $rez = array(self::PAYSTATUS_PAID,self::PAYSTATUS_UNPAID);
        if ($key == 'order_paystatus_can_processed') $rez = array(self::PAYSTATUS_PAID,self::PAYSTATUS_UNPAID);
        if ($key == 'order_paystatus_can_ontransit') $rez = array(self::PAYSTATUS_PAID,self::PAYSTATUS_UNPAID);
        if ($key == 'order_paystatus_can_ondelivery')$rez = array(self::PAYSTATUS_PAID,self::PAYSTATUS_UNPAID);
        if ($key == 'order_paystatus_can_delivered') $rez = array(self::PAYSTATUS_PAID,self::PAYSTATUS_UNPAID);
        if ($key == 'order_paystatus_can_confirmed') $rez = array(self::PAYSTATUS_PAID);
        if ($key == 'order_paystatus_can_arhived')   $rez = array(self::PAYSTATUS_PAID);
        if ($key == 'order_paystatus_can_canceled')  $rez = array(self::PAYSTATUS_UNPAID,self::PAYSTATUS_NEEDRETURN,self::PAYSTATUS_RETURNED);
        
        // ORDER  PAY STATUS ==============================================================================================================================

        if ($key == 'order_status_can_unpayed')        $rez = array(self::PENDING,self::NEW ,self::VERIFIED,self::INPROCESS,self::PROCESSED,self::ONTRANSIT,self::ONDELIVERY,self::DELIVERED,self::CONFIRMED);
        if ($key == 'order_status_can_pay')            $rez = array(self::PENDING,self::NEW ,self::VERIFIED,self::INPROCESS,self::PROCESSED,self::ONTRANSIT,self::ONDELIVERY,self::DELIVERED,self::CONFIRMED);
        if ($key == 'order_status_can_needreturn')     $rez = array(self::PENDING,self::NEW ,self::VERIFIED,self::INPROCESS,self::PROCESSED,self::ONTRANSIT,self::ONDELIVERY,self::DELIVERED,self::CONFIRMED);
        if ($key == 'order_status_can_return')         $rez = array(self::PENDING,self::NEW ,self::VERIFIED,self::INPROCESS,self::PROCESSED,self::ONTRANSIT,self::ONDELIVERY,self::DELIVERED,self::CONFIRMED);
        if ($key == 'order_status_can_cancel_payment') $rez = array(self::PENDING,self::NEW ,self::VERIFIED,self::INPROCESS,self::PROCESSED,self::ONTRANSIT,self::ONDELIVERY,self::DELIVERED,self::CONFIRMED);
        
        if ($key == 'order_paystatus_can_unpayed')        $rez = array();
        if ($key == 'order_paystatus_can_pay')            $rez = array(self::PAYSTATUS_UNPAID);
        if ($key == 'order_paystatus_can_needreturn')     $rez = array(self::PAYSTATUS_PAID);
        if ($key == 'order_paystatus_can_return')         $rez = array(self::PAYSTATUS_NEEDRETURN);
        if ($key == 'order_paystatus_can_cancel_payment') $rez = array(self::PAYSTATUS_RETURNED);

            

        // XXX ==============================================================================================================================
        if ($key == 'general_status') $rez = array(self::ACTIVE, self::INACTIVE);
        if ($key == 'page_type') $rez = array(self::PAGE_GENERAL, self::PAGE_COMPONENT);

        if ($key == 'faq_type') $rez = array(self::FAQ_TYPE);

        if ($key == 'adv_section') $rez = array(self::ADV_SECTION_TOP, self::ADV_SECTION_MAIN, self::ADV_SECTION_BOTTOM);
        if ($key == 'adv_type') $rez = array(self::ADV_TYPE_IMAGE, self::ADV_TYPE_CTA, self::ADV_TYPE_VIDEO);
        
        if ($key == 'menu_section') $rez = array(self::MENU_SECTION_TOP, self::MENU_SECTION_MAIN, self::MENU_SECTION_BOTTOM);
        if ($key == 'menu_type') $rez = array(self::MENU_TYPE_CUSTOM, self::MENU_TYPE_SPECIALLINK, self::MENU_TYPE_LINKTOPAGE, self::MENU_TYPE_NOLINK);

        if ($key == 'media_type') $rez = array(self::ACTIVE, self::INACTIVE);

        if ($key == 'isdefault') $rez = array(self::YES, self::NO);

        if ($key == 'map_type') $rez = array(self::CENTRAL, self::FILIALA);

        return self::GLIST($rez, $withempty);
    }

    public static function getConstant($key)
    {
        $class = new \ReflectionClass(__CLASS__);
        $constants = array_flip($class->getConstants());
        return (isset($constants[$key])) ? $constants[$key] : false;
    }

    // return text (string)
    public static function GL($id)
    {
        $const = self::getConstant($id);
        if (!$const) return $id;

        return _GLS('Status_' . $const);
    }

    // return array index
    public static function GLIST($ids = array(), $withempty = false)
    {

        $ids = (array)$ids;

        $rez = array();

        if ($withempty) {
            $rez[''] = $withempty;
        }

        foreach ($ids as $v) {
            $rez[$v] = self::GL($v);
        }

        return $rez;
    }

    // --------------------------------------------
    public static function _GAS($k = '')
    {
        $all = self::GA($k);
        
        return array_keys($all);
    }    


    public  function processObject($obj, $params)
    {
        //
    }
}
