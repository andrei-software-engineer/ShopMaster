<?php

namespace App\Orchid\Screens\Gallery;

use App\Models\Base\Gallery;
use App\Orchid\Layouts\GalleryModule\GalleryLayout;
use App\Orchid\Screens\BaseMediaScreen;
use Orchid\Screen\Actions\Link;

class GalleryListScreen extends BaseMediaScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Gallery::GetObj();
    }

    public function commandBar(): iterable
    {
        $rez = parent::commandBar();

        $rez[] =                 
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.gallery.create', $this->targetClass->_getModifyAdminParams()));

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
            GalleryLayout::class,
        ];
    }

}
