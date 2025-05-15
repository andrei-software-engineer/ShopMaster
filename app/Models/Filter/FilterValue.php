<?php

namespace App\Models\Filter;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Slug;
use App\Models\Base\Status;

class FilterValue extends BaseModel 
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
        self::$MainObj = new FilterValue;
        return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'filtervalue';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idfilter',
        'orderctireatia',
        'status',
        'partener',
        'partenerid',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idfilter',
        'orderctireatia',
        'status',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idfilter',
        'orderctireatia',
        'status',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
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
            $filter = Filter::_get($obj->idfilter, array('_admin' => '1','_musttranslate' => 1,  'usecache' => '1'));
            $obj->filter_identifier = ($filter && $filter->identifier) ? $filter->identifier : 'nu exista ';

            $obj->url = route('web.product.list', ['filter['.$obj->idfilter.']' => $obj->id]);
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