<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $role;

    public function mount($id)
    {
        $this->role = null;

        $this->role = Role::select(
            'roles.id',
            'roles.name'
        )

            ->where('roles.id', $id)

            ->first();

        if (is_null($this->role)) {
            session()->flash('error', __('messages.role.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.role.show');
    }
}
