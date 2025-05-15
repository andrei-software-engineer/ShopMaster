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

class Paynettransactionjurnal extends BaseModel
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
        self::$MainObj = new Paynettransactionjurnal;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'paynettransactionjurnal';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idpaynettransaction',
        'date',
        'transactionjurnaltype',
        'idrole',
        'iduser',
        'status',
        'note',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idpaynettransaction',
        'date',
        'transactionjurnaltype',
        'idrole',
        'iduser',
        'status',
        'note',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idpaynettransaction',
        'date',
        'transactionjurnaltype',
        'idrole',
        'iduser',
        'status',
        'note',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
    ];



    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->paynet_transaction_text = Status::GL($obj->transactionjurnaltype);
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