<?php

namespace App\Orchid\Screens\Filter;

use App\Models\Filter\Filter;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\FilterModule\FilterLayout;
use Orchid\Screen\Actions\Link;

class FilterListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Filter::GetObj();
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
                ->href(route('platform.filter.create', $this->targetClass->_getModifyAdminParams()));

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
            FilterLayout::class,
        ];
    }
}
