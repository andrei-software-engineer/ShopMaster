<?php

namespace App\Models\ProductCategory;

use App\Models\Auto\SpecialFilterAuto;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;

class ProductSpecialFilterAuto extends BaseModel 
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
       self::$MainObj = new ProductSpecialFilterAuto;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'product_special_filter';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idspecialfilterauto',
        'idproduct',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idspecialfilterauto',
        'idproduct',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idspecialfilterauto',
        'idproduct',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('idspecialfilterauto', 'idproduct'),
    ];


    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        $obj = parent::processObject($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->specialFilter = SpecialFilterAuto::_get($obj->idmodificationauto, array('_full'=> 1));
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