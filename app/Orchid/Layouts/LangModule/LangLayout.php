<?php

namespace App\Orchid\Layouts\LangModule;

use App\Models\Base\Lang;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;

class LangLayout extends Table
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
                ->render(function (Lang $obj) {
                    return Link::make($obj->id)
                        ->route('platform.lang.edit',$obj->_getModifyAdminParams());
                }),

            TD::make('ordercriteria','Order Criteria')
                ->sort()
                ->filter(Input::make())
                ->render(function (Lang $obj) {
                    return $obj->ordercriteria;}),

            
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Lang $obj) {
                    return Link::make($obj->name)
                        ->route('platform.lang.edit', $obj->_getModifyAdminParams());}),
            

            TD::make('code2', 'Code2')
                ->sort()
                ->filter(Input::make())
                ->render(function (Lang $obj) {
                    return $obj->code2;}),

            
            TD::make('code3', 'Code3')
                ->sort()
                ->filter(Input::make())
                ->render(function (Lang $obj) {
                    return $obj->code3;}),
            
            
            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('lang', 'all')))
                    ->render(function (Lang $obj) {
                        return $obj->statusText;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make('status_admin', 'Status admin')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('lang', 'all')))
                    ->render(function (Lang $obj) {
                        return $obj->statusAdminText;
                            })->filterValue(function($item){return Status::GL($item);}),

            TD::make('slug', 'Slug')
                ->sort()
                ->filter(Input::make())
                ->render(function (Lang $obj){
                    return $obj->slug;}),
            
            TD::make('corehtml', 'CoreHtml')
                ->sort()
                ->filter(Input::make())
                    ->render(function (Lang $obj) {
                        return $obj->corehtml;}),
            

            TD::make('right_direction', 'Right Direction')
                ->filter(
                    Select::make('right_direction')
                    ->options(Status::GA('yesno', 'all')))
                    ->render(function (Lang $obj) {
                        return $obj->rightDirectionText;
                            })->filterValue(function($item){return Status::GL($item);}),
                
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Lang $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([
                    Link::make(__('Edit'))
                    ->route('platform.lang.edit', $obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.lang.remove', ['id' => $obj->id]))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];

    }
}
