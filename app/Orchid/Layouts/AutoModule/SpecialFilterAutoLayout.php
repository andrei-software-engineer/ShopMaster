<?php

namespace App\Orchid\Layouts\AutoModule;

use Orchid\Screen\TD;
use App\Models\Base\Status;
use App\Models\Auto\SpecialFilterAuto;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;


class SpecialFilterAutoLayout extends Table
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
                ->render(function (SpecialFilterAuto $obj) {
                    return Link::make($obj->id)
                        ->route('platform.specialfilterauto.edit',$obj->_getModifyAdminParams());}),
                

            TD::make('parentmodel','')
                ->filter(Input::make())
                ->defaultHidden(true),

            TD::make('parentmodelid','')
                ->filter(Input::make())
                ->defaultHidden(true),

            TD::make('idSpecialFilter', 'Special Filter')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('car_filter', 'all')))
                    ->render(function (SpecialFilterAuto $obj) {
                        return $obj->specialFilter_text;
                            })->filterValue(function($item){return Status::GL($item);}),


            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (SpecialFilterAuto $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([
                    
                    Link::make(__('Edit'))
                    ->route('platform.specialfilterauto.edit',$obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    
                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.specialfilterauto.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
