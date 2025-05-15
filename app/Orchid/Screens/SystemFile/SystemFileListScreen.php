<?php

namespace App\Orchid\Screens\SystemFile;

use App\Models\Base\SystemFile;
use Orchid\Screen\Actions\Link;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\SystemFileModule\SystemFileLayout;

class SystemFileListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SystemFile::GetObj();
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
                ->href(route('platform.systems.systemfile.create')),
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
            SystemFileLayout::class
        ];
    }
}
