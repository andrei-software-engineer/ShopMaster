<?php

namespace App\Orchid\Layouts\VideoModule;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

use App\Models\Base\Status;
use App\Models\Base\SystemVideo;
use App\Models\Base\Video;

class VideoLayout extends Table
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
                ->render(function (Video $obj) {
                    return Link::make($obj->id)
                        ->route('platform.cvideo.edit',$obj->_getModifyAdminParams());
                }),


            TD::make('', 'Files')
                ->width('10')
                ->render(function (Video $obj) {
                    return "<a href='".SystemVideo::getimageurl($obj->systemvideoobj)."' target=''><img src='".SystemVideo::getimageurl($obj->systemvideoobj)."' alt='".$obj->name."'  class='rounded-1' width='70'></a>";
                }),

            TD::make('parentmodel','')
                ->filter(Input::make())
                ->defaultHidden(true),

            TD::make('parentmodelid','')
                ->filter(Input::make())
                ->defaultHidden(true),

            TD::make('name','Name')
                ->sort()
                ->filter(Input::make())
                ->render(function (Video $obj) {
                    return Link::make($obj->name_show)
                        ->route('platform.cvideo.edit',$obj->_getModifyAdminParams());
                            }),
                    
                    
            TD::make('isdefault', 'Is default')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('yesno', 'all')))
                    ->render(function (Video $obj) {
                        return $obj->yesno_text;
                            })->filterValue(function($item){return Status::GL($item);}),
            
            TD::make('status', 'Status')
                ->filter(
                    Select::make('select')
                    ->options(Status::GA('media_type', 'all')))
                    ->render(function (Video $obj) {
                        return $obj->status_text;
                    })->filterValue(function($item){return Status::GL($item);}),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER) 
                ->width('100px')
                ->render(fn (Video $obj) => DropDown::make()
                ->icon('options-vertical')
                ->list([
                    Link::make(__('Edit'))
                    ->route('platform.cvideo.edit', $obj->_getModifyAdminParams())
                    ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->action(route('platform.cvideo.remove', $obj->_getFiltersMedia()))
                        ->canSee($obj->_canDelete()),
                    ])),
        ];

    }
}
