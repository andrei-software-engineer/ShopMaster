<?php

namespace App\Models\Allegro;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\DT;
use App\Models\Base\Slug;
use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AlgSettings extends BaseModel
{
    const PL_LANG_ID = 126;
    const EN_LANG_ID = 39;
    const PARTENER_ID = 'allegro';
    const CHANGE_CATEGORIES_CREATED_ID = 'CHANGE_CATEGORIES_CREATED_ID';
    const PROCESS_PRODUCTS_CURRENT_CATEGORYID = 'PROCESS_PRODUCTS_CURRENT_CATEGORYID';
    const PROCESS_PRODUCTS_CURRENT_NEXTPAGEID = 'PROCESS_PRODUCTS_CURRENT_NEXTPAGEID';
    const PROCESS_PRODUCTS_CURRENT_PRODUCTID = 'PROCESS_PRODUCTS_CURRENT_PRODUCTID';

    use RoleAccess, Filterable, AsSource, Chartable;

    /**
     * @var array
     */

    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj) return self::$MainObj;
        self::$MainObj = new AlgSettings;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'algsettings';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'config',
        'value',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        'config',
    ];
    protected $_words = [
        
    ];
    protected $_texts = [
        
    ];


    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        return $obj;
    }

    protected static function getConfigObj($config)
    {
        $f = [];
        $f['_where']['config'] = $config;
        $f['_limit'] = 1;

        $objects = AlgSettings::_getAll($f);
        if (!count($objects)) 
        {
            $obj = new AlgSettings;
            return $obj;
        }

        $obj = reset($objects);
        return $obj;
    }

    public static function getConfig($config)
    {
        $obj = self::getConfigObj($config);
        if (!$obj->id) return '';
        return $obj->value;
    }

    public static function saveConfig($config, $value)
    {
        $obj = self::getConfigObj($config);
        $obj->config = $config;
        $obj->value = $value;
        $obj->_save();
        return $obj;
    }
}