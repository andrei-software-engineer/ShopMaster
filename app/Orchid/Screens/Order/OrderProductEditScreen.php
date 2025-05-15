<?php

namespace App\Orchid\Screens\Order;

use App\GeneralClasses\FromMyRelation;
use App\Models\Base\Status;
use App\Models\Order\Order;
use App\Models\Order\OrderForm;
use App\Models\Order\OrderProduct;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\BaseEditScreen;

class OrderProductEditScreen extends BaseEditScreen
{
    /**
     * @var Order
     */
    public $obj;

    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = OrderProduct::GetObj();
    }

    /**
     * Query data.
     *
     * @param Order $obj
     *
     * @return array
     */
    public function query(OrderProduct $obj): array
    {
        return parent::_query($obj);
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        $order_product_type = Status::GA('order_product_type');
        $str_arr =  explode(".", Route::currentRouteName());

        $x = [];

        $x[] =  Input::make('obj._requestInfo')->set('hidden', true);

        
        if($str_arr[2] == "create"){

            $x[] = FromMyRelation::make('obj.idproduct')
                ->fromModel(Product::class, '_name')
                ->title('Select product');

        }else {
            $idprod = request()->get('idproduct');
            if($idprod){
                $product = Product::_get($idprod, array('_admin' => '1', '_musttranslate' => 1));

                $x[] = Input::make('Product')
                ->value($product->_name)
                ->class('js_CA_enter form-control')
                ->title(_GLA('TI_product'))
                ->id($this->obj->_getAdminId('product'));
            }
            
        };

        $x[] =  Select::make('obj.type')
            ->options($order_product_type)
            ->class('js_CA_select')
            ->title(_GLA('TI_order_product_type'))
            ->id($this->obj->_getAdminId('order_product_type'))
            ->placeholder(_GLA('PH_select order_product_type'));
        
            $x[] = Input::make('obj.quantity')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_quantity'))
            ->id($this->obj->_getAdminId('quantity'))
            ->placeholder(_GLA('PH_set quantity'));


        $x[] = Input::make('obj.pricewoutvat')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_pricewoutvat'))
            ->id($this->obj->_getAdminId('pricewoutvat'))
            ->placeholder(_GLA('PH_set pricewoutvat'));

        $x[] = Input::make('obj.real_pricewotvat')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_real_pricewotvat'))
            ->id($this->obj->_getAdminId('real_pricewotvat'))
            ->placeholder(_GLA('PH_set real_pricewotvat'));

        $x[] = Input::make('obj.discount_percent')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_discount_percent'))
            ->id($this->obj->_getAdminId('discount_percent'))
            ->placeholder(_GLA('PH_set discount_percent'));

        $x[] = Input::make('obj.discount_value')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_discount_value'))
            ->id($this->obj->_getAdminId('discount_value'))
            ->placeholder(_GLA('PH_set discount_value'));

        $x[] = Input::make('obj.real_vat')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_real_vat'))
            ->id($this->obj->_getAdminId('real_vat'))
            ->placeholder(_GLA('PH_set real_vat'));

        $x[] = Input::make('obj.real_price')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_real_price'))
            ->id($this->obj->_getAdminId('real_price'))
            ->placeholder(_GLA('PH_set real_price'));

        $x[] = Input::make('obj.total_real_pricewotvat')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_total_real_pricewotvat'))
            ->id($this->obj->_getAdminId('total_real_pricewotvat'))
            ->placeholder(_GLA('PH_set total_real_pricewotvat'));

        $x[] = Input::make('obj.total_discount_value')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_total_discount_value'))
            ->id($this->obj->_getAdminId('total_discount_value'))
            ->placeholder(_GLA('PH_set total_discount_value'));

        $x[] = Input::make('obj.total_real_vat')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_total_real_vat'))
            ->id($this->obj->_getAdminId('total_real_vat'))
            ->placeholder(_GLA('PH_set total_real_vat'));

        $x[] = Input::make('obj.total_real_price')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_total_real_price'))
            ->id($this->obj->_getAdminId('total_real_price'))
            ->placeholder(_GLA('PH_set total_real_price'));

        $x[] = Input::make('obj.total_achitat')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_total_achitat'))
            ->id($this->obj->_getAdminId('total_achitat'))
            ->placeholder(_GLA('PH_set total_achitat'));

        $x[] = Input::make('obj.total_datorie')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_total_datorie'))
            ->id($this->obj->_getAdminId('total_datorie'))
            ->placeholder(_GLA('PH_set total_datorie'));
        
        $x[] = Input::make('obj.description')
            ->class('js_CA_enter form-control')
            ->set('data-click', '#UpdateButton')
            ->title(_GLA('TI_description'))
            ->id($this->obj->_getAdminId('description'))
            ->placeholder(_GLA('PH_set description'));


        return [
            Layout::rows($x)
        ];
    }


    /**
     * @param OrderProduct   $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(OrderProduct $obj, Request $request)
    {
        
        $t = json_decode(request()->get('obj')['_requestInfo']);
        $obj->idorder = $t->idorder;

        OrderForm::saveOrderJournal($obj, 154, 'Order product ', 0);
        
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(OrderProduct $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}
