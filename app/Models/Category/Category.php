<?php

namespace App\Models\Category;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Slug;


class Category extends BaseModel
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
        self::$MainObj = new Category;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'category';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idparent',
        'code',
        'order',
        'status',
        'fixed',
        'level',
        'partener',
        'partenerid',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idparent',
        'code',
        'order',
        'status',
        'fixed',
        'level',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idparent',
        'code',
        'order',
        'status',
        'fixed',
        'level',
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
        '_title',
        '_author',
        '_slug',
        '_author_meta',
    ];

    protected $_texts = [
        '_description',
        '_key_meta',
        '_description_meta',
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);
        $obj = parent::processObjectMeta($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->pagetype_text = Status::GL($obj->pagetype);
            $obj->canDelete = $obj->_canDelete();
        }

        if (
            (isset($params['_withChildren']) && $params['_withChildren'] == '1')
        ) {
            $f = array();
            $f['_where']['status'] = Status::ACTIVE;
            $f['_where']['idparent'] = $obj->id;
            $obj->_childrens = self::_getAll($f, $params);

        }

        // dd($obj);

        $obj->title_show = $obj->_title;
        $obj->url = Slug::prepareUrl('', $obj->id, 'web.category');
        
        return $obj;
    }

    public function _setParams()
    {
        if (!$this) return;
        $this->_setParamsParent();
    }

    public function _canDelete()
    {       
        $t =  parent::_canDelete();

        if(!$t){
            return false;
        }
        $f = array();
        $f['_where']['idparent'] = $this->id;
        $obj = self::_getCount($f);

        if($obj > 0){
            return false;
        }
        return true;
    }
}