<?php

namespace App\Models\Order;


use Orchid\Screen\AsSource;
use App\Models\Base\Status;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use App\Models\Base\BaseModel;
use App\Models\Base\DT;
use Orchid\Filters\Types\Like;


class OrderJurnal extends BaseModel 
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
       self::$MainObj = new OrderJurnal;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'orderjurnal';

    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'idorder',
        'data',
        'orderjurnaltype',
        'idrole',
        'iduser',
        'status',
        'paystatus',
        'idpaymethod',
        'note',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idorder',
        'data',
        'orderjurnaltype',
        'idrole',
        'iduser',
        'status',
        'paystatus',
        'idpaymethod',
        'note',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idorder',
        'data',
        'orderjurnaltype',
        'idrole',
        'iduser',
        'status',
        'paystatus',
        'idpaymethod',
        'note',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('identifier', 'type'),
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->canDelete = $obj->_canDelete();
            $obj->data_text =DT::GDT_T($obj->data, true, DT::DATE_ROMANIAN);
            $obj->orderjurnaltype_text = Status::GL($obj->orderjurnaltype);
            $obj->paystatus_text = Status::GL($obj->paystatus);
            
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