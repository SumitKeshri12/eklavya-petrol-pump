<?php

namespace App\Livewire\Vehicle;

use App\Helper;
use App\Livewire\Breadcrumb;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\Response;

class Edit extends Component
{
    use WithFileUploads;

    public $vehicle;

    public $id;

    public $user_id;

    public $users = [];

    public $vehicle_number;

    public $fuel_type;

    public $status = 'Y';

    public function mount($id)
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.vehicle.breadcrumb.title'),
            'item_1' => '<a href="/vehicle" class="text-muted text-hover-primary" wire:navigate>' . __('messages.vehicle.breadcrumb.vehicle') . '</a>',
            'item_2' => __('messages.vehicle.breadcrumb.edit'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->vehicle = Vehicle::find($id);

        if ($this->vehicle) {
            foreach ($this->vehicle->getAttributes() as $key => $value) {
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
            'vehicle_number' => 'required|string',
            'fuel_type' => 'required|in:P,D',
            'status' => 'required|in:Y,N',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'user_id.required' => __('messages.vehicle.validation.messsage.user_id.required'),
            'vehicle_number.required' => __('messages.vehicle.validation.messsage.vehicle_number.required'),
            'vehicle_number.in' => __('messages.vehicle.validation.messsage.vehicle_number.in'),
            'fuel_type.required' => __('messages.vehicle.validation.messsage.fuel_type.required'),
            'fuel_type.in' => __('messages.vehicle.validation.messsage.fuel_type.in'),
            'status.required' => __('messages.vehicle.validation.messsage.status.required'),
            'status.in' => __('messages.vehicle.validation.messsage.status.in'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'user_id' => $this->user_id,
            'vehicle_number' => $this->vehicle_number,
            'fuel_type' => $this->fuel_type,
            'status' => $this->status,
        ];
        $this->vehicle->update($data); // Update data into the DB

        session()->flash('success', __('messages.vehicle.messages.update'));

        return $this->redirect('/vehicle', navigate: true); // redirect to vehicle listing page
    }

    public function render()
    {
        return view('livewire.vehicle.edit')->title(__('messages.meta_title.edit_vehicle'));
    }
}
