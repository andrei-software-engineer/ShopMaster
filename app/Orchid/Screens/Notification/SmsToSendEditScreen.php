<?php

namespace App\Orchid\Screens\Notification;

use App\Models\Base\Status;
use App\Models\Notification\SmsTemplate;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;
use App\Models\Notification\SmsToSend;
use App\Models\Notification\Subscription;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;

class SmsToSendEditScreen extends BaseEditScreen
{
    /**
     * @var SmsToSend
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SmsToSend::GetObj();
    }

    /**
     * Query data.
     *
     * @param SmsToSend $obj
     *
     * @return array
     */
    public function query(SmsToSend $obj): array
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
        $subscription = Subscription::getGroups();
        $sms = SmsTemplate::_getAllForSelect(array('notification_status' => Status::ACTIVE),array('_texts'=>1), '_sms');

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                Select::make('obj.idsubscription')
                    ->options($subscription)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_idsubscription'))
                    ->id($this->obj->_getAdminId('idsubscription'))
                    ->placeholder(_GLA('PH_select idsubscription')),

                Select::make('obj.idsmstemplate')
                    ->options($sms)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_idsmstemplate'))
                    ->id($this->obj->_getAdminId('idsmstemplate'))
                    ->placeholder(_GLA('PH_select idsmstemplate')),

            ])
        ];
    }


    /**
     * @param SmsToSend    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(SmsToSend $obj, Request $request)
    {
        $t = $request->all();
        Subscription::insertToSMS($t['obj']['idsubscription'], $t['obj']['idsmstemplate']);
        
        return parent::_createOrUpdateNotification($obj, $request);
        
    }

    public function backroute(SmsToSend $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

