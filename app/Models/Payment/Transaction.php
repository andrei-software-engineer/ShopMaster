<?php

namespace App\Models\Payment;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\DT;

class Transaction extends BaseModel
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
        self::$MainObj = new Transaction;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'transaction';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'date',
        'status',
        'iduser',
        'idparentclass',
        'parentclass',
        'value',
        'value_bilant',
        'documentclass',
        'iddocument',
        'notes',
        'type',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'date',
        'status',
        'iduser',
        'idparentclass',
        'parentclass',
        'value',
        'value_bilant',
        'documentclass',
        'iddocument',
        'notes',
        'type',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'date',
        'status',
        'iduser',
        'idparentclass',
        'parentclass',
        'value',
        'value_bilant',
        'documentclass',
        'iddocument',
        'notes',
        'type',
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