<?php

namespace App\Orchid\Screens\Order;

use App\Models\Base\DT;
use App\Models\Base\Status;
use App\Models\Order\Order;
use App\Models\Order\OrderForm;
use App\Models\Order\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;
use Orchid\Screen\Fields\DateTimer;

class OrderEditScreen extends BaseEditScreen
{
    /**
     * @var Order
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Order::GetObj();
    }

    /**
     * Query data.
     *
     * @param Order $obj
     *
     * @return array
     */
    public function query(Order $obj): array
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
        $pay_status = Status::GA('order_paystatus');
        $idpaymenthod_status = Status::GA('order_paymethod');
        $idmetodalivrare_status = Status::GA('order_delivery_method');
        

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),


                Select::make('obj.paystatus')
                    ->options($pay_status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_paystatus'))
                    ->id($this->obj->_getAdminId('paystatus'))
                    ->placeholder(_GLA('PH_select paystatus')),

                Select::make('obj.idpaymenthod')
                    ->options($idpaymenthod_status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_idpaymenthod'))
                    ->id($this->obj->_getAdminId('idpaymenthod'))
                    ->placeholder(_GLA('PH_select idpaymenthod')),
                    
                Select::make('obj.idmetodalivrare')
                    ->options($idmetodalivrare_status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_idmetodalivrare'))
                    ->id($this->obj->_getAdminId('idmetodalivrare'))
                    ->placeholder(_GLA('PH_select idmetodalivrare')),
                    
                Input::make('obj.idorderpartener')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_idorderpartener'))
                    ->id($this->obj->_getAdminId('idorderpartener'))
                    ->placeholder(_GLA('PH_set idorderpartener')),
                    
                DateTimer::make('dataplataADMIN')
                    ->value($this->obj->datapaid)
                    ->title('Data Plata')->format('d.m.Y'),

                Input::make('obj.total_real_pricewotvat')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_total_real_pricewotvat'))
                    ->id($this->obj->_getAdminId('total_real_pricewotvat'))
                    ->placeholder(_GLA('PH_set total_real_pricewotvat')),

                Input::make('obj.total_discount_value')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_total_discount_value'))
                    ->id($this->obj->_getAdminId('total_discount_value'))
                    ->placeholder(_GLA('PH_set total_discount_value')),

                Input::make('obj.total_real_vat')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_total_real_vat'))
                    ->id($this->obj->_getAdminId('total_real_vat'))
                    ->placeholder(_GLA('PH_set total_real_vat')),

                Input::make('obj.total_real_price')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_total_real_price'))
                    ->id($this->obj->_getAdminId('total_real_price'))
                    ->placeholder(_GLA('PH_set total_real_price')),

                Input::make('obj.total_achitat')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_total_achitat'))
                    ->id($this->obj->_getAdminId('total_achitat'))
                    ->placeholder(_GLA('PH_set total_achitat')),

                Input::make('obj.total_datorie')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_total_datorie'))
                    ->id($this->obj->_getAdminId('total_datorie'))
                    ->placeholder(_GLA('PH_set total_datorie')),

            
                Input::make('obj.destinatar_name')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_destinatar_name'))
                    ->id($this->obj->_getAdminId('destinatar_name'))
                    ->placeholder(_GLA('PH_set destinatar_name')),


                Input::make('obj.destinatar_company')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_destinatar_company'))
                    ->id($this->obj->_getAdminId('destinatar_company'))
                    ->placeholder(_GLA('PH_set destinatar_company')),

                Input::make('obj.destinatar_phone')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_destinatar_phone'))
                    ->id($this->obj->_getAdminId('destinatar_phone'))
                    ->placeholder(_GLA('PH_set destinatar_phone')),

                Input::make('obj.destinatar_email')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_destinatar_email'))
                    ->id($this->obj->_getAdminId('destinatar_email'))
                    ->placeholder(_GLA('PH_set destinatar_email')),

                Input::make('obj.destinatar_address')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_destinatar_address'))
                    ->id($this->obj->_getAdminId('destinatar_address'))
                    ->placeholder(_GLA('PH_set destinatar_address')),

                Input::make('obj.destinatar_delivery_number')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_destinatar_delivery_number'))
                    ->id($this->obj->_getAdminId('destinatar_delivery_number'))
                    ->placeholder(_GLA('PH_set destinatar_delivery_number')),
                
                $this->obj->locationselect('destinatar_idlocation', $this->obj->destinatar_idlocation, '', 0),
                
                Input::make('obj.comments')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_coments'))
                    ->id($this->obj->_getAdminId('comments'))
                    ->placeholder(_GLA('PH_set comments')),

            ])
        ];
    }


    /**
     * @param Order   $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Order $obj, Request $request)
    {
        $x = request()->request;
        $obj->dataplata = ($x->get('dataplataADMIN')) ? DT::toTimeStamp($x->get('dataplataADMIN').' 00:00:00') : null;
        
        $destinatar_idlocation = array_filter($request['destinatar_idlocation']); // Remove any falsey values
        $destinatar_idlocation = array_reverse($destinatar_idlocation); // Reverse the order of the remaining values
        $destinatar_idlocation = reset($destinatar_idlocation);

        $obj->destinatar_idlocation = $destinatar_idlocation;    

        OrderForm::saveOrderJournal($obj, $obj->status, 'Order edited', 0);

        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Order $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

