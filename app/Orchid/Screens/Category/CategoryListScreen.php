<?php

namespace App\Orchid\Screens\Category;

use Orchid\Screen\Actions\Link;
use App\Models\Category\Category;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\CategoryModule\CategoryLayout;

class CategoryListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Category::GetObj();
    }

    public function query(): array
    {
        if (
            !isset(request()->query()['filter'])
            || !isset(request()->query()['filter']['idparent'])
        ) {
            $tf = (isset(request()->query()['filter'])) ? (array)request()->query()['filter'] : array();
            $tf['idparent'] = '0';
            request()->merge(array('filter' => $tf));
        }

        return parent::query();
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        $idparent = 0;

        if (isset(request()->query()['filter'])) {
            $idparent = (int)request()->query()['filter']['idparent'];
        }

        if (request()->get('_backurl')) {
            $rez[] =
                Link::make(__('Back to main list'))
                ->icon('plus')
                ->href(request()->get('_backurl'));
        }

        $rez[] =
            Link::make(__('Add'))
            ->icon('plus')
            ->href(route('platform.category.create', array('idparent' => $idparent,)));

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
            CategoryLayout::class,
        ];
    }
}
