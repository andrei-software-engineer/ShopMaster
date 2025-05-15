<?php

namespace App\Models\Publicity;

use App\Models\Base\DT;
use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\SystemFile;
use App\Models\Base\SystemVideo;

class Publicity extends BaseModel 
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
       self::$MainObj = new Publicity;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'publicity';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'advsection',
        'advtype',
        'parentmodel',
        'parentmodelid',
        'status',
        'idimage',       
        'idvideo', 
        'startdate',
        'enddate',  
        'urltogo',  
        'targettype',  
        'clickeds',
        'idimagemobile',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'advsection',
        'advtype',
        'parentmodel',
        'parentmodelid',
        'status',
        'idimage',       
        'idvideo', 
        'startdate',
        'enddate',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'advsection',
        'advtype',
        'parentmodel',
        'parentmodelid',
        'status',
        'idimage',       
        'idvideo', 
        'startdate',
        'enddate',
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
            $obj->advtype_text = Status::GL($obj->advtype);
            $obj->adv_section_text = Status::GL($obj->advsection);

            $obj->systemfileobj = SystemFile::GETFILE($obj->idimage);
            $obj->systemfileobjMobile = SystemFile::GETFILE($obj->idimagemobile);
            $obj->name_show = (isset($obj->_name) && $obj->_name) ? $obj->_name : '';
            $obj->systemvideoobj = SystemVideo::GETFILE($obj->idvideo);

            $obj->startdate_d = DT::GDT_T($obj->startdate, true, DT::DATE_ROMANIAN);
            $obj->enddate_d = DT::GDT_T($obj->enddate, true, DT::DATE_ROMANIAN);
            $obj->canDelete = $obj->_canDelete();
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
        if ($this->systemvideoobj) $this->systemvideoobj->_delete();

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