<?php

namespace App\Livewire\PushNotificationTemplate;

use App\Models\PushNotificationTemplate;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $pushnotificationtemplate;

    public $event = 'showpushnotificationtemplateInfoModal';

    #[On('show-pushnotificationtemplate-info')]
    public function show($id)
    {
        $this->pushnotificationtemplate = null;

        $this->pushnotificationtemplate = PushNotificationTemplate::select(
            'push_notification_templates.id',
            'push_notification_templates.type',
            'push_notification_templates.label',
            'push_notification_templates.title',
            'push_notification_templates.body',
            'push_notification_templates.image',
            'push_notification_templates.button_name',
            'push_notification_templates.button_link',
            DB::raw(
                '(CASE
                                        WHEN push_notification_templates.status = "' . config('constants.push_notification_template.status.key.inactive') . '" THEN  "' . config('constants.push_notification_template.status.value.inactive') . '"
                                        WHEN push_notification_templates.status = "' . config('constants.push_notification_template.status.key.active') . '" THEN  "' . config('constants.push_notification_template.status.value.active') . '"
                                ELSE " "
                                END) AS status'
            )
        )

            ->where('push_notification_templates.id', $id)

            ->first();

        if (! is_null($this->pushnotificationtemplate)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.push_notification_template.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.push-notification-template.show');
    }
}
