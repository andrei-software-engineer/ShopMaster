<?php

namespace App\Orchid\Screens\SocialMedia;

use Orchid\Screen\Actions\Link;
use App\Models\SocialMedia\SocialMedia;
use App\Orchid\Layouts\SocialMediaModule\SocialMediaLayout;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Screens\BaseMediaScreen;

class SocialMediaListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SocialMedia::GetObj();
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
                ->href(route('platform.socialmedia.create', $this->targetClass->_getModifyAdminParams()));
        
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
            SocialMediaLayout::class,
        ];
    }
}
