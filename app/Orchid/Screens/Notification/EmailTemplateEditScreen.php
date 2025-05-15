<?php

namespace App\Orchid\Screens\Notification;

use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Quill;
use App\Orchid\Screens\BaseEditScreen;
use App\Models\Notification\EmailTemplate;
use App\Models\Notification\FromEmail;
use App\Models\Page\Page;

class EmailTemplateEditScreen extends BaseEditScreen
{
    /**
     * @var EmailTemplate
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = EmailTemplate::GetObj();
    }

    /**
     * Query data.
     *
     * @param EmailTemplate $obj
     *
     * @return array
     */
    public function query(EmailTemplate $obj): array
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
        $emails = FromEmail::_getAllForSelect(array('notification_status' => Status::ACTIVE), array('toemail' => 1), 'email');

        $x = [];

        $x[] =  Input::make('obj._requestInfo')->set('hidden', true);
        $x[] =  $this->getSelectLang();
        $x[] =  Select::make('obj.status')->options($notification_status)->class('js_CA_select')->title(_GLA('TI_status'))->id($this->obj->_getAdminId('status'))->placeholder(_GLA('PH_select status'));
        $x[] =  Select::make('obj.idfromemail')->options($emails)->class('js_CA_select')->title(_GLA('TI_idfromemail'))->id($this->obj->_getAdminId('idfromemail'))->placeholder(_GLA('PH_select idfromemail'));
        $x[] =  Input::make('obj.identifier')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_identifier'))->id($this->obj->_getAdminId('identifier'))->placeholder(_GLA('PH_set identifier'));
        $x[] =  Input::make('obj.toemail')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->type('email')->title(_GLA('TI_toemail'))->id($this->obj->_getAdminId('_toemail'))->placeholder(_GLA('PH_set toemail'));
        $x[] =  Input::make('obj.replyto')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_replyto'))->id($this->obj->_getAdminId('_replyto'))->placeholder(_GLA('PH_set replyto'));
        $x[] =  Input::make('obj.cc')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_cc'))->id($this->obj->_getAdminId('cc'))->placeholder(_GLA('PH_set cc'));
        $x[] =  Input::make('obj.bcc')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_bcc'))->id($this->obj->_getAdminId('bcc'))->placeholder(_GLA('PH_set bcc'));
        $x[] =  Input::make('obj._subject')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_subject'))->id($this->obj->_getAdminId('_subject'))->placeholder(_GLA('PH_set _subject'));
        $x[] =  Input::make('obj._fromname')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_fromname'))->id($this->obj->_getAdminId('_fromname'))->placeholder(_GLA('PH_set _fromname'));
        $x[] =  Input::make('obj._toname')->class('js_CA_enter form-control')->set('data-click','#UpdateButton')->title(_GLA('TI_toname'))->id($this->obj->_getAdminId('_toname'))->placeholder(_GLA('PH_set _toname'));
        $x[] =  Quill::make('obj._message')->title(_GLA('TI_message'))->id($this->obj->_getAdminId('_message'))->popover('Quill is a free, open source WYSIWYG editor built for the modern web.');
        
        return [
            Layout::rows($x)
        ];
    }


    /**
     * @param EmailTemplate    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(EmailTemplate $obj, Request $request)
    {
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(EmailTemplate $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }


}

