<?php

namespace App\Livewire\Shift;

use App\Helper;
use App\Livewire\Breadcrumb;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\Response;

class Edit extends Component
{
    use WithFileUploads;

    public $shift;

    public $id;

    public $user_id;

    public $users = [];

    public $start_time;

    public $end_time;

    public $status;

    public function mount($id)
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.shift.breadcrumb.title'),
            'item_1' => '<a href="/shift" class="text-muted text-hover-primary" wire:navigate>' . __('messages.shift.breadcrumb.shift') . '</a>',
            'item_2' => __('messages.shift.breadcrumb.edit'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->shift = Shift::find($id);

        if ($this->shift) {
            foreach ($this->shift->getAttributes() as $key => $value) {
                $this->{$key} = $value; // Dynamically assign the attributes to the class
            }
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }

        $this->users = Helper::getAllUser();
    }

    public function rules()
    {
        $rules = [
            'user_id' => 'required|exists:users,id,deleted_at,NULL',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'status' => 'required|in:C,O',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'user_id.required' => __('messages.shift.validation.messsage.user_id.required'),
            'status.required' => __('messages.shift.validation.messsage.status.required'),
            'status.in' => __('messages.shift.validation.messsage.status.in'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'user_id' => $this->user_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
        ];
        $this->shift->update($data); // Update data into the DB

        session()->flash('success', __('messages.shift.messages.update'));

        return $this->redirect('/shift', navigate: true); // redirect to shift listing page
    }

    public function render()
    {
        return view('livewire.shift.edit')->title(__('messages.meta_title.edit_shift'));
    }
}
