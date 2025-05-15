<?php

namespace App\Orchid\Screens\Order;

use App\Models\Base\DT;
use App\Models\Base\Status;
use App\Models\Product\Offer;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;
use Orchid\Screen\Fields\DateTimer;

class OfferEditScreen extends BaseEditScreen
{
    /**
     * @var Offer
     */
    public $obj;

    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Offer::GetObj();
    }

    /**
     * Query data.
     *
     * @param Offer $obj
     *
     * @return array
     */
    public function query(Offer $obj): array
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
        $offer_status = Status::GA('general_status');
        $x = [];


        $x[] = Input::make('obj.idproduct')->set('hidden', true);

        $x[] = Input::make('obj._requestInfo')->set('hidden', true);

        $x[] = Select::make('obj.status')->options($offer_status)->class('js_CA_select')->title(_GLA('TI_status'))->id($this->obj->_getAdminId('status'))->placeholder(_GLA('PH_select status'));

        $x[] = Input::make('obj.priority')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('integer')->title(_GLA('TI_priority'))->id($this->obj->_getAdminId('priority'))->placeholder(_GLA('PH_set priority'));

        $x[] = Input::make('obj.minq')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('integer')->title(_GLA('TI_minq'))->id($this->obj->_getAdminId('minq'))->placeholder(_GLA('PH_set minq'));

        $x[] = Input::make('obj.maxq')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('integer')->title(_GLA('TI_maxq'))->id($this->obj->_getAdminId('maxq'))->placeholder(_GLA('PH_set maxq'));

        $x[] = Input::make('obj.pricewoutvat')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('integer')->title(_GLA('TI_pricewoutvat'))->id($this->obj->_getAdminId('pricewoutvat'))->placeholder(_GLA('PH_set pricewoutvat'));

        $x[] = Input::make('obj.real_pricewotvat')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('integer')->title(_GLA('TI_real_pricewotvat'))->id($this->obj->_getAdminId('real_pricewotvat'))->placeholder(_GLA('PH_set real_pricewotvat'));

        $x[] = Input::make('obj.discount_percent')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('integer')->title(_GLA('TI_discount_percent'))->id($this->obj->_getAdminId('discount_percent'))->placeholder(_GLA('PH_set discount_percent'));

        $x[] = Input::make('obj.discount_value')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('integer')->title(_GLA('TI_discount_value'))->id($this->obj->_getAdminId('discount_value'))->placeholder(_GLA('PH_set discount_value'));

        $x[] = Input::make('obj.vatcote')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('integer')->title(_GLA('TI_vatcote'))->id($this->obj->_getAdminId('vatcote'))->placeholder(_GLA('PH_set vatcote'));

        $x[] = Input::make('obj.real_vat')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('integer')->title(_GLA('TI_real_vat'))->id($this->obj->_getAdminId('real_vat'))->placeholder(_GLA('PH_set real_vat'));

        $x[] = Input::make('obj.real_price')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('integer')->title(_GLA('TI_real_price'))->id($this->obj->_getAdminId('real_price'))->placeholder(_GLA('PH_set real_price'));

        $x[] = DateTimer::make('startdate_d')->value($this->obj->startdate_d)->title('Start date')->format('d.m.Y');

        $x[] = DateTimer::make('enddate_d')->value($this->obj->enddate_d)->title('End date')->format('d.m.Y');
        
        return [
            Layout::rows($x)
        ];
    }

    /**
     * @param Offer   $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Offer $obj, Request $request)
    {
        $x = request()->request;

        $obj->start_date = ($x->get('startdate_d')) ? DT::toTimeStamp($x->get('startdate_d') . ' 00:00:00') : null;
        $obj->end_date = ($x->get('enddate_d')) ? DT::toTimeStamp($x->get('enddate_d') . ' 23:59:59') : null;

        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Offer $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}
