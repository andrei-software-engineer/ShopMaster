<?php

namespace App\Models\InfoUser;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;

class InfoUser extends BaseModel 
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
       self::$MainObj = new InfoUser;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'infouser';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'iduser',
        'nume',
        'prenume',
        'phone',
        'mobil',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'iduser',
        'nume',
        'prenume',
        'phone',
        'mobil',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'iduser',
        'nume',
        'prenume',
        'phone',
        'mobil',
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

    public static function defaultParams()
    {
        $obj = new InfoUser();
        
        $obj->nume = '';
        $obj->prenume = '';
        $obj->phone = '';
        $obj->mobil = '';

        return $obj;
    }

    public function _setParams() {
        if (!$this) return;
        $this->_setUserParent();
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