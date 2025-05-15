<?php

namespace App\Models\Favorite;

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

class Favorite extends BaseModel
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
        self::$MainObj = new Favorite;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'favorite';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'iduser',
        'idproduct',
        'add_date',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'iduser',
        'idproduct',
        'add_date',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'iduser',
        'idproduct',
        'add_date',
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
            $product = Product::_get($obj->idproduct, array('_admin' => '1','_musttranslate' => 1));
            $obj->product_name = ($product && $product->_name) ? $product->_name : 'nu exista ';
            $obj->productObj = $product;

            $getUser = User::findOrFail($obj->iduser);
            $obj->adminName = ($getUser && $getUser->name) ? $getUser->name : 'nu exista ';
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
}