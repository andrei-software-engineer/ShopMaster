<?php

namespace App\Orchid\Layouts\NotificationModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

use App\Models\Base\Status;
use App\Models\Notification\EmailTemplate;
use Orchid\Screen\Fields\Select;

class EmailTemplateLayout extends Table
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
                ->render(function (EmailTemplate $obj) {
                    return Link::make($obj->id)
                        ->route('platform.emailtemplate.edit',$obj->_getModifyAdminParams());
                }),


            TD::make('identifier', 'Identifier')
                ->sort()
                ->filter(Input::make())
                ->render(function (EmailTemplate $obj) {
                    return Link::make($obj->identifier)
                        ->route('platform.emailtemplate.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('toemail', 'To email')
                ->sort()
                ->filter(Input::make())
                ->render(function (EmailTemplate $obj) {
                    return $obj->toemail;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (EmailTemplate $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                            
            TD::make('_fromname', 'From name')
                ->sort()
                ->filter(Input::make())
                ->render(function (EmailTemplate $obj) {
                    return $obj->_fromname;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('_toname', 'To name')
                ->sort()
                ->filter(Input::make())
                ->render(function (EmailTemplate $obj) {
                    return $obj->_toname;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make('_subject', 'Subject')
                ->sort()
                ->filter(Input::make())
                ->render(function (EmailTemplate $obj) {
                    return $obj->_subject;
                        })->filterValue(function($item){return Status::GL($item);}),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (EmailTemplate $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Preview'))
                        ->href($obj->url)
                        ->target('_blank')
                        ->icon('eye'),

                    Link::make(__('Edit'))
                        ->route('platform.emailtemplate.edit', $obj->_getModifyAdminParams())
                        ->icon('pencil'),

                    Link::make(__('Gallery'))
                        ->route('platform.gallery.list', $obj->_getMediaAdminParams('platform.emailtemplate.list'))
                        ->icon('picture'),

                    Link::make(__('Attachements'))
                        ->route('platform.attachements.list', $obj->_getMediaAdminParams('platform.emailtemplate.list'))
                        ->icon('link'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.emailtemplate.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
