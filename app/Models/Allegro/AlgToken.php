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

class AlgToken extends BaseModel
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
        self::$MainObj = new AlgToken;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'algtoken';

    public $timestamps = false;

    protected $fillable = [
        'id',

        'clientid',
        'clientsecret',

        'access_token',
        'token_type',
        'refresh_token',

        'expires_in',
        'avaible_date',

        'scope',
        'allegro_api',
        'jti',
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
}