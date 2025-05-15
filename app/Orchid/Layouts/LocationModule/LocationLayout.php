<?php

namespace App\Orchid\Layouts\LocationModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;
use App\Models\Location\Location;

class LocationLayout extends Table
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
                ->render(function (Location $obj) {
                    return Link::make($obj->id)
                        ->route('platform.location.edit',$obj->_getModifyAdminParams());
                }),


            TD::make('_name','Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (Location $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.location.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),
                    
            TD::make('order','order')
                ->sort()
                ->filter(Input::make())
                ->render(function (Location $obj) {
                    return $obj->order; }),

            TD::make('price','Price')
                ->sort()
                ->filter(Input::make())
                ->render(function (Location $obj) {
                    return $obj->price; }),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Location $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make('isdefault', 'Is Default')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('isdefault', 'all')))
                    ->render(function (Location $obj) {
                        return $obj->default;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Location $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                        ->route('platform.location.edit',$obj->_getModifyAdminParams())
                        ->icon('pencil'),

                    Link::make(__('Childrens'))
                        ->route('platform.location.list', $obj->_getChildAdminParams('platform.location.list'))
                        ->icon('picture'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.location.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
