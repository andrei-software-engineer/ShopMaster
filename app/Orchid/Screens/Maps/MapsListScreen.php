<?php

namespace App\Orchid\Screens\Maps;

use App\Models\Maps\Maps;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\MapsModule\MapsLayout;
use App\Orchid\Screens\BaseListScreen;

class MapsListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Maps::GetObj();
    }

            /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        $rez = parent::commandBar();

        $rez[] =                 
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.maps.create', $this->targetClass->_getModifyAdminParams()));

        return $rez;
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            MapsLayout::class,
        ];
    }
}
