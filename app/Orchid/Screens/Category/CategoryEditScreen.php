<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category\Category;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\TextArea;
use App\Orchid\Screens\BaseEditScreen;

class CategoryEditScreen extends BaseEditScreen
{
    /**
     * @var Category
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Category::GetObj();
    }

    /**
     * Query data.
     *
     * @param Category $obj
     *
     * @return array
     */
    public function query(Category $obj): array
    {
        
        $obj = parent::_query($obj);

        if ($obj['obj'] && !$obj['obj']->id)
        {
            $obj['obj']->idparent = request()->query()['idparent'];

            if($obj['obj']->idparent == 0){
                $obj['obj']->level = 1;
            }else{
                $t = Category::_get($obj['obj']->idparent);
                $obj['obj']->level = $t->level + 1;
            }
        }
        
        return $obj;
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    { 
        $cat_status = Status::GA('prd_fyl_ctg_status');

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                $this->getSelectLang(),

                Input::make('obj.idparent')
                ->set('hidden', true),

                Input::make('obj.level')
                ->set('hidden', true),
                    
                Select::make('obj.status')
                    ->options($cat_status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status'))
                    ->id($this->obj->_getAdminId('status'))
                    ->placeholder(_GLA('PH_select status')),

                Input::make('obj.code')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_code'))
                    ->id($this->obj->_getAdminId('code'))
                    ->placeholder(_GLA('PH_set code')),

                Input::make('obj.order')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_order'))
                    ->id($this->obj->_getAdminId('order'))
                    ->placeholder(_GLA('PH_set order')),

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
     * @param Category    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Category $obj, Request $request)
    {
        $obj->fixed = 0;
        
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Category $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

