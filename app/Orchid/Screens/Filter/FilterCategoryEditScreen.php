<?php

namespace App\Orchid\Screens\Filter;

use App\Models\Base\Status;
use App\Models\Category\Category;
use App\Models\Filter\Filter;
use App\Orchid\Screens\BaseEditScreen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\Filter\FilterCategory;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;

class FilterCategoryEditScreen extends BaseEditScreen
{
    /**
     * @var FilterCategory
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = FilterCategory::GetObj();
    }

    /**
     * Query data.
     *
     * @param FilterCategory $obj
     *
     * @return array
     */
    public function query(FilterCategory $obj): array
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
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $filters_select = Filter::_getAllForSelect($f, array(), 'identifier');
        
        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                $this->obj->locationselect('idcategory', $this->obj->idcategory, '', 0),

                Select::make('obj.idfilter')
                    ->class('js_CA_select')
                    ->options($filters_select)
                    ->title(_GLA('TI_idfilter'))
                    ->id($this->obj->_getAdminId('idfilter'))
                    ->placeholder(_GLA('PH_select idfilter')),

            ])
        ];
    }

    /**
     * @param FilterCategory    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(FilterCategory $obj, Request $request)
    {
        $idcategory = array_filter($request['idcategory']); // Remove any falsey values
        $idcategory = array_reverse($idcategory); // Reverse the order of the remaining values
        $idcategory = reset($idcategory);

        $obj->idcategory = $idcategory;    
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(FilterCategory $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

