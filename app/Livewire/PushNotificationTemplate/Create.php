<?php

namespace App\Livewire\PushNotificationTemplate;

use App\Livewire\Breadcrumb;
use App\Models\PushNotificationTemplate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id;

    public $type;

    public $label;

    public $title;

    public $body;

    public $image;

    public $image_image;

    public $button_name;

    public $button_link;

    public $status = 'Y';

    public function mount()
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.push_notification_template.breadcrumb.title'),
            'item_1' => '<a href="/push-notification-template" class="text-muted text-hover-primary" wire:navigate>' . __('messages.push_notification_template.breadcrumb.pushnotificationtemplate') . '</a>',
            'item_2' => __('messages.push_notification_template.breadcrumb.create'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */
    }

    public function rules()
    {
        $rules = [
            'type' => 'required|string|max:100',
            'label' => 'required|string|max:100',
            'title' => 'required|string|max:500',
            'body' => 'required|string',
            'image_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_name' => 'required|string|max:20',
            'button_link' => 'required|url|max:500',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'type.required' => __('messages.push_notification_template.validation.messsage.type.required'),
            'type.in' => __('messages.push_notification_template.validation.messsage.type.in'),
            'type.max' => __('messages.push_notification_template.validation.messsage.type.max'),
            'label.required' => __('messages.push_notification_template.validation.messsage.label.required'),
            'label.in' => __('messages.push_notification_template.validation.messsage.label.in'),
            'label.max' => __('messages.push_notification_template.validation.messsage.label.max'),
            'title.required' => __('messages.push_notification_template.validation.messsage.title.required'),
            'title.in' => __('messages.push_notification_template.validation.messsage.title.in'),
            'title.max' => __('messages.push_notification_template.validation.messsage.title.max'),
            'body.required' => __('messages.push_notification_template.validation.messsage.body.required'),
            'body.in' => __('messages.push_notification_template.validation.messsage.body.in'),
            'image_image.required' => __('messages.push_notification_template.validation.messsage.image_image.required'),
            'image_image.max' => __('messages.push_notification_template.validation.messsage.image_image.max'),
            'button_name.required' => __('messages.push_notification_template.validation.messsage.button_name.required'),
            'button_name.in' => __('messages.push_notification_template.validation.messsage.button_name.in'),
            'button_name.max' => __('messages.push_notification_template.validation.messsage.button_name.max'),
            'button_link.required' => __('messages.push_notification_template.validation.messsage.button_link.required'),
            'button_link.max' => __('messages.push_notification_template.validation.messsage.button_link.max'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'type' => $this->type,
            'label' => $this->label,
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image_image,
            'button_name' => $this->button_name,
            'button_link' => $this->button_link,
        ];
        $pushnotificationtemplate = PushNotificationTemplate::create($data);

        if ($this->image_image) {
            $realPath = 'pushnotificationtemplate/' . $pushnotificationtemplate->id . '/';
            $resizeImages = $pushnotificationtemplate->resizeImages($this->image_image, $realPath, true);
            $imagePath = $realPath . pathinfo($resizeImages['image'], PATHINFO_BASENAME);
            $pushnotificationtemplate->update(['image' => $imagePath]);
        }

        session()->flash('success', __('messages.push_notification_template.messages.success'));

        return $this->redirect('/push-notification-template', navigate: true); // redirect to push-notification-template listing page
    }

    public function render()
    {
        return view('livewire.push-notification-template.create')->title(__('messages.meta_title.create_push_notification_template'));
    }
}
