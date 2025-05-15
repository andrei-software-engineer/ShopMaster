<?php

namespace App\Orchid\Screens\Auto;

use Orchid\Screen\Actions\Link;
use App\Models\Auto\SpecialFilterAuto;
use App\Orchid\Layouts\AutoModule\SpecialFilterAutoLayout;
use App\Orchid\Screens\BaseMediaScreen;

class SpecialFilterAutoListScreen extends BaseMediaScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SpecialFilterAuto::GetObj();
        // $this->stricktMode = false;
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
                ->href(route('platform.specialfilterauto.create', $this->targetClass->_getModifyAdminParams()));

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
            SpecialFilterAutoLayout::class,
        ];
    }
}
