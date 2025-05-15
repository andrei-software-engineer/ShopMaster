<?php

namespace App\Orchid\Screens\Filter;

use App\Models\Filter\FilterProduct;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\FilterModule\FilterProductLayout;
use Orchid\Screen\Actions\Link;

class FilterProductListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = FilterProduct::GetObj();
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
                ->href(route('platform.filterproduct.create', $this->targetClass->_getModifyAdminParams()));

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
            FilterProductLayout::class,
        ];
    }
}
