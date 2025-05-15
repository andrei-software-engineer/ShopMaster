<?php

namespace App\Orchid\Screens\Notification;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;
use App\Models\Notification\FromEmail;

class FromEmailEditScreen extends BaseEditScreen
{
    /**
     * @var FromEmail
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = FromEmail::GetObj();
    }

    /**
     * Query data.
     *
     * @param FromEmail $obj
     *
     * @return array
     */
    public function query(FromEmail $obj): array
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
        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                Input::make('obj.email')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->type('email')
                    ->title(_GLA('TI_email'))
                    ->id($this->obj->_getAdminId('email'))
                    ->placeholder(_GLA('PH_set email')),

                Input::make('obj.password')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_password'))
                    ->id($this->obj->_getAdminId('password'))
                    ->placeholder(_GLA('PH_set password')),

                Input::make('obj.smtphost')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_smtphost'))
                    ->id($this->obj->_getAdminId('smtphost'))
                    ->placeholder(_GLA('PH_set smtphost')),

                Input::make('obj.smtpport')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_smtpport'))
                    ->id($this->obj->_getAdminId('smtpport'))
                    ->placeholder(_GLA('PH_set smtpport')),
            ])
        ];
    }


    /**
     * @param FromEmail    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(FromEmail $obj, Request $request)
    {
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(FromEmail $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

