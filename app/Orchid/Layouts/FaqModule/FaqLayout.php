<?php

namespace App\Orchid\Layouts\FaqModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

use App\Models\Base\Status;
use App\Models\Faq\Faq;

class FaqLayout extends Table
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
                ->render(function (Faq $obj) {
                    return Link::make($obj->id)
                        ->route('platform.faq.edit',$obj->_getModifyAdminParams());}),


            TD::make('ordercriteria', 'Ordercriteria')
                ->sort()
                ->filter(Input::make())
                ->render(function (Faq $obj) {
                    return Link::make($obj->ordercriteria)
                        ->route('platform.faq.edit', $obj->_getModifyAdminParams());}),
                        
            TD::make('parentmodel','')
                ->filter(Input::make())
                ->defaultHidden(true),

            TD::make('parentmodelid','')
                ->filter(Input::make())
                ->defaultHidden(true),

            TD::make('_name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (Faq $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.faq.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('faqtype', 'Faq Type')
                ->sort()
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('faq_type', 'all')))
                    ->render(function (Faq $obj) {
                        return Link::make($obj->faqtype_text)
                        ->route('platform.faq.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->sort()
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Faq $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),
                    
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Faq $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                    ->route('platform.faq.edit', $obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Link::make(__('Gallery'))
                    ->route('platform.gallery.list', $obj->_getMediaAdminParams('platform.faq.list'))
                    ->icon('picture'),

                    Link::make(__('Video'))
                    ->route('platform.cvideo.list', $obj->_getMediaAdminParams('platform.faq.list'))
                    ->icon('camrecorder'),

                    Link::make(__('Attachements'))
                    ->route('platform.attachements.list', $obj->_getMediaAdminParams('platform.faq.list'))
                    ->icon('link'),

                    Link::make(__('Responses'))
                    ->route('platform.faqresponses.list', $obj->_getFaqAdminParams('platform.faq.list'))
                    ->icon('picture'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.faq.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
