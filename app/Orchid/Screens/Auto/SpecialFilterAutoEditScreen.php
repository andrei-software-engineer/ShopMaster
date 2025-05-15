<?php

namespace App\Orchid\Screens\Auto;

use App\Models\Auto\SpecialFilterAuto;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;

class SpecialFilterAutoEditScreen extends BaseEditScreen
{
    /**
     * @var SpecialFilterAuto
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SpecialFilterAuto::GetObj();
    }

    /**
     * Query data.
     *
     * @param SpecialFilterAuto $obj
     *
     * @return array
     */
    public function query(SpecialFilterAuto $obj): array
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
        $auto_status = Status::GA('car_filter');

        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                Input::make('obj.parentmodel')
                    ->set('hidden', true),

                Input::make('obj.parentmodelid')
                    ->set('hidden', true),

                Select::make('obj.idSpecialFilter')
                    ->options($auto_status)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_idSpecialFilter'))
                    ->id($this->obj->_getAdminId('idSpecialFilter'))
                    ->placeholder(_GLA('PH_select idSpecialFilter')),


            ])
        ];
    }

    /**
     * @param SpecialFilterAuto    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(SpecialFilterAuto $obj, Request $request)
    {
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(SpecialFilterAuto $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

