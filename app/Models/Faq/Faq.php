<?php

namespace App\Models\Faq;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Slug;


class Faq extends BaseModel 
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
       self::$MainObj = new Faq;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'faq';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'ordercriteria',
        'faqtype',
        'parentmodel',
        'parentmodelid',
        'status',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'ordercriteria',
        'faqtype',
        'parentmodel',
        'parentmodelid',
        'status',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'ordercriteria',
        'faqtype',
        'parentmodel',
        'parentmodelid',
        'status',
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
            $obj->faqtype_text = Status::GL($obj->faqtype);
            $obj->canDelete = $obj->_canDelete();
            $obj->title_show = $obj->_title;
            $obj->url_canonical = $obj->url = Slug::prepareUrl($obj->_slug, $obj->id, 'web.detail');  
        }
        
        
        if (
            (isset($params['_withChildren']) && $params['_withChildren'] == '1')
            )
            {
                
                $f = array();
                $f['_where']['status'] = Status::ACTIVE;
                $f['_where']['idfaq'] = $obj->id;

                $obj->_childrens = FaqResponses::_getAll($f, $params);
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
        $f = array();
        $f['_where']['idfaq'] = $this->id;
        $obj = FaqResponses::_getCount($f);

        if($obj > 0){
            return false;
        }
        return true;
    }
}