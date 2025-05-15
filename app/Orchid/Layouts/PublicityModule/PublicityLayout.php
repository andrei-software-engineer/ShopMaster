<?php

namespace App\Orchid\Layouts\PublicityModule;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;
use App\Models\Publicity\Publicity;

class PublicityLayout extends Table
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
                ->render(function (Publicity $obj) {
                    return Link::make($obj->id)
                        ->route('platform.publicity.edit',$obj->_getModifyAdminParams());
                }),

            TD::make('parentmodel','')
                ->filter(Input::make())
                ->defaultHidden(true),

            TD::make('parentmodelid','')
                ->filter(Input::make())
                ->defaultHidden(true),

            TD::make('_name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (Publicity $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.publicity.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('advsection', 'Adv section')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('adv_section', 'all')))
                    ->render(function (Publicity $obj) {
                        return Link::make($obj->adv_section_text)
                        ->route('platform.publicity.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('advtype', 'Adv Type')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('adv_type', 'all')))
                    ->render(function (Publicity $obj) {
                        return Link::make($obj->advtype_text)
                        ->route('platform.publicity.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Publicity $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                            
                            
            TD::make('startdate', 'Start Date')
                ->sort()
                ->filter(Input::make())
                ->render(function (Publicity $obj) {
                    return $obj->startdate_d;}),

            TD::make('enddate', 'End Date')
                ->sort()
                ->filter(Input::make())
                ->render(function (Publicity $obj) {
                    return $obj->enddate_d;}),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Publicity $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([
                    
                    Link::make(__('Edit'))
                    ->route('platform.publicity.edit',$obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Link::make(__('Gallery'))
                    ->route('platform.gallery.list', $obj->_getMediaAdminParams('platform.publicity.list'))
                    ->icon('picture'),

                    Link::make(__('Video'))
                    ->route('platform.cvideo.list', $obj->_getMediaAdminParams('platform.publicity.list'))
                    ->icon('camrecorder'),

                    Link::make(__('Attachements'))
                    ->route('platform.attachements.list', $obj->_getMediaAdminParams('platform.publicity.list'))
                    ->icon('link'),

                    Link::make(__('Faq'))
                    ->route('platform.faq.list', $obj->_getMediaAdminParams('platform.publicity.list'))
                    ->icon('quote'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.publicity.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
