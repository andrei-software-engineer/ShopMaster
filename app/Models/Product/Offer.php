<?php

namespace App\Models\Product;


use Orchid\Screen\AsSource;
use App\Models\Base\Status;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use App\Models\Base\BaseModel;
use App\Models\Base\DT;
use App\Models\Category\Category;
use Orchid\Filters\Types\Like;


class Offer extends BaseModel 
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
       self::$MainObj = new Offer;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'offer';

    public $timestamps = false;
   
    protected $fillable = [
        'id',
        'idproduct',
        'priority',
        'minq',
        'maxq',

        'pricewoutvat',
        'real_pricewotvat',
        'discount_percent',
        'discount_value',
        'real_vat',
        'real_price',
        
        'status',
        'vatcote',
        'start_date',
        'end_date',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'idproduct',
        'priority',
        'minq',
        'maxq',
        'pricewoutvat',
        'real_pricewotvat',
        'discount_percent',
        'discount_value',
        'status',
        'vatcote',
        'real_vat',
        'real_price',
        'start_date',
        'end_date',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'idproduct',
        'priority',
        'minq',
        'maxq',
        'pricewoutvat',
        'real_pricewotvat',
        'discount_percent',
        'discount_value',
        'status',
        'vatcote',
        'real_vat',
        'real_price',
        'start_date',
        'end_date',
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
        
                
        if ((isset($params['_admin']) && $params['_admin'] == '1'))
        {
            $obj->productObj = Product::_get($obj->idproduct, array('_words' => '1', '_musttranslate' => '1'));
        }
        
        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            

            $obj->startdate_d = DT::GDT_T($obj->startdate, true, DT::GD_F());
            $obj->enddate_d = DT::GDT_T($obj->enddate, true, DT::GD_F());

            $obj->canDelete = $obj->_canDelete();

        }


        return $obj;
    }


    public static function prepareOffer($idProduct, $quantity)
    {
        $f = array();
        $f['_where']['idproduct'] = $idProduct;

        
        $obj = Offer::_getAll($f);

        foreach($obj as $item)
        {
            $obj = $item;
            // nu e bine !!;
        }

        return $obj;
    }

    public function _setParams() {
        if (!$this) return;
        $this->_setOfferParams();
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