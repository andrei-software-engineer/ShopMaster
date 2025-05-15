<?php

namespace App\Orchid\Screens\Filter;

use App\Models\Base\Status;
use App\Models\Filter\Filter;
use App\Orchid\Screens\BaseEditScreen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\Filter\FilterValue;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;

class FilterValueEditScreen extends BaseEditScreen
{
    /**
     * @var FilterValue
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = FilterValue::GetObj();
    }

    /**
     * Query data.
     *
     * @param FilterValue $obj
     *
     * @return array
     */
    public function query(FilterValue $obj): array
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
        $status = Status::GA('prd_fyl_ctg_status');
        $f = array();
        $f['_where']['status'] = Status::ACTIVE;
        $filters_select = Filter::_getAllForSelect($f, array(), 'identifier');
        
        
        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                $this->getSelectLang(),

                Input::make('obj.orderctireatia')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->id($this->obj->_getAdminId('orderctireatia'))
                    ->readable()
                    ->title(_GLA('TI_orderctireatia')),

                Select::make('obj.idfilter')
                    ->class('js_CA_select')
                    ->options($filters_select)
                    ->title(_GLA('TI_idfilter'))
                    ->id($this->obj->_getAdminId('idfilter'))
                    ->placeholder(_GLA('PH_select idfilter')),

                Select::make('obj.status')
                    ->options($status)
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
            ])
        ];
    }

    /**
     * @param FilterValue    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(FilterValue $obj, Request $request)
    {
        
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(FilterValue $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

