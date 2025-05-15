<?php

namespace App\Orchid\Screens\Filter;

use App\Models\Base\Status;
use App\Orchid\Screens\BaseEditScreen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\Filter\Filter;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;

class FilterEditScreen extends BaseEditScreen
{
    /**
     * @var Filter
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Filter::GetObj();
    }

    /**
     * Query data.
     *
     * @param Filter $obj
     *
     * @return array
     */
    public function query(Filter $obj): array
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
        $filter_type = Status::GA('filter_type');


        $infoparser = [];
        $infoparser[Status::FILTER_TYPE_RANGE] = [
            'showinfo' => '#'.$this->obj->_getAdminId('minValue').',#'.$this->obj->_getAdminId('maxValue')
        ];
        $infoparser[Status::FILTER_TYPE_VALUE] = [
            'hideinfo' => '#'.$this->obj->_getAdminId('minValue').',#'.$this->obj->_getAdminId('maxValue')
        ];
        $infoparser[Status::FILTER_TYPE_STRING] = [
            'hideinfo' => '#'.$this->obj->_getAdminId('minValue').',#'.$this->obj->_getAdminId('maxValue')
        ];
        $infoparser = json_encode($infoparser);
        


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

                Input::make('obj.identifier')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->id($this->obj->_getAdminId('identifier'))
                    ->readable()
                    ->title(_GLA('TI_identifier')),

                Select::make('obj.status')
                    ->options($status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status'))
                    ->id($this->obj->_getAdminId('status'))
                    ->placeholder(_GLA('PH_select status')),

                Select::make('obj.type')
                    ->class('js_CA_select')
                    ->options($filter_type)
                    ->title(_GLA('TI_type'))
                    ->id($this->obj->_getAdminId('type'))
                    ->placeholder(_GLA('PH_select type'))
                    ->set('data-infoparser',$infoparser)
                    ->set('data-oneach','1'),

                Input::make('obj.minValue')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->id($this->obj->_getAdminId('minValue'))
                    ->title(_GLA('TI_minValue')),

                Input::make('obj.maxValue')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->id($this->obj->_getAdminId('maxValue'))
                    ->title(_GLA('TI_maxValue')),


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
     * @param Filter    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Filter $obj, Request $request)
    {

        if($request->get('obj')['type'] != str(Status::FILTER_TYPE_VALUE)->value){
            $tobj = $request->get('obj');
            unset($obj['maxValue']);
            unset($obj['minValue']);
            $request->replace(['obj' => $tobj]);

            $obj->maxValue = 0;
            $obj->minValue = 0;
        }

        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Filter $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}