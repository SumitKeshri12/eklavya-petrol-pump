<?php

namespace App\Livewire\Demand;

use App\Models\Demand;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $demand;

    public $event = 'showdemandInfoModal';

    #[On('show-demand-info')]
    public function show($id)
    {
        $this->demand = null;

        $this->demand = Demand::select(
            'demands.id',
            'users.party_name as user_party_name',
            DB::raw(
                '(CASE
                                        WHEN demands.fuel_type = "' . config('constants.demand.fuel_type.key.petrol') . '" THEN  "' . config('constants.demand.fuel_type.value.petrol') . '"
                                        WHEN demands.fuel_type = "' . config('constants.demand.fuel_type.key.diesel') . '" THEN  "' . config('constants.demand.fuel_type.value.diesel') . '"
                                ELSE " "
                                END) AS fuel_type'
            ),
            'demands.demand_date',
            DB::raw(
                '(CASE
                                        WHEN demands.with_vehicle = "' . config('constants.demand.with_vehicle.key.with vehicle') . '" THEN  "' . config('constants.demand.with_vehicle.value.with vehicle') . '"
                                        WHEN demands.with_vehicle = "' . config('constants.demand.with_vehicle.key.without vehicle') . '" THEN  "' . config('constants.demand.with_vehicle.value.without vehicle') . '"
                                ELSE " "
                                END) AS with_vehicle'
            ),
            'demands.vehicle_number',
            'demands.receiver_mobile_no',
            'demands.fuel_quantity',
            'demands.quantity_fullfill',
            'demands.outstanding_quantity',
            'demands.status',
            'shifts.status as shift_status',
            'dispenser_nozzles.nozzle_number as dispenser_nozzle_nozzle_number',
            'demands.receipt_image',
            'demands.product_image',
            'demands.driver_image',
            'demands.vehicle_image'
        )
            ->leftJoin('users', 'users.id', '=', 'demands.user_id')
            ->leftJoin('shifts', 'shifts.id', '=', 'demands.shift_id')
            ->leftJoin('dispenser_nozzles', 'dispenser_nozzles.id', '=', 'demands.nozzle_id')
            ->where('demands.id', $id)
            ->groupBy('demands.id')
            ->first();

        if (! is_null($this->demand)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.demand.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.demand.show');
    }
}
