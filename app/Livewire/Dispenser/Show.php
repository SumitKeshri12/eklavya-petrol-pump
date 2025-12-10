<?php

namespace App\Livewire\Dispenser;

use App\Models\Dispenser;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $dispenser;

    public $event = 'showdispenserInfoModal';

    #[On('show-dispenser-info')]
    public function show($id)
    {
        $this->dispenser = null;

        $this->dispenser = Dispenser::select(
            'dispensers.id',
            'dispensers.number'
        )

            ->where('dispensers.id', $id)

            ->first();

        if (! is_null($this->dispenser)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.dispenser.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.dispenser.show');
    }
}
