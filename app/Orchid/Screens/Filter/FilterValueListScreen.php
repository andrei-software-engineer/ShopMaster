<?php

namespace App\Orchid\Screens\Filter;

use App\Models\Filter\FilterValue;
use App\Orchid\Layouts\FilterModule\FilterValueLayout;
use App\Orchid\Screens\BaseListScreen;
use Orchid\Screen\Actions\Link;

class FilterValueListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = FilterValue::GetObj();

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
                ->href(route('platform.filtervalue.create', $this->targetClass->_getModifyAdminParams()));

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
           
            FilterValueLayout::class,
        ];
    }
}
