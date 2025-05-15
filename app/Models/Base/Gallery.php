<?php

namespace App\Models\Base;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use App\Models\Base\Status;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\SystemFile;

class Gallery extends BaseModel 
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
       self::$MainObj = new Gallery;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'gallery';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'status',
        'parentmodel',
        'isdefault',
        'idsystemfile',
        'ordercriteria',
        'parentmodelid',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'status',
        'parentmodel',
        'isdefault',
        'idsystemfile',
        'ordercriteria',
        'parentmodelid',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'status',
        'parentmodel',
        'isdefault',
        'idsystemfile',
        'ordercriteria',
        'parentmodelid',
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
    ];

    public function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1')) 
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->yesno_text = Status::GL($obj->isdefault);
            $obj->canDelete = $obj->_canDelete();

            $obj->systemfileobj = SystemFile::GETFILE($obj->idsystemfile);
            $obj->url = SystemFile::cdnUrl($obj->idsystemfile);

            if ($obj->systemfileobj)
            {
                $obj->name_show = (isset($obj->_name) && $obj->_name) ? $obj->_name : $obj->systemfileobj->name;
            } else{
                $obj->name_show = $obj->_name;
            }
        }
        
        return $obj;
    }

    public function _setParams() {
        if (!$this) return;
        $this->_setMediaParams();
    }

    public function _delete(){
        $this->processObject($this, ['_admin' => '1']);
        if ($this->systemfileobj) $this->systemfileobj->_delete();

        return parent::_delete();
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