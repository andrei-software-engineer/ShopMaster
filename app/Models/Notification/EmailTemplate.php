<?php

namespace App\Models\Notification;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Slug;
use App\Models\Base\Status;

class EmailTemplate extends BaseModel 
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
       self::$MainObj = new EmailTemplate;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'emailtemplate';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'identifier',
        'status',
        'toemail',
        'idfromemail',
        'replyto',
        'cc',
        'bcc',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'identifier',
        'status',
        'toemail',
        'idfromemail',
        'replyto',
        'cc',
        'bcc',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'identifier',
        'status',
        'toemail',
        'idfromemail',
        'replyto',
        'cc',
        'bcc',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        'identifier',
    ];
    protected $_words = [
        '_subject',
        '_fromname',
        '_toname',
    ];

    protected $_texts = [
        '_message',
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->url = Slug::prepareUrl('', $obj->id, 'notification.previewEmailTemplate');  
            $obj->canDelete = $obj->_canDelete();
        }

        return $obj;
    }

    public static function getIdFromIdentifier($identifier)
    {
        $f = array();
        $f['_where'] = array('identifier' => $identifier);

        $all = self::_getAll($f);
        if (count($all))
        {
            $t = reset($all);
            return $t->id;
        }

        $obj = self::GetObj();
        $obj->identifier = $identifier;
        $obj->status = Status::INACTIVE;
        $obj->_save();
        return $obj->id;
    }

    public static function getParamsFromIdentifier($identifier)
    {
        $rez = array();

        if ($identifier == 'commandform')
        {
            $rez['##name##'] = 'name';
            $rez['##phone##'] = 'phone';
            $rez['##email##'] = 'email';
            $rez['##message##'] = 'message';
            $rez['##replyto##'] = 'replyto';    
        }

        if ($identifier == 'reset_password')
        {
            $rez['##resetcode##'] = 'resetcode';
            $rez['##reseturl##'] = 'reseturl';
            $rez['##email##'] = 'email';
        }
        
        if ($identifier == 'validate_email')
        {
            $rez['##resetcode##'] = 'resetcode';
            $rez['##reseturl##'] = 'reseturl';
            $rez['##email##'] = 'email';
        }
        
        if ($identifier == 'orderform')
        {
            $rez['##status_name##'] = 'status_name';
        }

        return $rez;
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