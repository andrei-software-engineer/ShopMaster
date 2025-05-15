<?php

namespace App\Orchid\Screens\Page;

use App\Models\Page\Page;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\PageModule\PageLayout;
use Orchid\Screen\Actions\Link;

class PageListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Page::GetObj();
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
                ->href(route('platform.page.create')),
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
            PageLayout::class,
        ];
    }
}
