<?php

namespace App\Livewire\Sanction;

use App\Models\Sanction;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $sanction;

    public $event = 'showsanctionInfoModal';

    #[On('show-sanction-info')]
    public function show($id)
    {
        $this->sanction = null;

        $this->sanction = Sanction::select(
            'sanctions.id',
            'users.first_name as user_first_name',
            'sanctions.month',
            'sanctions.year',
            DB::raw(
                '(CASE
                                        WHEN sanctions.fuel_type = "' . config('constants.sanction.fuel_type.key.petrol') . '" THEN  "' . config('constants.sanction.fuel_type.value.petrol') . '"
                                        WHEN sanctions.fuel_type = "' . config('constants.sanction.fuel_type.key.diesel') . '" THEN  "' . config('constants.sanction.fuel_type.value.diesel') . '"
                                ELSE " "
                                END) AS fuel_type'
            ),
            'sanctions.quantity',
            'sanctions.remarks'
        )
            ->leftJoin('users', 'users.id', '=', 'sanctions.user_id')
            ->where('sanctions.id', $id)
            ->groupBy('sanctions.id')
            ->first();

        if (! is_null($this->sanction)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.sanction.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.sanction.show');
    }
}
