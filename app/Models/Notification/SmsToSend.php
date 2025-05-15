<?php

namespace App\Models\Notification;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;

class SmsToSend extends BaseModel 
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
       self::$MainObj = new SmsToSend;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'smstosend';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idsubscription',
        'idsmstemplate',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idsubscription',
        'idsmstemplate',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idsubscription',
        'idsmstemplate',
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
            $subscription = Subscription::_get($obj->idsubscription, array('_admin' => '1','_musttranslate' => 1));
            $obj->subscription_group = ($subscription && $subscription->group) ? $subscription->group : 'nu exista ';

            $sms = SmsTemplate::_get($obj->idsmstemplate, array('_admin' => '1','_musttranslate' => 1));
            $obj->sms = ($sms && $sms->_sms) ? $sms->_sms : 'nu exista ';


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