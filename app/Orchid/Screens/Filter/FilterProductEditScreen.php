<?php

namespace App\Orchid\Screens\Filter;

use App\Models\Base\Status;
use App\Models\Filter\Filter;
use App\Orchid\Screens\BaseEditScreen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\Filter\FilterProduct;
use App\Models\Filter\FilterValue;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\ViewField;
use Orchid\Support\Facades\Layout;

class FilterProductEditScreen extends BaseEditScreen
{
    /**
     * @var FilterProduct
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = FilterProduct::GetObj();
    }

    /**
     * Query data.
     *
     * @param FilterProduct $obj
     *
     * @return array
     */
    public function query(FilterProduct $obj): array
    {
        return parent::_query($obj);
    }


    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {   $f = array();
        $f['_where']['type'] = Status::FILTER_TYPE_VALUE;
        $f['_where']['status'] = Status::ACTIVE;
        $filters_select = Filter::_getAllForSelect($f, array(), 'identifier');

        $f1 = array();
        $f1['_where']['status'] = Status::ACTIVE;
        $filters = Filter::_getAll($f1, array(), 'identifier');

        

        if($this->obj->idfiltervalue){
            $idselected = $this->obj->idfiltervalue;
        }else{
            $idselected = '';
        }

        $infoparser = [];
        foreach($filters as $item){
            if($item->type == Status::FILTER_TYPE_VALUE){
                $infoparser[$item->id] = [
                    'showinfo' => '#'.$this->obj->_getAdminId('value'),
                    'href' => route('platform.execselectadminfiltervalue', ['idfilter' => $item->id, 'idselected' => $idselected]),
                    'targetid' => $this->obj->_getAdminId('viewField')
                ];
            }else{
                $infoparser[$item->id] = [
                    'hideinfo' => '#'.$this->obj->_getAdminId('value'),
                ];
            }
        }

        $infoparser = json_encode($infoparser);
        

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                $this->getSelectLang(),

                Select::make('obj.idfilter')
                    ->class('js_CA_select')
                    ->options($filters_select)
                    ->title(_GLA('TI_idfilter'))
                    ->id($this->obj->_getAdminId('idfilter'))
                    ->placeholder(_GLA('PH_select idfilter'))
                    ->set('data-infoparser',$infoparser)
                    ->set('data-oneach','1'),

                ViewField::make('viewField')
                    ->view('Orchid.generalViewField')
                    ->id($this->obj->_getAdminId('viewField'))
                    ->set('id', $this->obj->_getAdminId('viewField'))
                    ->title('View'),

                Input::make('obj.value')
                    ->id($this->obj->_getAdminId('value'))
                    ->readable()
                    ->title(_GLA('TI_value')),

                Input::make('obj._name')
                    ->title(_GLA('TI_name'))
                    ->id($this->obj->_getAdminId('_name'))
                    ->placeholder(_GLA('PH_set _name')),
            ])
        ];
    }

    /**
     * @param FilterProduct    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(FilterProduct $obj, Request $request)
    {
        $obj->idproduct = json_decode($request['obj']['_requestInfo'])->filter->idproduct;
        $obj->idfiltervalue = $request['obj_idfiltervalue'];

        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(FilterProduct $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

