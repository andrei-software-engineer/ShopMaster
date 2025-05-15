<?php

namespace App\Orchid\Screens\Notification;

use App\Orchid\Screens\BaseListScreen;
use App\Models\Notification\MailToSend;
use App\Orchid\Layouts\NotificationModule\MailToSendLayout;
use Orchid\Screen\Actions\Link;

class MailToSendListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = MailToSend::GetObj();
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
                ->href(route('platform.mailtosend.create')),
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
            MailToSendLayout::class,
        ];
    }
}
