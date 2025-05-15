<?php

namespace App\Orchid\Screens\Attachements;

use App\Models\Base\Attachements;
use App\Orchid\Layouts\AttachementsModule\AttachementsLayout;
use App\Orchid\Screens\BaseMediaScreen;
use Orchid\Screen\Actions\Link;

class AttachementsListScreen extends BaseMediaScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Attachements::GetObj();
    }
    
    public function commandBar(): iterable
    {
        $rez = parent::commandBar();

        $rez[] =                 
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.attachements.create', $this->targetClass->_getModifyAdminParams()));

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
            AttachementsLayout::class,
        ];
        exit();
    }
}
