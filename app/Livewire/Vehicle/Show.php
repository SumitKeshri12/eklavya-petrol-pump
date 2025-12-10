<?php

namespace App\Livewire\Vehicle;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $vehicle;

    public $event = 'showvehicleInfoModal';

    #[On('show-vehicle-info')]
    public function show($id)
    {
        $this->vehicle = null;

        $this->vehicle = Vehicle::select(
            'vehicles.id',
            'users.first_name as user_first_name',
            'vehicles.vehicle_number',
            DB::raw(
                '(CASE
                                        WHEN vehicles.fuel_type = "' . config('constants.vehicle.fuel_type.key.petrol') . '" THEN  "' . config('constants.vehicle.fuel_type.value.petrol') . '"
                                        WHEN vehicles.fuel_type = "' . config('constants.vehicle.fuel_type.key.diesel') . '" THEN  "' . config('constants.vehicle.fuel_type.value.diesel') . '"
                                ELSE " "
                                END) AS fuel_type'
            ),
            DB::raw(
                '(CASE
                                        WHEN vehicles.status = "' . config('constants.vehicle.status.key.active') . '" THEN  "' . config('constants.vehicle.status.value.active') . '"
                                        WHEN vehicles.status = "' . config('constants.vehicle.status.key.inactive') . '" THEN  "' . config('constants.vehicle.status.value.inactive') . '"
                                ELSE " "
                                END) AS status'
            )
        )
            ->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
            ->where('vehicles.id', $id)
            ->groupBy('vehicles.id')
            ->first();

        if (! is_null($this->vehicle)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.vehicle.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.vehicle.show');
    }
}
