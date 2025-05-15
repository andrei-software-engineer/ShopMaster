<?php

namespace App\Models\Order;


use Orchid\Screen\AsSource;
use App\Models\Base\Status;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use App\Models\Base\BaseModel;
use App\Models\Base\DT;
use App\Models\Base\SystemFile;
use Orchid\Filters\Types\Like;


class OrderMessage extends BaseModel 
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
       self::$MainObj = new OrderMessage;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'ordermessage';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idorder' ,
        'visibilitytype' ,
        'ordermessagetype' ,
        'data' ,
        'message' ,
        'idfile' 
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idorder' ,
        'visibilitytype' ,
        'ordermessagetype' ,
        'data' ,
        'message' ,
        'idfile' 
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idorder' ,
        'visibilitytype' ,
        'ordermessagetype' ,
        'data' ,
        'message' ,
        'idfile' 
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
            $obj->systemfileobj = SystemFile::GETFILE($obj->idfile);
            $obj->url_file = SystemFile::cdnUrl($obj->idfile);
            $obj->canDelete = $obj->_canDelete();

            $obj->data_text =DT::GDT_T($obj->data, true, DT::DATE_ROMANIAN);
            $obj->visibilitytype_text = Status::GL($obj->visibilitytype);
            $obj->messagetype_text = Status::GL($obj->ordermessagetype);
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