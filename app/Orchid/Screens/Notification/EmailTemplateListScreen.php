<?php

namespace App\Orchid\Screens\Notification;

use App\Models\Notification\EmailTemplate;
use Orchid\Screen\Actions\Link;
use App\Orchid\Screens\BaseListScreen;
use App\Orchid\Layouts\NotificationModule\EmailTemplateLayout;

class EmailTemplateListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = EmailTemplate::GetObj();
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
                ->href(route('platform.emailtemplate.create')),
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
            EmailTemplateLayout::class,
        ];
    }
}
