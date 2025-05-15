<?php

namespace App\Models\Product;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use App\Models\Base\Slug;
use App\Models\Favorite\Favorite;
use Illuminate\Support\Facades\Auth;

class Product extends BaseModel 
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
       self::$MainObj = new Product;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'product';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'code',
        'order',
        'status',
        'fixed',
        'partener',
        'partenerid',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'code',
        'order',
        'status',
        'fixed',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'code',
        'order',
        'status',
        'fixed',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
    ];

    protected $_words = [
        '_name',
        '_title',
        '_author',
        '_slug',
        '_author_meta',
    ];

    protected $_texts = [
        '_description',
        '_key_meta',
        '_description_meta',
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;
        $obj = parent::processObject($obj, $params);
        $obj = parent::processObjectMeta($obj, $params);

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
            $obj->status_text = Status::GL($obj->status);
            $obj->pagetype_text = Status::GL($obj->pagetype);

                
            $f = array();
            $f['_where']['idproduct'] = $this->id;
            $f['_where']['status'] = Status::ACTIVE;

            $obj->offersObj = Offer::_getAll($f, array('_full' => '1', '_musttranslate' => 1, '_usecache' => '0'));

            $obj->title_show = $obj->_title;

            if(request()->get('filter')){
                $params = array();
                $params['id'] = $obj->id;
                $params['filter'] = request()->get('filter');
                $obj->url = route('web.product', $params);  
            }else{
                $obj->url = Slug::prepareUrl('', $obj->id, 'web.product');  
            }
            
            $obj->price = $this->processPrice(1, $obj->id);

            $obj->canDelete = $obj->_canDelete();
            
            $obj->isInFavorite = false;
            if(Auth::check()){
                $xc = array();
                $xc['_where']['iduser'] = Auth::user()->id;
                $xc['_where']['idproduct'] = $this->id;
    
                if(Favorite::_getCount($xc) >= 1){
                    $obj->isInFavorite = true;
                }
                else{
                    $obj->isInFavorite = false;
                }
            }

        }



        return $obj;
    }

    public function _setParams() {
        if (!$this) return;
        $this->_setParamsParent();
    }

    public function processPrice($quantity = 1){
        $price = 0;

        foreach($this->offersObj as $item){
            $price = $item->real_price;
        }

        // temporar
        if (!$price)
        {
            $price = rand(1000, 10000) / 100;
        }

        return $price;
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