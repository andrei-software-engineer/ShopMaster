<?php

namespace App\Orchid\Screens\UserInfo;

use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\InfoUser\InfoUser;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;

class UserInfoEditScreen extends BaseEditScreen
{
    /**
     * @var InfoUser
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = InfoUser::GetObj();
    }

    /**
     * Query data.
     *
     * @param InfoUser $obj
     *
     * @return array
     */
    public function query(InfoUser $obj): array
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

                Input::make('obj._requestInfo')->set('hidden', true),

                Input::make('obj.iduser')->set('hidden', true),
               
                Input::make('obj.nume')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_name'))
                    ->id($this->obj->_getAdminId('name'))
                    ->placeholder(_GLA('PH_set name')),

                Input::make('obj.prenume')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_surname'))
                    ->id($this->obj->_getAdminId('surname'))
                    ->placeholder(_GLA('PH_set surname')),

                Input::make('obj.phone')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_phone'))
                    ->id($this->obj->_getAdminId('phone'))
                    ->placeholder(_GLA('PH_set phone')),

                Input::make('obj.mobil')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_mobil'))
                    ->id($this->obj->_getAdminId('mobil'))
                    ->placeholder(_GLA('PH_set mobil')),

            ])
        ];
    }


    /**
     * @param InfoUser    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(InfoUser $obj, Request $request)
    {
        // if(isset(json_decode(request()->obj['_requestInfo'])->filter->iduser)){
        //     $obj->iduser = json_decode(request()->obj['_requestInfo'])->filter->iduser;
        // }
            

        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(InfoUser $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}