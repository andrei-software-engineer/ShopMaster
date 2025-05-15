<?php

namespace App\Orchid\Screens\Notification;

use Orchid\Screen\Actions\Link;
use App\Orchid\Screens\BaseListScreen;
use App\Models\Notification\SmsToSend;
use App\Orchid\Layouts\NotificationModule\SmsTemplateLayout;
use App\Orchid\Layouts\NotificationModule\SmsToSendLayout;

class SmsToSendListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SmsToSend::GetObj();
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
                ->href(route('platform.smstosend.create')),
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
            SmsToSendLayout::class,
        ];
    }
}
