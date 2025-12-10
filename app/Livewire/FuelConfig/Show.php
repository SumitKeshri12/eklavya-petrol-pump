<?php

namespace App\Livewire\FuelConfig;

use App\Models\FuelConfig;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $fuelconfig;

    public $event = 'showfuelconfigInfoModal';

    #[On('show-fuelconfig-info')]
    public function show($id)
    {
        $this->fuelconfig = null;

        $this->fuelconfig = FuelConfig::select(
            'fuel_configs.id',
            DB::raw(
                '(CASE
                                        WHEN fuel_configs.fuel_type = "' . config('constants.fuel_config.fuel_type.key.petrol') . '" THEN  "' . config('constants.fuel_config.fuel_type.value.petrol') . '"
                                        WHEN fuel_configs.fuel_type = "' . config('constants.fuel_config.fuel_type.key.diesel') . '" THEN  "' . config('constants.fuel_config.fuel_type.value.diesel') . '"
                                ELSE " "
                                END) AS fuel_type'
            ),
            'fuel_configs.price',
            'fuel_configs.date'
        )

            ->where('fuel_configs.id', $id)

            ->first();

        if (! is_null($this->fuelconfig)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.fuel_config.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.fuel-config.show');
    }
}
