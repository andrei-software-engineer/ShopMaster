<?php

namespace App\Orchid\Layouts\FilterModule;

use App\Models\Base\Status;
use App\Models\Filter\Filter;
use App\Models\Filter\FilterProduct;
use Orchid\Screen\TD;
use App\Models\Filter\FilterValue;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;

class FilterValueLayout extends Table
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
                ->render(function (FilterValue $obj) {
                    return Link::make($obj->id)
                        ->route('platform.filtervalue.edit',$obj->_getModifyAdminParams());
                }),

            TD::make('orderctireatia', 'Order ctireatia')
                ->sort()
                ->filter(Input::make())
                ->render(function (FilterValue $obj) {
                    return Link::make($obj->orderctireatia)
                        ->route('platform.filtervalue.edit', $obj->_getModifyAdminParams());
                }),


            TD::make('idfilter', 'Filter')
                ->sort()
                ->render(function (FilterValue $obj) {
                    return $obj->filter_identifier;
                }),

            TD::make('_name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (FilterValue $obj) {
                    return $obj->_name;
                }),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                        ->options(Status::GA('prd_fyl_ctg_status', 'all'))
                )
                ->render(function (FilterValue $obj) {
                    return $obj->status_text;
                })->filterValue(function ($item) {
                    return Status::GL($item);
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (FilterValue $obj) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('platform.filtervalue.edit', $obj->_getModifyAdminParams())
                            ->icon('pencil'),

                        Link::make(__('Gallery'))
                            ->route('platform.gallery.list', $obj->_getMediaAdminParams('platform.filtervalue.list'))
                            ->icon('picture'),

                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->action(route('platform.filtervalue.remove', $obj->_getFiltersMedia()))
                            ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
