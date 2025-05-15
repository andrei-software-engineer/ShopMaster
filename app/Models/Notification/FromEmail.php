<?php

namespace App\Models\Notification;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;


class FromEmail extends BaseModel 
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
       self::$MainObj = new FromEmail;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'from_email';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'email',
        'password',
        'smtphost',
        'smtpport',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'email',
        'password',
        'smtphost',
        'smtpport',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'email',
        'password',
        'smtphost',
        'smtpport',
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