<?php

namespace App\Orchid\Screens\Notification;

use Orchid\Screen\Actions\Link;
use App\Orchid\Screens\BaseListScreen;
use App\Models\Notification\Subscription;
use App\Orchid\Layouts\NotificationModule\SubscriptionLayout;

class SubscriptionListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Subscription::GetObj();
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
                ->href(route('platform.subscription.create')),
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
            SubscriptionLayout::class,
        ];
    }
}
