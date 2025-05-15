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

class AlgParameter extends BaseModel
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
        self::$MainObj = new AlgParameter;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'algparameter';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idallegro',

        'name',
        'type',
        'required',
        'requiredForProduct',
        'requiredIf',
        'displayedIf',
        'unit',
        'options',
        'restrictions',

        'levelprocess',
        'infoprocess',
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
        'idallegro',
    ];


    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        return $obj;
    }
}