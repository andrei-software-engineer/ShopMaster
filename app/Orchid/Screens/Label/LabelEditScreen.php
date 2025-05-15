<?php

namespace App\Orchid\Screens\Label;

use App\Orchid\Screens\BaseEditScreen;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\Base\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;

class LabelEditScreen extends BaseEditScreen
{
    /**
     * @var Label
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Label::GetObj();
    }

    /**
     * Query data.
     *
     * @param Label $obj
     *
     * @return array
     */
    public function query(Label $obj): array
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
        $data = Status::GA('label');
        
        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                $this->getSelectLang(),
                    
                Input::make('obj.identifier')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->id($this->obj->_getAdminId('identifier'))
                    ->readable()
                    ->title(_GLA('TI_identifier')),

                Select::make('obj.status')
                    ->options($data)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status'))
                    ->id($this->obj->_getAdminId('status'))
                    ->placeholder(_GLA('PH_select status')),

                Input::make('obj._name')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_name'))
                    ->id($this->obj->_getAdminId('_name'))
                    ->placeholder(_GLA('PH_set _name')),

                Input::make('obj._slug')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_slug'))
                    ->id($this->obj->_getAdminId('_slug'))
                    ->placeholder(_GLA('PH_set slug')),
            ])
        ];
    }

    /**
     * @param Label    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Label $obj, Request $request)
    {

        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Label $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

