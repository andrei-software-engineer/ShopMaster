<?php

namespace App\Orchid\Screens\Favorite;

use App\Orchid\Screens\BaseEditScreen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\Favorite\Favorite;
use Orchid\Support\Facades\Layout;

class FavoriteEditScreen extends BaseEditScreen
{
    /**
     * @var Favorite
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Favorite::GetObj();
    }

    /**
     * Query data.
     *
     * @param Favorite $obj
     *
     * @return array
     */
    public function query(Favorite $obj): array
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

            ])
        ];
    }

    /**
     * @param Favorite    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Favorite $obj, Request $request)
    {
        return parent::_createOrUpdate($obj, $request);
    }

    public function backroute(Favorite $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }
}

