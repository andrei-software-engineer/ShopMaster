<?php

namespace App\Orchid\Screens\Payment;

use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use App\Models\Payment\Paynetwallet;
use App\Orchid\Screens\BaseEditScreen;

class PaynetWalletEditScreen extends BaseEditScreen
{
    /**
     * @var Paynetwallet
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Paynetwallet::GetObj();
    }

    /**
     * Query data.
     *
     * @param Paynetwallet $obj
     *
     * @return array
     */
    public function query(Paynetwallet $obj): array
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
        $pag_status = Status::GA('page_status');

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                Input::make('obj.ordercriteria')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_ordercriteria'))
                    ->id($this->obj->_getAdminId('ordercriteria'))
                    ->placeholder(_GLA('PH_set ordercriteria')),
                
                Select::make('obj.status')
                    ->options($pag_status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status'))
                    ->id($this->obj->_getAdminId('status'))
                    ->placeholder(_GLA('PH_select status')),

                Input::make('obj.isdefault')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_isdefault'))
                    ->id($this->obj->_getAdminId('isdefault'))
                    ->placeholder(_GLA('PH_set isdefault')),


                Input::make('obj.merchant_code')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_merchant_code'))
                    ->id($this->obj->_getAdminId('merchant_code'))
                    ->placeholder(_GLA('PH_set merchant_code')),

                Input::make('obj.merchant_secretkey')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_merchant_secretkey'))
                    ->id($this->obj->_getAdminId('merchant_secretkey'))
                    ->placeholder(_GLA('PH_set merchant_secretkey')),

                Input::make('obj.merchant_user')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_merchant_user'))
                    ->id($this->obj->_getAdminId('merchant_user'))
                    ->placeholder(_GLA('PH_set merchant_user')),

                Input::make('obj.merchant_userpass')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_merchant_userpass'))
                    ->id($this->obj->_getAdminId('merchant_userpass'))
                    ->placeholder(_GLA('PH_set merchant_userpass')),

                Input::make('obj.notification_secretkey')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_notification_secretkey'))
                    ->id($this->obj->_getAdminId('notification_secretkey'))
                    ->placeholder(_GLA('PH_set notification_secretkey')),

            ])
        ];
    }


    /**
     * @param Paynetwallet    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Paynetwallet $obj, Request $request)
    {   
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Paynetwallet $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

