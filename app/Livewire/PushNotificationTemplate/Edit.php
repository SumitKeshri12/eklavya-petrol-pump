<?php

namespace App\Livewire\PushNotificationTemplate;

use App\Livewire\Breadcrumb;
use App\Models\PushNotificationTemplate;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\Response;

class Edit extends Component
{
    use WithFileUploads;

    public $pushnotificationtemplate;

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

    public function mount($id)
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.push_notification_template.breadcrumb.title'),
            'item_1' => '<a href="/push_notification_template" class="text-muted text-hover-primary" wire:navigate>' . __('messages.push_notification_template.breadcrumb.push_notification_template') . '</a>',
            'item_2' => __('messages.push_notification_template.breadcrumb.edit'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->pushnotificationtemplate = PushNotificationTemplate::find($id);

        if ($this->pushnotificationtemplate) {
            foreach ($this->pushnotificationtemplate->getAttributes() as $key => $value) {
                $this->{$key} = $value; // Dynamically assign the attributes to the class
            }
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }

    public function rules()
    {
        $rules = [
            'type' => 'required|string|max:100',
            'label' => 'required|string|max:100',
            'title' => 'required|string|max:500',
            'body' => 'required|string',
            'image_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'image' => $this->image,
            'button_name' => $this->button_name,
            'button_link' => $this->button_link,
        ];
        $this->pushnotificationtemplate->update($data); // Update data into the DB

        if ($this->image_image) {
            $realPath = 'pushnotificationtemplate/' . $this->pushnotificationtemplate->id . '/';
            $resizeImages = $this->pushnotificationtemplate->resizeImages($this->image_image, $realPath, true);
            $imagePath = $realPath . pathinfo($resizeImages['image'], PATHINFO_BASENAME);
            $this->pushnotificationtemplate->update(['image' => $imagePath]);
        }

        session()->flash('success', __('messages.push_notification_template.messages.update'));

        return $this->redirect('/push-notification-template', navigate: true); // redirect to push-notification-template listing page
    }

    public function render()
    {
        return view('livewire.push-notification-template.edit')->title(__('messages.meta_title.edit_push_notification_template'));
    }
}
