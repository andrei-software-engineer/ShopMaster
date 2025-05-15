<?php

namespace App\Orchid\Screens\UserInfo;

use App\Models\InfoUser\InfoUser;
use App\Orchid\Layouts\UserInfoModule\UserInfoLayout;
use App\Orchid\Screens\BaseListScreen;
use Orchid\Screen\Actions\Link;
use App\Orchid\Screens\BaseMediaScreen;

class UserInfoListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = InfoUser::GetObj();
        // $this->stricktMode = false;
    }

            /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        $rez = parent::commandBar();
        if(request()->get('_backurl'))
        {
            $rez[] =                 
                Link::make(__('Back to main list'))
                    ->icon('plus')
                    ->href(request()->get('_backurl'));
        }
        $rez[] =                 
            Link::make(__('Add'))
                ->icon('plus')
                ->href(route('platform.infouser.create', $this->targetClass->_getModifyAdminParams()));

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
            UserInfoLayout::class,
        ];
    }
}
