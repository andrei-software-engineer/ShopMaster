<?php

namespace App\Orchid\Layouts\SocialMediaModule;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;
use App\Models\SocialMedia\SocialMedia;

class SocialMediaLayout extends Table
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
                ->render(function (SocialMedia $obj) {
                    return Link::make($obj->id)
                        ->route('platform.socialmedia.edit',$obj->_getModifyAdminParams());
                }),

            TD::make('ordercriteria', 'Ordercriteria')
                ->sort()
                ->filter(Input::make())
                ->render(function (SocialMedia $obj) {
                    return Link::make($obj->ordercriteria)
                        ->route('platform.socialmedia.edit', $obj->_getModifyAdminParams());}),

            TD::make('_name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (SocialMedia $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.socialmedia.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (SocialMedia $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                            
            TD::make('socialUrl', 'Social Url')
                ->sort()
                ->filter(Input::make())
                ->render(function (SocialMedia $obj) {
                    return $obj->socialUrl;})->filterValue(function($item){return Status::GL($item);}),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (SocialMedia $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([
                    
                    Link::make(__('Edit'))
                    ->route('platform.socialmedia.edit', $obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.socialmedia.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
