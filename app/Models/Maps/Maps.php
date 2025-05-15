<?php

namespace App\Models\Maps;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use App\Models\Base\BaseModel;
use Orchid\Filters\Types\Like;

class Maps extends BaseModel 
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
       self::$MainObj = new Maps;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'maps';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lat',
        'lng',
        'status',
        'typecontactpoint',

    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'lat',
        'lng',
        'status',
        'typecontactpoint',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'lat',
        'lng',
        'status',
        'typecontactpoint',
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
            $obj->type_text = Status::GL($obj->typecontactpoint);
            $obj->iconpath = '';
            $obj->cluster = false;
            $obj->dburl = false;
            $obj->infowindow = view('BaseSite.Contacts.infowindow', ['obj' => $obj]);
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


    public function getCacheLifeTime()
    {
        return 0;
    }

}