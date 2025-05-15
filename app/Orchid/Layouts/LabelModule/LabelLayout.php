<?php

namespace App\Orchid\Layouts\LabelModule;

use App\Models\Base\Label;
use App\Models\Base\Status;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
  
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;


class LabelLayout extends Table
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
                ->render(function (Label $obj) {
                    return Link::make($obj->id)
                        ->route('platform.label.edit',$obj->_getModifyAdminParams());
                }),


            TD::make('identifier', 'Identifier')
                ->sort()
                ->filter(Input::make())
                ->render(function (Label $obj) {
                    return Link::make($obj->identifier);
                }),
                        
            TD::make('_name','Name')
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Label $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.label.edit', $obj->_getModifyAdminParams());}),


            TD::make('type', 'Type')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('labeltype', 'all')))
                    ->render(function (Label $obj) {
                        return $obj->typeText;
                    })->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('label', 'all')))
                    ->render(function (Label $obj) {
                        return $obj->statusText;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make(__('Actions'))
            ->align(TD::ALIGN_CENTER) 
            ->width('100px')
            ->render(fn (Label $obj) => DropDown::make()
            ->icon('options-vertical')
            ->list([
                Link::make(__('Edit'))
                ->route('platform.label.edit', $obj->_getModifyAdminParams())
                ->icon('pencil'),

                Button::make(__('Delete'))
                    ->icon('trash')
                    ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                    ->action(route('platform.label.remove', ['id' => $obj->id]))
                    ->canSee($obj->_canDelete()),
                ])),
   
        ];
    }
}
