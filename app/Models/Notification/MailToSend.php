<?php

namespace App\Models\Notification;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;

class MailToSend extends BaseModel 
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
       self::$MainObj = new MailToSend;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'mailtosend';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idsubscription',
        'idemailtemplate',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idsubscription',
        'idemailtemplate',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idsubscription',
        'idemailtemplate',
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
            $subscription = Subscription::_get($obj->idsubscription, array('_admin' => '1'));
            $obj->subscription_group = ($subscription && $subscription->group) ? $subscription->group : 'nu exista ';
            $obj->subscription_email = ($subscription && $subscription->email) ? $subscription->email : 'nu exista ';

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