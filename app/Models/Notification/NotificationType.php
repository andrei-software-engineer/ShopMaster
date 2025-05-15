<?php

namespace App\Models\Notification;

use App\Models\Base\BaseModel;
use App\Models\Base\Status;

class NotificationType extends BaseModel
{
    const UPROFILE         = 1;
    const SPROFILE         = 2;
    const SMS             = 3;
    const EMAIL         = 4;
    const ADMINS         = 5;

    const REFILLDOCS = 200;

    const ADMIN_ORDER_PAYMENT  = 50;
    const USER_ORDER_PAYMENT = 51;

    const COMMAND_FORM = 10;
    const DIRECT_PAY_URL = 11;
    const WELCOME_EMAIL = 12;
    const RESET_PASS = 13;
    const AUTOMATIC_MESSAGE = 14;

    const ACTIV_EMAIL = 15;
    const ACTIV_PHONE = 16;



    const SMSUSER = 100;
    const SMSADMIN = 101;
    const EMAILUSER = 102;
    const EMAILADMIN = 103;


    const NSD_EMAIL   = 1000;
    const NSD_SMS     = 1001;
    const NSD_PROFILE = 1002;
    const NSD_TOPINFO = 1003;

    const NSD_GR_U_GENERAL    = 1010;
    const NSD_GR_U_REQUEST    = 1011;
    const NSD_GR_U_SPAREPARTS = 1012;

    const NSD_GR_B_GENERAL       = 1020;
    const NSD_GR_B_FINANACIAL    = 1021;
    const NSD_GR_B_REQUEST       = 1022;
    const NSD_GR_B_SPAREPARTS    = 1023;

    const NSD_U    = 1023;

    /// ...

    // --------------------------------------------
    public static function GET_FROM_GROUP($id)
    {
        $arr = array();

        switch ($id) {
            case self::NSD_GR_U_GENERAL:
                $arr = array();
                break;
            case self::NSD_GR_U_REQUEST:
                $arr = array();
                break;
            case self::NSD_GR_U_SPAREPARTS:
                $arr = array();
                break;

            case self::NSD_GR_B_GENERAL:
                $arr = array();
                break;
            case self::NSD_GR_B_FINANACIAL:
                $arr = array();
                break;
            case self::NSD_GR_B_REQUEST:
                $arr = array();
                break;
            case self::NSD_GR_B_SPAREPARTS:
                $arr = array();
                break;
        }

        return -1;
    }

    // --------------------------------------------

    // --------------------------------------------
    public static function GET_DEFAULT($idnotificationtype, $iddestination)
    {
        return -1;
    }

    // --------------------------------------------
    public static function CHECK_ALWAYS_ENABLED($idnotificationtype, $iddestination)
    {
        return false;
    }

    // --------------------------------------------
    public static function CHECK_ALWAYS_DISABLED($idnotificationtype, $iddestination)
    {
        return false;
    }

    // --------------------------------------------

    // --------------------------------------------
    public static function GA($k = '')
    {
        $all = array(1, 2, 3, 4);

        if ($k == 'destination') $all = array(1, 2, 3, 4, 5);
        if ($k == 'type') $all = array(1);
        if ($k == 'whithtml') $all = array(1, 2, 5);

        if ($k == 'user_groups') $all = array(1010, 1011, 1012);

        return self::getlist($all, __CLASS__);
    }

    // --------------------------------------------
    public static function prepareconfig($k, $v)
    {
        $rez = $v;

        return $rez;
    }

    // --------------------------------------------
    public static function GL($id)
    {
        return parent::_GL($id, __CLASS__);
    }

    // --------------------------------------------
    public static function _GAS($k = '')
    {
        $all = self::GA($k);
        return array_keys($all);
    }

    // --------------------------------------------
    public static function getpriority($id)
    {
        $rez = 1000;

        if ($id == self::ACTIV_EMAIL) $rez = 5;
        if ($id == self::ACTIV_PHONE) $rez = 5;
        //	if ($id == self::MO_TRANSACTION_ACTIV) $rez = 25;
        //	if ($id == self::MO_TRANSACTION_ANULAT) $rez = 25;

        return $rez;
    }

    // --------------------------------------------
    public static function needsendnotify($type = false, $needs = array(), $obj = false)
    {
        if ($obj && is_object($obj) && $obj->status != Status::ACTIVE) return false;

        if (!$type) return true;

        $needs = (array)$needs;
        if (!count($needs)) return true;

        if (!in_array($type, $needs)) return false;

        return true;
    }
}
