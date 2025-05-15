<?php

namespace App\Models\Base;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;

use App\Models\Page\Page;
use Illuminate\Support\Facades\Request;

class SystemMenu extends BaseModel 
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
       self::$MainObj = new SystemMenu;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'systemmenu';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idparent',
        'status',
        'section',
        'ordercriteria',
        'linktype',
        'idpage',
        'customlink',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idparent',
        'status',
        'section',
        'ordercriteria',
        'linktype',
        'idpage',
        'customlink',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idparent',
        'status',
        'section',
        'ordercriteria',
        'linktype',
        'idpage',
        'customlink',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
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
            if ($obj->linktype == Status::MENU_TYPE_CUSTOM)
            {
                $obj->url = $obj->customlink;
            } elseif ($obj->linktype == Status::MENU_TYPE_SPECIALLINK)
            {
                $obj->url = route($obj->customlink); 
            } elseif ($obj->linktype == Status::MENU_TYPE_LINKTOPAGE)
            {
                $tobj = Page::_get($obj->idpage, (array('_full' => '1')));
                $obj->url = ($tobj) ? $tobj->url : Exceptions::errorNotFoundHTML();
            } elseif ($obj->linktype == Status::MENU_TYPE_NOLINK)
            {
                $obj->url = '';
            }

            $obj->status_text = Status::GL($obj->status);
            $obj->section_text = Status::GL($obj->section);
            $obj->linktype_text = Status::GL($obj->linktype);
            $obj->canDelete = $obj->_canDelete();
            $obj->page_text = '';

            if ($obj->idpage)
            {
                $tobj = Page::_get($obj->idpage, (array('_full' => '1')));
                $obj->page_text = ($tobj) ? $tobj->_name : $obj->idpage;
            }
        }


        if (
                (isset($params['_withChildren']) && $params['_withChildren'] == '1')
            )
        {
            $f = array();
            $f['_where']['status'] = Status::ACTIVE;
            $f['_where']['idparent'] = $obj->id;
            $obj->_childrens = self::_getAll($f, $params);
        }
        return $obj;
    }

    public function _setParams() {
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