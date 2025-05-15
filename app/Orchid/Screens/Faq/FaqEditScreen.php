<?php

namespace App\Orchid\Screens\Faq;

use App\Models\Base\Status;
use App\Models\Faq\Faq;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\TextArea;
use App\Orchid\Screens\BaseEditScreen;

class FaqEditScreen extends BaseEditScreen
{
    /**
     * @var Faq
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Faq::GetObj();
    }

    /**
     * Query data.
     *
     * @param Faq $obj
     *
     * @return array
     */
    public function query(Faq $obj): array
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
        $faq_type = Status::GA('faq_type');

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                Input::make('obj.parentmodel')
                    ->set('hidden', true),
                    
                Input::make('obj.parentmodelid')
                    ->set('hidden', true),

                $this->getSelectLang(),

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

                Select::make('obj.faqtype')
                    ->options($faq_type)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_faqtype'))
                    ->id($this->obj->_getAdminId('faqtype'))
                    ->placeholder(_GLA('PH_select faqtype')),

                Input::make('obj._name')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_name'))
                    ->id($this->obj->_getAdminId('_name'))
                    ->placeholder(_GLA('PH_set name')),

                Input::make('obj._title')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_title'))
                    ->id($this->obj->_getAdminId('_title'))
                    ->placeholder(_GLA('PH_set title')),

                Input::make('obj._author')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_author'))
                    ->id($this->obj->_getAdminId('_author'))
                    ->placeholder(_GLA('PH_set author')),

                Input::make('obj._slug')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_slug'))
                    ->id($this->obj->_getAdminId('_slug'))
                    ->placeholder(_GLA('PH_set slug')),

                Input::make('obj._author_meta')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_author_meta'))
                    ->id($this->obj->_getAdminId('_author_meta'))
                    ->placeholder(_GLA('PH_set author_meta')),
                
                TextArea::make('obj._key_meta')
                    ->title(_GLA('TI_key_meta'))
                    ->id($this->obj->_getAdminId('_key_meta'))
                    ->placeholder(_GLA('PH_set key meta'))
                    ->rows(3),

                TextArea::make('obj._description_meta')
                    ->title(_GLA('TI_description_meta'))
                    ->id($this->obj->_getAdminId('_description_meta'))
                    ->placeholder(_GLA('PH_set description_meta'))
                    ->rows(3),
                
                $this->getCKEditor('_description')
            ])
        ];
    }


    /**
     * @param Faq    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Faq $obj, Request $request)
    {
        return parent::_createOrUpdate($obj, $request);
    }
    

    public function backroute(Faq $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

