<?php

namespace App\Orchid\Screens\Video;

use App\Models\Base\Video;
use App\Orchid\Layouts\VideoModule\VideoLayout;
use App\Orchid\Screens\BaseMediaScreen;
use Orchid\Screen\Actions\Link;

class VideoListScreen extends BaseMediaScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Video::GetObj();
    }
        
    public function commandBar(): iterable
    {
        $rez = parent::commandBar();

        $rez[] =                 
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.cvideo.create', $this->targetClass->_getModifyAdminParams()));

        return $rez;
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            VideoLayout::class,
        ];
        exit();
    }

}
