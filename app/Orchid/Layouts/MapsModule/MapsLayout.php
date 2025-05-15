<?php

namespace App\Orchid\Layouts\MapsModule;

use Orchid\Screen\TD;
use App\Models\Maps\Maps;
use App\Models\Base\Status;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;


class MapsLayout extends Table
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
                ->render(function (Maps $obj) {
                    return Link::make($obj->id)
                        ->route('platform.maps.edit',$obj->_getModifyAdminParams());
                }),

            TD::make('_name','Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (Maps $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.maps.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),
                    
            TD::make('lat','Latitude')
                ->sort()
                ->filter(Input::make())
                ->render(function (Maps $obj) {
                    return $obj->lat; }),

            TD::make('lng','Longitude')
                ->sort()
                ->filter(Input::make())
                ->render(function (Maps $obj) {
                    return $obj->lng; }),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Maps $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make('typecontactpoint', 'Type map')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('map_type', 'all')))
                    ->render(function (Maps $obj) {
                        return $obj->type_text;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Maps $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                        ->route('platform.maps.edit',$obj->_getModifyAdminParams())
                        ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.maps.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
