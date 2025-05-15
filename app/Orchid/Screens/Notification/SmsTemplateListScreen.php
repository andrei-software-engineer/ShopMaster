<?php

namespace App\Orchid\Screens\Notification;

use Orchid\Screen\Actions\Link;
use App\Orchid\Screens\BaseListScreen;
use App\Models\Notification\SmsTemplate;
use App\Orchid\Layouts\NotificationModule\SmsTemplateLayout;

class SmsTemplateListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SmsTemplate::GetObj();
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
                ->href(route('platform.smstemplate.create')),
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
            SmsTemplateLayout::class,
        ];
    }
}
