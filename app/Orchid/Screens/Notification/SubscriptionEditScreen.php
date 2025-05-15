<?php

namespace App\Orchid\Screens\Notification;

use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Select;
use App\Orchid\Screens\BaseEditScreen;
use Illuminate\Support\Str;
use App\Models\Notification\Subscription;

class SubscriptionEditScreen extends BaseEditScreen
{
    /**
     * @var Subscription
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Subscription::GetObj();
    }

    /**
     * Query data.
     *
     * @param Subscription $obj
     *
     * @return array
     */
    public function query(Subscription $obj): array
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
        $notification_status = Status::GA('notification_status');

        $x = [];

        $x[] =  Input::make('obj._requestInfo')->set('hidden', true);
        $x[] =  Select::make('obj.status')->options($notification_status)->class('js_CA_select')->title(_GLA('TI_status'))->id($this->obj->_getAdminId('status'))->placeholder(_GLA('PH_select status'));
        $x[] =  Input::make('obj.uuid')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->set('hidden', true)->value(Str::uuid());
        $x[] =  Input::make('obj.name')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_name'))->id($this->obj->_getAdminId('name'))->placeholder(_GLA('PH_set name'));
        $x[] =  Input::make('obj.email')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('email')->title(_GLA('TI_email'))->id($this->obj->_getAdminId('_email'))->placeholder(_GLA('PH_set email'));
        $x[] =  Input::make('obj.phone')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_phone'))->id($this->obj->_getAdminId('phone'))->placeholder(_GLA('PH_set phone'));
        $x[] =  Input::make('obj.criteria')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_criteria'))->id($this->obj->_getAdminId('criteria'))->placeholder(_GLA('PH_set criteria'));
        $x[] =  Input::make('obj.group')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_group'))->id($this->obj->_getAdminId('group'))->placeholder(_GLA('PH_set group'));

        return [
            Layout::rows($x)
        ];
    }


    /**
     * @param Subscription    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Subscription $obj, Request $request)
    {
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Subscription $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

