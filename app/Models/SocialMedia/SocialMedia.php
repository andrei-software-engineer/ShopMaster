<?php

namespace App\Models\SocialMedia;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\SystemFile;

class SocialMedia extends BaseModel 
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
       self::$MainObj = new SocialMedia;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'social_media';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'status',
        'socialUrl',
        'specialClass',
        'idSystemFile',
        'ordercriteria',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'status',
        'socialUrl',
        'specialClass',
        'idSystemFile',
        'ordercriteria',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'status',
        'socialUrl',
        'specialClass',
        'idSystemFile',
        'ordercriteria',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('identifier', 'type'),
    ];

    protected $_words = [
        '_name'
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;
        
        $obj = parent::processObject($obj, $params);
        
        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->systemfileobj = SystemFile::GETFILE($obj->idSystemFile);
            $obj->name_show = (isset($obj->_name) && $obj->_name) ? $obj->_name : '';
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

    // public function _delete(){
    //     $this->processObject($this, ['_admin' => '1']);
    //     if ($this->systemfileobj) $this->systemfileobj->_delete();

    //     return parent::_delete();
    // }
}