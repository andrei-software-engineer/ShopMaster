<?php

namespace App\Orchid\Screens\FaqResponses;

use App\Models\Base\Status;
use App\Models\Faq\FaqResponses;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;

class FaqResponsesEditScreen extends BaseEditScreen
{
    /**
     * @var FaqResponses
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = FaqResponses::GetObj();
    }

    /**
     * Query data.
     *
     * @param FaqResponses $obj
     *
     * @return array
     */
    public function query(FaqResponses $obj): array
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
        $faq_status = Status::GA('faq_status');

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                $this->getSelectLang(),

                Input::make('obj.parentmodel')
                    ->set('hidden', true),
                    
                Input::make('obj.parentmodelid')
                    ->set('hidden', true),
                    
                Input::make('obj.ordercriteria')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_ordercriteria'))
                    ->id($this->obj->_getAdminId('ordercriteria'))
                    ->placeholder(_GLA('PH_set ordercriteria')),

                Select::make('obj.status')
                    ->options($faq_status)
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
                
                $this->getCKEditor('_description')

            ])
        ];
    }


    /**
     * @param FaqResponses    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(FaqResponses $obj, Request $request)
    {
        $t = json_decode(request()->get('obj')['_requestInfo'], true);
        $obj->idfaq = $t['filter']['idfaq'];
        
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(FaqResponses $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

