<?php

namespace App\Orchid\Screens\Config;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\LabelModul\Label;
use App\Models\Base\Config;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;

class ConfigEditScreen extends BaseEditScreen
{
    /**
     * @var Label
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Config::GetObj();
    }

    /**
     * Query data.
     *
     * @param Label $obj
     *
     * @return array
     */
    public function query(Config $obj): array
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
        
        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),

                Input::make('obj.identifier')
                    ->title( _GLA('TI_identifier'))
                    ->placeholder(_GLA('PH_set identifier')),

                Input::make('obj.value')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_value'))
                    ->placeholder(_GLA('PH_set value')),
                    
                Input::make('obj.comments')
                    ->class('js_CA_enter form-control')
                    ->set('data-click','#UpdateButton')
                    ->title(_GLA('TI_comments'))
                    ->placeholder(_GLA('PH_set comments')),

            ])
        ];
    }

    /**
     * @param Config    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Config $obj, Request $request)
    {
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Config $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

