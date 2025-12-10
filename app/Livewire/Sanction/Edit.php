<?php

namespace App\Livewire\Sanction;

use App\Helper;
use App\Livewire\Breadcrumb;
use App\Models\Sanction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\Response;

class Edit extends Component
{
    use WithFileUploads;

    public $sanction;

    public $id;

    public $user_id;

    public $users = [];

    public $month;

    public $year;

    public $fuel_type;

    public $quantity;

    public $remarks;

    public function mount($id)
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.sanction.breadcrumb.title'),
            'item_1' => '<a href="/sanction" class="text-muted text-hover-primary" wire:navigate>' . __('messages.sanction.breadcrumb.sanction') . '</a>',
            'item_2' => __('messages.sanction.breadcrumb.edit'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->sanction = Sanction::find($id);

        if ($this->sanction) {
            foreach ($this->sanction->getAttributes() as $key => $value) {
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
            'month' => 'required|string|min:1|max:2',
            'year' => 'required|digits:4|integer',
            'fuel_type' => 'required|in:P,D',
            'quantity' => 'nullable|numeric',
            'remarks' => 'nullable',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'user_id.required' => __('messages.sanction.validation.messsage.user_id.required'),
            'month.required' => __('messages.sanction.validation.messsage.month.required'),
            'month.in' => __('messages.sanction.validation.messsage.month.in'),
            'month.min' => __('messages.sanction.validation.messsage.month.min'),
            'month.max' => __('messages.sanction.validation.messsage.month.max'),
            'year.required' => __('messages.sanction.validation.messsage.year.required'),
            'year.in' => __('messages.sanction.validation.messsage.year.in'),
            'fuel_type.required' => __('messages.sanction.validation.messsage.fuel_type.required'),
            'fuel_type.in' => __('messages.sanction.validation.messsage.fuel_type.in'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'user_id' => $this->user_id,
            'month' => $this->month,
            'year' => $this->year,
            'fuel_type' => $this->fuel_type,
            'quantity' => $this->quantity,
            'remarks' => $this->remarks,
        ];
        $this->sanction->update($data); // Update data into the DB

        session()->flash('success', __('messages.sanction.messages.update'));

        return $this->redirect('/sanction', navigate: true); // redirect to sanction listing page
    }

    public function render()
    {
        return view('livewire.sanction.edit')->title(__('messages.meta_title.edit_sanction'));
    }
}
