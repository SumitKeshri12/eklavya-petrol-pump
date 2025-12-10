<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $user;

    public $event = 'showuserInfoModal';

    #[On('show-user-info')]
    public function show($id)
    {
        $this->user = null;

        $this->user = User::select(
            'users.id',
            'roles.name as role_name',
            'users.user_code',
            'users.user_type',
            DB::raw(
                '(CASE
                                        WHEN users.party_type = "' . config('constants.user.party_type.key.individual') . '" THEN  "' . config('constants.user.party_type.value.individual') . '"
                                        WHEN users.party_type = "' . config('constants.user.party_type.key.business') . '" THEN  "' . config('constants.user.party_type.value.business') . '"
                                ELSE " "
                                END) AS party_type'
            ),
            'users.first_name',
            'users.last_name',
            'users.party_name',
            'users.email',
            'users.mobile_number',
            'users.password',
            'users.aadhar_no',
            'users.esic_number',
            'users.pancard',
            'users.profile',
            'users.bank_name',
            'users.account_number',
            'users.ifsc_code',
            'users.account_holder_name',
            'users.gstin',
            'users.tan_number',
            DB::raw(
                '(CASE
                                        WHEN users.status = "' . config('constants.user.status.key.active') . '" THEN  "' . config('constants.user.status.value.active') . '"
                                        WHEN users.status = "' . config('constants.user.status.key.inactive') . '" THEN  "' . config('constants.user.status.value.inactive') . '"
                                ELSE " "
                                END) AS status'
            ),
            'users.last_login_at',
            'users.locale'
        )
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->where('users.id', $id)
            ->groupBy('users.id')
            ->first();

        if (! is_null($this->user)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.user.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.user.show');
    }
}
