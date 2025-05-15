<?php

namespace App\Orchid\Screens\SystemVideo;

use App\Models\Base\SystemVideo;
use Orchid\Screen\Actions\Link;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\SystemVideoModule\SystemVideoLayout;

class SystemVideoListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SystemVideo::GetObj();
    }

        /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.systems.systemvideo.create')),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            SystemVideoLayout::class
        ];
    }
}
