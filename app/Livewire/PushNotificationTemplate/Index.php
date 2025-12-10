<?php

namespace App\Livewire\PushNotificationTemplate;

use App\Livewire\Breadcrumb;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        /* Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.push_notification_template.breadcrumb.title'),
            'item_1' => __('messages.push_notification_template.breadcrumb.push_notification_template'),
            'item_2' => __('messages.push_notification_template.breadcrumb.list'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
    }

    public function render()
    {
        return view('livewire.push-notification-template.index')->title(__('messages.meta_title.index_push_notification_template'));
    }
}
