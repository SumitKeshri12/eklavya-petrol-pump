<?php

namespace App\Livewire\Shift;

use App\Models\Shift;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $shift;

    public $event = 'showshiftInfoModal';

    #[On('show-shift-info')]
    public function show($id)
    {
        $this->shift = null;

        $this->shift = Shift::select(
            'shifts.id',
            'users.first_name as user_first_name',
            'shifts.start_time',
            'shifts.end_time',
            DB::raw(
                '(CASE
                                        WHEN shifts.status = "' . config('constants.shift.status.key.ongoing') . '" THEN  "' . config('constants.shift.status.value.ongoing') . '"
                                        WHEN shifts.status = "' . config('constants.shift.status.key.completed') . '" THEN  "' . config('constants.shift.status.value.completed') . '"
                                ELSE " "
                                END) AS status'
            )
        )
            ->leftJoin('users', 'users.id', '=', 'shifts.user_id')
            ->where('shifts.id', $id)
            ->groupBy('shifts.id')
            ->first();

        if (! is_null($this->shift)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.shift.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.shift.show');
    }
}
