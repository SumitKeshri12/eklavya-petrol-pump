<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $organization;

    public $event = 'showorganizationInfoModal';

    #[On('show-organization-info')]
    public function show($id)
    {
        $this->organization = null;

        $this->organization = Organization::select(
            'organizations.id',
            'organizations.name',
            'organizations.owner_name',
            'organizations.contact_number',
            'organizations.email',
            'organizations.address',
            'organizations.state',
            'organizations.city',
            'organizations.pincode'
        )

            ->where('organizations.id', $id)

            ->first();

        if (! is_null($this->organization)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.organization.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.organization.show');
    }
}
