<?php

namespace App\Orchid\Screens\Notification;

use App\Models\Base\Status;
use App\Models\Base\SystemFile;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Select;
use App\Orchid\Screens\BaseEditScreen;
use App\Models\Notification\SmsTemplate;
use Orchid\Screen\Fields\ViewField;
use Illuminate\Support\Facades\Route;

class SmsTemplateEditScreen extends BaseEditScreen
{
    /**
     * @var SmsTemplate
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SmsTemplate::GetObj();
    }

    /**
     * Query data.
     *
     * @param SmsTemplate $obj
     *
     * @return array
     */
    public function query(SmsTemplate $obj): array
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
        return [
            Layout::rows([

                Input::make('obj._requestInfo')->set('hidden', true),

                $this->getSelectLang(),

                Select::make('obj.status')
                    ->options($notification_status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status'))
                    ->id($this->obj->_getAdminId('status'))
                    ->placeholder(_GLA('PH_select status')),

                Input::make('obj.identifier')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_identifier'))
                    ->id($this->obj->_getAdminId('identifier'))
                    ->placeholder(_GLA('PH_set identifier')),

                Input::make('obj.fromname')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_fromname'))
                    ->id($this->obj->_getAdminId('_fromname'))
                    ->placeholder(_GLA('PH_set fromname')),

                Input::make('obj._sms')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_sms'))
                    ->id($this->obj->_getAdminId('_sms'))
                    ->placeholder(_GLA('PH_set sms')),

                Input::make('obj.tonumber')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_tonumber'))
                    ->id($this->obj->_getAdminId('_tonumber'))
                    ->placeholder(_GLA('PH_set tonumber')),

                
            ])
        ];
        
    }


    /**
     * @param SmsTemplate    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(SmsTemplate $obj, Request $request)
    {

        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(SmsTemplate $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

