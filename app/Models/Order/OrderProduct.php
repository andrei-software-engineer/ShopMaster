<?php

namespace App\Models\Order;


use Orchid\Screen\AsSource;
use App\Models\Base\Status;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use App\Models\Base\BaseModel;
use App\Models\Product\Product;
use Orchid\Filters\Types\Like;


class OrderProduct extends BaseModel 
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
       self::$MainObj = new OrderProduct;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'orderproducts';

    public $timestamps = false;
    

    protected $fillable = [
        'id',
        'idorder',
        'idproduct',
        'type',
        'quantity',
        'description',
        'pricewoutvat',
        'real_pricewotvat',
        'discount_percent',
        'discount_value',
        'real_vat',
        'real_price',

        'total_real_pricewotvat',
        'total_discount_value',
        'total_real_vat',
        'total_real_price',
        'total_achitat',
        'total_datorie',

        'status',
        'paystatus',
        'idpaymethod',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idorder',
        'idproduct',
        'type',
        'quantity',
        'description',
        'pricewoutvat',
        'real_pricewotvat',
        'discount_percent',
        'discount_value',
        'real_vat',
        'real_price',
        'total_real_pricewotvat',
        'total_discount_value',
        'total_real_vat',
        'total_real_price',
        'total_achitat',
        'total_datorie',
        'status',
        'paystatus',
        'idpaymethod',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idorder',
        'idproduct',
        'type',
        'quantity',
        'description',
        'pricewoutvat',
        'real_pricewotvat',
        'discount_percent',
        'discount_value',
        'real_vat',
        'real_price',
        'total_real_pricewotvat',
        'total_discount_value',
        'total_real_vat',
        'total_real_price',
        'total_achitat',
        'total_datorie',
        'status',
        'paystatus',
        'idpaymethod',
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
            $obj->status_text = Status::GL($obj->status);
            $obj->paystatus_obj = Status::GL($obj->paystatus);
            $obj->canDelete = $obj->_canDelete();
            $obj->productObj= Product::_get($obj->idproduct, array('_full' => '1', '_musttranslate' => 1));
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