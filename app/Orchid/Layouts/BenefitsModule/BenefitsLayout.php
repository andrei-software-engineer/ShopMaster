<?php

namespace App\Orchid\Layouts\BenefitsModule;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;
use App\Models\Benefits\Benefits;

class BenefitsLayout extends Table
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
                ->render(function (Benefits $obj) {
                    return Link::make($obj->id)
                        ->route('platform.benefits.edit',$obj->_getModifyAdminParams());}),
                    

            TD::make('ordercriteria','Ordercriteria')
                ->sort()
                ->filter(Input::make())
                ->render(function (Benefits $obj) {
                    return Link::make($obj->ordercriteria)
                        ->route('platform.benefits.edit',  $obj->_getModifyAdminParams());}),

            TD::make('_name', 'Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (Benefits $obj) {
                    return Link::make($obj->_name)
                        ->route('platform.benefits.edit', $obj->_getModifyAdminParams());})->filterValue(function($item){return Status::GL($item);}),

            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('general_status', 'all')))
                    ->render(function (Benefits $obj) {
                        return $obj->status_text;
                            })->filterValue(function($item){return Status::GL($item);}),

                    
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Benefits $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                    ->route('platform.benefits.edit', $obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Link::make(__('Gallery'))
                    ->route('platform.gallery.list', $obj->_getMediaAdminParams('platform.benefits.list'))
                    ->icon('picture'),

                    Link::make(__('Video'))
                    ->route('platform.cvideo.list', $obj->_getMediaAdminParams('platform.benefits.list'))
                    ->icon('camrecorder'),

                    Link::make(__('Attachements'))
                    ->route('platform.attachements.list', $obj->_getMediaAdminParams('platform.benefits.list'))
                    ->icon('link'),


                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.benefits.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];
    }
}
