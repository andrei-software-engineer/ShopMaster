<?php

namespace App\Models\Notification;

use App\Models\Base\Attachements;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Status;

class Notification extends BaseModel 
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
       self::$MainObj = new Notification;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'notification';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'parentmodel',
        'parentmodelid',
        'type',
        'destination',
        'date',
        'priority',
        'idtemplate',
        'status',
        'datetosend',
        'minitimetosend',
        'maxtimetosend',
        'idlang',
        'idfiles',
        'deletefiles',
        'prepareddata',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'uuid',
        'status',
        'name',
        'email',
        'phone',
        'criteria',
        'group',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'uuid',
        'status',
        'name',
        'email',
        'phone',
        'criteria',
        'group',
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
        }

        return $obj;
    }

    public function _delete(){

        $attributes = NotificationAttributes::_getAll(); 

        foreach($attributes as $item)
        {
            $item->delete();
        }
        
        parent::delete();
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