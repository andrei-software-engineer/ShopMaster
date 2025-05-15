<?php

namespace App\Orchid\Screens\Benefits;

use App\Models\Benefits\Benefits;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\TextArea;
use App\Orchid\Screens\BaseEditScreen;

class BenefitsEditScreen extends BaseEditScreen
{
    /**
     * @var Benefits
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Benefits::GetObj();
    }

    /**
     * Query data.
     *
     * @param Benefits $obj
     *
     * @return array
     */
    public function query(Benefits $obj): array
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
        $benefit_status = Status::GA('general_status');

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                $this->getSelectLang(),
                
                Input::make('obj.ordercriteria')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_ordercriteria'))
                    ->id($this->obj->_getAdminId('ordercriteria'))
                    ->placeholder(_GLA('PH_set ordercriteria')),

                Input::make('obj._name')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_name'))
                    ->id($this->obj->_getAdminId('_name'))
                    ->placeholder(_GLA('PH_set name')),

                Select::make('obj.status')
                    ->options($benefit_status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status'))
                    ->id($this->obj->_getAdminId('status'))
                    ->placeholder(_GLA('PH_select status')),

                Input::make('obj.url')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_url'))
                    ->id($this->obj->_getAdminId('url'))
                    ->placeholder(_GLA('PH_set url')),

                $this->getCKEditor('_description')
            ])
        ];
    }


    /**
     * @param Benefits    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Benefits $obj, Request $request)
    {   
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Benefits $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

