<?php

namespace App\Orchid\Screens\Publicity;

use Orchid\Screen\Actions\Link;
use App\Models\Publicity\Publicity;
use App\Orchid\Layouts\PublicityModule\PublicityLayout;
use App\Orchid\Screens\BaseMediaScreen;

class PublicityListScreen extends BaseMediaScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Publicity::GetObj();
        $this->stricktMode = false;
    }

            /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        $rez = parent::commandBar();

        $rez[] =   
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.publicity.create', $this->targetClass->_getModifyAdminParams()));
        
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
            PublicityLayout::class,
        ];
    }
}
