<?php

namespace App\Orchid\Layouts\FilterModule;

use App\Models\Base\Status;
use App\Models\Filter\Filter;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use App\Models\Filter\FilterProduct;
use App\Models\Filter\FilterValue;
use App\Models\Product\Product;
use Orchid\Screen\Fields\Select;

class FilterProductLayout extends Table
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
                ->render(function (FilterProduct $obj) {
                    return Link::make($obj->id)
                        ->route('platform.filterproduct.edit',$obj->_getModifyAdminParams());}),

            TD::make('idfilter', 'Filter')
                ->sort()
                ->render(function (FilterProduct $obj) {
                    return $obj->filter_identifier;
                }),


            TD::make('idfiltervalue', 'Filter value')
                ->sort()
                ->render(function (FilterProduct $obj) {
                    return $obj->filterValue_name;
                }),

            TD::make('value', 'Value')
                ->sort()
                ->filter(Input::make())
                ->render(function (FilterProduct $obj) {
                    return $obj->value;
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (FilterProduct $obj) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('platform.filterproduct.edit', $obj->_getModifyAdminParams())
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->action(route('platform.filterproduct.remove', $obj->_getFiltersMedia()))
                            ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
