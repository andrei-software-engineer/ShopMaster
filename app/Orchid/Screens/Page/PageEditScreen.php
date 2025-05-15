<?php

namespace App\Orchid\Screens\Page;

use App\Models\Page\Page;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\TextArea;
use App\Orchid\Screens\BaseEditScreen;

class PageEditScreen extends BaseEditScreen
{
    /**
     * @var Page
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Page::GetObj();
    }

    /**
     * Query data.
     *
     * @param Page $obj
     *
     * @return array
     */
    public function query(Page $obj): array
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
        $pag_status = Status::GA('page_status');
        $pag_type = Status::GA('page_type');

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                $this->getSelectLang(),
                    
                Select::make('obj.status')
                    ->options($pag_status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status'))
                    ->id($this->obj->_getAdminId('status'))
                    ->placeholder(_GLA('PH_select status')),

                Select::make('obj.pagetype')
                    ->options($pag_type)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_pagetype'))
                    ->id($this->obj->_getAdminId('pagetype'))
                    ->placeholder(_GLA('PH_select pagetype')),
                
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

                Input::make('obj._slug')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_slug'))
                    ->id($this->obj->_getAdminId('_slug'))
                    ->placeholder(_GLA('PH_set slug')),

                Input::make('obj._author')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_author'))
                    ->id($this->obj->_getAdminId('_author'))
                    ->placeholder(_GLA('PH_set author')),
                    
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
     * @param Page    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Page $obj, Request $request)
    {   
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Page $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

