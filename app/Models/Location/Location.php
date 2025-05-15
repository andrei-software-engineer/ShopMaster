<?php

namespace App\Models\Location;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\SystemFile;

class Location extends BaseModel 
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
       self::$MainObj = new Location;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'location';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idparent',
        // 'code',
        'level',
        'status',
        'order',
        'shortname',
        'idlogo',
        'price',
        'isdefault',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idparent',
        // 'code',
        'level',
        'status',
        'order',
        'shortname',
        'idlogo',
        'price',
        'isdefault',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idparent',
        // 'code',
        'level',
        'status',
        'order',
        'shortname',
        'idlogo',
        'price',
        'isdefault',
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
        '_urlsuffix'
    ];


    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->default = Status::GL($obj->isdefault);

            $obj->systemfileobj = SystemFile::GETFILE($obj->idlogo);
            $obj->url = SystemFile::cdnUrl($obj->idlogo);
            $obj->canDelete = $obj->_canDelete();

            if ($obj->systemfileobj)
            {
                $obj->name_show = (isset($obj->_name) && $obj->_name) ? $obj->_name : $obj->systemfileobj->name;
            } else{
                $obj->name_show = $obj->_name;
            }

        }

        if((isset($params['_withChildren']) && $params['_withChildren'] == '1'))
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