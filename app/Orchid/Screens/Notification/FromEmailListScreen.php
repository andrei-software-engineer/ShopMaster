<?php

namespace App\Orchid\Screens\Notification;

use Orchid\Screen\Actions\Link;
use App\Models\Notification\FromEmail;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\NotificationModule\FromEmailLayout;

class FromEmailListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = FromEmail::GetObj();
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
                ->href(route('platform.fromemail.create')),
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
            FromEmailLayout::class,
        ];
    }
}
