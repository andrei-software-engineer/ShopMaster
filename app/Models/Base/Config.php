<?php

namespace App\Models\Base;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Auth;

class Config extends BaseModel 
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
       self::$MainObj = new Config;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'configs';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'identifier',
        'value',
        'comments',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'identifier',
        'value',
        'comments',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'identifier',
        'value',
        'comments',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        'identifier',
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if (isset($params['_admin']) && $params['_admin'] == '1')
        {
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

    
    // -----------------------------------------------
    
	protected static function prepareKey($key)
	{
		$key = preg_replace('/\s+/', '_', $key);
		$key = preg_replace('/[^a-zA-Z0-9_]/', '', $key);
		$key = strtolower($key);
		return $key;
	}

    protected static function saveConfig($key)
	{
        $tobj = self::GetObj();

        $tobj->identifier = $key;
        $tobj->value = 10;
        $tobj->comments = '';

        $tobj->_save();

        return $tobj->value;
    }

    public static function getConfig($key)
	{
        $key = self::prepareKey($key);
        if (!$key) return '10';

        $tobj = Config::GetObj()->where('identifier', $key)->first();

        
        if ($tobj == null) {
            return self::saveConfig($key);
        }

        return $tobj->value;
	}

    public static function CGC($identifier){
        return  self::getConfig($identifier);
    }
}
    
