<?php

namespace App\Models\Payment;

use App\Models\Base\DT;
use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;

class Paynettransaction extends BaseModel
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
        self::$MainObj = new Paynettransaction;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'paynettransaction';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'parentclass',
        'idparentclass',
        'idpaynetwallet',
        'status',
        'tr_amount',
        'site_amount',
        'date',
        'EventType',
        'PaymentSaleAreaCode',
        'PaymentCustomer',
        'PaymentStatusDate',
        'PaymentAmount',
        'PaymentMerchant',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'parentclass',
        'idparentclass',
        'idpaynetwallet',
        'status',
        'tr_amount',
        'site_amount',
        'date',
        'EventType',
        'PaymentSaleAreaCode',
        'PaymentCustomer',
        'PaymentStatusDate',
        'PaymentAmount',
        'PaymentMerchant',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'parentclass',
        'idparentclass',
        'idpaynetwallet',
        'status',
        'tr_amount',
        'site_amount',
        'date',
        'EventType',
        'PaymentSaleAreaCode',
        'PaymentCustomer',
        'PaymentStatusDate',
        'PaymentAmount',
        'PaymentMerchant',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('partener', 'partenerid'),
    ];



    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->date_d = DT::GDT_T($obj->date, true, DT::DATE_ROMANIAN);
            
            $obj->canDelete = $obj->_canDelete();
        }

        
        return $obj;
    }



    public function _canDelete()
    {       
        $t =  parent::_canDelete();
        if(!$t){
            return false;
        }
        return true;
    }
}