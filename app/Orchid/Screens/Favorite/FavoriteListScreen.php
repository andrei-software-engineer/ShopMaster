<?php

namespace App\Orchid\Screens\Favorite;

use App\Models\Favorite\Favorite;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\FavoriteModule\FavoriteLayout;

class FavoriteListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Favorite::GetObj();
    }

            /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        $rez = parent::commandBar();

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
            FavoriteLayout::class,
        ];
    }
}
