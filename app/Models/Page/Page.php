<?php

namespace App\Models\Page;

use App\GeneralClasses\GeneralCL;
use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Slug;


class Page extends BaseModel 
{
    use RoleAccess, Filterable, AsSource, Chartable;

    /**
     * @var array
     */

    // --------------------------------------------
    private static $MainObj = false;

    public function __construct()
    {
        parent::__construct();
    }
    
    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new Page;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'page';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'status',
        'fixed',
        'pagetype',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'status',
        'fixed',
        'pagetype',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'status',
        'fixed',
        'pagetype',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('identifier', 'type'),
    ];

    protected $_words = [
        '_name',
        '_title',
        '_slug',
        '_author',
        '_author_meta',
    ];

    protected $_texts = [
        '_key_meta',
        '_description_meta',
        '_description',
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
            $obj->title_show = $obj->_title;
            $obj->url_canonical = $obj->url = GeneralCL::prepareUrlById($obj->_slug, $obj->id, 'web.detail'); 
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
    