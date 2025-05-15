<?php

namespace App\Models\Payment;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use App\Models\Base\BaseModel;
use Orchid\Filters\Types\Like;

class Paynetwallet extends BaseModel
{
    use RoleAccess, Filterable, AsSource, Chartable;

    /**
     * @var array
     */

    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj)
            return self::$MainObj;
        self::$MainObj = new Paynetwallet;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'paynetwallet';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'ordercriteria',
        'status',
        'isdefault',
        'merchant_code',
        'merchant_secretkey',
        'merchant_user',
        'merchant_userpass',
        'notification_secretkey',

    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'ordercriteria',
        'status',
        'isdefault',
        'merchant_code',
        'merchant_secretkey',
        'merchant_user',
        'merchant_userpass',
        'notification_secretkey',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'ordercriteria',
        'status',
        'isdefault',
        'merchant_code',
        'merchant_secretkey',
        'merchant_user',
        'merchant_userpass',
        'notification_secretkey',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
    ];


    // ============================================================================
    public function processObject($obj, $params)
    {
        $params = (array) $params;

        $obj = parent::processObject($obj, $params);

        if (
            (isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1')
        ) {
            $obj->status_text = Status::GL($obj->status);

            $obj->canDelete = $obj->_canDelete();
        }


        return $obj;
    }


    // ============================================================================
    public function _canDelete()
    {
        $t = parent::_canDelete();
        if (!$t) {
            return false;
        }
        return true;
    }


    // ============================================================================
    public static function get_paynetwallet($force = false)
    {
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        if (!$force) $f['_where']['isdefault'] = 1;
        $f['_limit'] = 1;

        $all = Paynetwallet::_getAll($f, array('_full' => '1'));
        if (count($all)) {
            return reset($all);
        }

        if (!$force)
            return self::get_paynetwallet(true);

        return null;
    }
}