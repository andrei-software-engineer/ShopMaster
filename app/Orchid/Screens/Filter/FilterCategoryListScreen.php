<?php

namespace App\Orchid\Screens\Filter;

use App\Models\Filter\FilterCategory;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\FilterModule\FilterCategoryLayout;
use Orchid\Screen\Actions\Link;

class FilterCategoryListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = FilterCategory::GetObj();
    }

            /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        $rez = parent::commandBar();

        if(request()->get('_backurl'))
        {
            $rez[] =                 
                Link::make(__('Back to main list'))
                    ->icon('plus')
                    ->href(request()->get('_backurl'));
        }
        
        $rez[] =                 
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.filtercategory.create', $this->targetClass->_getModifyAdminParams()));

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
            FilterCategoryLayout::class,
        ];
    }
}
