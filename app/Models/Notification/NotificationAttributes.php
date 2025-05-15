<?php

namespace App\Models\Notification;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;

class NotificationAttributes extends BaseModel 
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
       self::$MainObj = new NotificationAttributes;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'notification_attributes';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idnotification',
        'key',
        'value'
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idnotification',
        'key',
        'value'
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idnotification',
        'key',
        'value'
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