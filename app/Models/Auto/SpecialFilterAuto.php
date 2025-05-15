<?php

namespace App\Models\Auto;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;


class SpecialFilterAuto extends BaseModel
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
        self::$MainObj = new SpecialFilterAuto;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'specialfilterauto';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'parentmodel',
        'parentmodelid',
        'idSpecialFilter',
    ];

    
    protected $allowedFilters = [
        'id' => Like::class,
        'parentmodel',
        'parentmodelid',
        'idSpecialFilter',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'parentmodel',
        'parentmodelid',
        'idSpecialFilter',
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
            $obj->specialFilter_text = Status::GL($obj->idSpecialFilter);

        }
        return $obj;
    }

    public function _setParams() {
        if (!$this) return;
        $this->_setMediaParams();
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