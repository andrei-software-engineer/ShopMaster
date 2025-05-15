<?php

namespace App\Orchid\Screens\Notification;

use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;
use App\Models\Notification\MailToSend;
use App\Models\Notification\Subscription;
use App\Models\Page\Page;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;

class MailToSendEditScreen extends BaseEditScreen
{
    /**
     * @var MailToSend
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = MailToSend::GetObj();
    }

    /**
     * Query data.
     *
     * @param MailToSend $obj
     *
     * @return array
     */
    public function query(MailToSend $obj): array
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
        $emails = Subscription::_getAllForSelect(array('notification_status' => Status::ACTIVE),array(), 'email');

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

                Select::make('obj.idemailtemplate')
                    ->options($emails)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_idemailtemplate'))
                    ->id($this->obj->_getAdminId('idemailtemplate'))
                    ->placeholder(_GLA('PH_select idemailtemplate')),

            ])
        ];
    }


    /**
     * @param MailToSend    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(MailToSend $obj, Request $request)
    {
        $t = $request->all();
        Subscription::insertToEmail($t['obj']['idsubscription'], $t['obj']['idemailtemplate']);

        return parent::_createOrUpdateNotification($obj, $request);
    }

    public function backroute(MailToSend $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

