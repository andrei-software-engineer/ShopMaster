<?php

namespace App\Orchid\Screens\Lang;

use App\Orchid\Screens\BaseEditScreen;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use App\Models\Base\Lang;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;

class LangEditScreen extends BaseEditScreen
{
    /**
     * @var Lang
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Lang::GetObj();
    }

    /**
     * Query data.
     *
     * @param Lang $obj
     *
     * @return array
     */
    public function query(Lang $obj): array
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
        // $data = $this->st->GL();
        $data = Status::GA('lang');
        $coreHTM = Status::GA('yesno');
        return [
            Layout::rows([
                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                Input::make('obj.ordercriteria')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA( 'TI_ordercriteria'))
                    ->placeholder(_GLA('PH_select order criteria')),

                Input::make('obj.name')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA( 'TI_name'))
                    ->placeholder(_GLA('PH_enter name')),

                Input::make('obj.code2')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_code2'))
                    ->placeholder(_GLA('PH_enter placeholder')),

                Input::make('obj.code3')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_code3'))
                    ->placeholder(_GLA('PH_enter code')),

                Select::make('obj.status')
                    ->options($data)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status'))
                    ->placeholder(_GLA('PH_select status')),

                Select::make('obj.status_admin')
                    ->options($data)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_status_admin'))
                    ->placeholder(_GLA('PH_select status admin')),

                Input::make('obj.slug')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_slug'))
                    ->placeholder(_GLA('PH_enter slug')),

                Input::make('obj.corehtml')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_corehtml'))
                    ->placeholder(_GLA('PH_enter core html')),
                
                Select::make('obj.right_direction')
                    ->options($coreHTM)
                    ->class('js_CA_select')
                    ->title(_GLA('TI_right_direction'))
                    ->placeholder(_GLA('PH_enter right direction')),
            ])
        ];
    }

    /**
     * @param Lang    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Lang $obj, Request $request)
    {
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Lang $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }

}

