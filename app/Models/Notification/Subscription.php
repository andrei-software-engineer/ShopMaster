<?php

namespace App\Models\Notification;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Status;
use Illuminate\Support\Facades\DB;

class Subscription extends BaseModel 
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
       self::$MainObj = new Subscription;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'subscription';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'uuid',
        'status',
        'name',
        'email',
        'phone',
        'criteria',
        'group',
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

    public function _canDelete()
    {       
        $t =  parent::_canDelete();
        if(!$t){
            return false;
        }
        return true;
    }


    public static function getGroups(){
        
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $f['_select'][] = ['_field' => 'group'];
        
        $params = array();

        $groups = self::_getAllForSelect($f, $params, 'group', 'group');
        
        return $groups;
    }

    public static function insertToEmail($group, $id)
    {
        $model = MailToSend::GetObj();

        $pdo = DB::connection()->getPdo();

        $params = array();
        $params[':idemailtemplate'] = $id;
        $params[':status'] = Status::ACTIVE;
        $params[':group'] = $group;

        $q =  ' INSERT INTO '.$model->table.' (idsubscription, idemailtemplate)
                SELECT id AS idsubscription, :idemailtemplate AS idemailtemplate 
                FROM subscription AS tf
                WHERE 
                    tf.status = :status 
                    AND tf.group = :group ';
                    
		$rez = $pdo->prepare ($q);
		return $rez->execute($params);
    }

    public static function insertToSMS($group, $id)
    {
        $model = SmsToSend::GetObj();

        $pdo = DB::connection()->getPdo();

        $params = array();
        $params[':idsmstemplate'] = $id;
        $params[':status'] = Status::ACTIVE;
        $params[':group'] = $group;

        $q =  ' INSERT INTO '.$model->table.' (idsubscription, idsmstemplate)
                SELECT id AS idsubscription, :idsmstemplate AS idsmstemplate 
                FROM subscription AS tf
                WHERE 
                    tf.status = :status 
                    AND tf.group = :group ';
                    
		$rez = $pdo->prepare ($q);
		return $rez->execute($params);
    }
}   