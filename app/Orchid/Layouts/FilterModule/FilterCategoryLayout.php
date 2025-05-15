<?php

namespace App\Orchid\Layouts\FilterModule;

use App\Models\Base\Status;
use App\Models\Category\Category;
use App\Models\Filter\Filter;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use App\Models\Filter\FilterCategory;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class FilterCategoryLayout extends Table
{
    /**
     * Data source.
     *  
     * @var string
     */
    public $target = 'objects';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [

            TD::make('id','ID')
                ->sort()
                ->filter(Input::make())
                ->render(function (FilterCategory $obj) {
                        return $obj->id;
                    }),

            TD::make('idcategory', 'Category')
                ->sort()
                ->render(function (FilterCategory $obj) {
                    return $obj->category_name;
                }),

            TD::make('idfilter', 'Filter')
                ->sort()
                ->render(function (FilterCategory $obj) {
                    return $obj->filter_identifier;
                }),


            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (FilterCategory $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([


                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.filtercategory.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
