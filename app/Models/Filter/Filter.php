<?php

namespace App\Models\Filter;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Status;

class Filter extends BaseModel 
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
       self::$MainObj = new Filter;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'filter';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'orderctireatia',
        'type',
        'minValue',
        'maxValue',
        'status',
        'identifier',
        'partener',
        'partenerid',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'orderctireatia',
        'type',
        'minValue',
        'maxValue',
        'status',
        'identifier',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'orderctireatia',
        'type',
        'minValue',
        'maxValue',
        'status',
        'identifier',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('identifier', 'type'),
        array('partener', 'partenerid'),
    ];

    protected $_words = [
        '_name',
    ];


    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->filter_type = Status::GL($obj->type);
            
            $obj->canDelete = $obj->_canDelete();
        }

        return $obj;
    }

    public function _setParams() {
        if (!$this) return;
        $this->_setMediaParams();
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