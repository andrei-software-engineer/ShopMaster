<?php

namespace App\Models\Faq;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;


class FaqResponses extends BaseModel 
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
       self::$MainObj = new FaqResponses;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'faqresponses';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idfaq',
        'status',
        'ordercriteria'
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idfaq',
        'status',
        'ordercriteria'
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idfaq',
        'status',
        'ordercriteria'
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
        '_slug'
    ];

    protected $_texts = [
        '_description'
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->title_show = $obj->_title;
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