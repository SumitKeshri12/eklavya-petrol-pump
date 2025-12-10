<?php

namespace App\Livewire\User;

use App\Helper;
use App\Livewire\Breadcrumb;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id;

    public $role_id;

    public $roles = [];

    public $user_code;

    public $user_type;

    public $party_type;

    public $first_name;

    public $last_name;

    public $party_name;

    public $email;

    public $mobile_number;

    public $password;

    public $aadhar_no;

    public $esic_number;

    public $pancard;

    public $profile;

    public $profile_image;

    public $bank_name;

    public $account_number;

    public $ifsc_code;

    public $account_holder_name;

    public $gstin;

    public $tan_number;

    public $status = 'Y';

    public $last_login_at;

    public $locale = 'en';

    public function mount()
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.user.breadcrumb.title'),
            'item_1' => '<a href="/user" class="text-muted text-hover-primary" wire:navigate>' . __('messages.user.breadcrumb.user') . '</a>',
            'item_2' => __('messages.user.breadcrumb.create'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->roles = Helper::getAllRole();
    }

    public function rules()
    {
        $rules = [
            'role_id' => 'required|exists:roles,id,deleted_at,NULL',
            'party_type' => 'nullable|in:I,B',
            'first_name' => 'required|string|max:50|regex:/^[a-zA-Z\\s]+$/',
            'last_name' => 'required|string|max:50|regex:/^[a-zA-Z\\s]+$/',
            'party_name' => 'nullable|string|max:100|regex:/^[a-zA-Z ]+$/',
            'email' => 'nullable|email|max:320',
            'mobile_number' => 'required|digits:10|regex:/^[6-9]\\d{10}$/',
            'password' => 'required|string|min:8|max:30|regex:/^(?=.*[a-z]](?=.*[A-Z]](?=.*\\d](?=.*[@$!%*?&]][A-Za-z\\d@$!%*?&]+$/',
            'aadhar_no' => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
            'esic_number' => 'nullable|string|max:17|regex:/^[0-9]{10}[A-Z]{1}$/ ',
            'pancard' => 'required|string|max:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|min:9|max:18|regex:/^[0-9]+$/',
            'ifsc_code' => 'nullable|string|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'account_holder_name' => 'nullable|string|max:100|regex:/^[a-zA-Z\\s]+$/',
            'gstin' => 'required_if:user_type,p|nullable|string|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            'tan_number' => 'required_if:user_type,p|nullable|string|regex:/^[A-Z]{4}[0-9]{5}[A-Z]{1}$/',
            'status' => 'required|in:Y,N',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'role_id.required' => __('messages.user.validation.messsage.role_id.required'),
            'party_type.in' => __('messages.user.validation.messsage.party_type.in'),
            'first_name.required' => __('messages.user.validation.messsage.first_name.required'),
            'first_name.in' => __('messages.user.validation.messsage.first_name.in'),
            'first_name.max' => __('messages.user.validation.messsage.first_name.max'),
            'last_name.required' => __('messages.user.validation.messsage.last_name.required'),
            'last_name.in' => __('messages.user.validation.messsage.last_name.in'),
            'last_name.max' => __('messages.user.validation.messsage.last_name.max'),
            'party_name.in' => __('messages.user.validation.messsage.party_name.in'),
            'party_name.max' => __('messages.user.validation.messsage.party_name.max'),
            'email.email' => __('messages.user.validation.messsage.email.email'),
            'email.max' => __('messages.user.validation.messsage.email.max'),
            'mobile_number.required' => __('messages.user.validation.messsage.mobile_number.required'),
            'password.required' => __('messages.user.validation.messsage.password.required'),
            'password.in' => __('messages.user.validation.messsage.password.in'),
            'password.min' => __('messages.user.validation.messsage.password.min'),
            'password.max' => __('messages.user.validation.messsage.password.max'),
            'esic_number.in' => __('messages.user.validation.messsage.esic_number.in'),
            'esic_number.max' => __('messages.user.validation.messsage.esic_number.max'),
            'pancard.required' => __('messages.user.validation.messsage.pancard.required'),
            'pancard.in' => __('messages.user.validation.messsage.pancard.in'),
            'pancard.max' => __('messages.user.validation.messsage.pancard.max'),
            'profile_image.max' => __('messages.user.validation.messsage.profile_image.max'),
            'bank_name.in' => __('messages.user.validation.messsage.bank_name.in'),
            'bank_name.max' => __('messages.user.validation.messsage.bank_name.max'),
            'account_number.in' => __('messages.user.validation.messsage.account_number.in'),
            'account_number.min' => __('messages.user.validation.messsage.account_number.min'),
            'account_number.max' => __('messages.user.validation.messsage.account_number.max'),
            'ifsc_code.in' => __('messages.user.validation.messsage.ifsc_code.in'),
            'account_holder_name.in' => __('messages.user.validation.messsage.account_holder_name.in'),
            'account_holder_name.max' => __('messages.user.validation.messsage.account_holder_name.max'),
            'gstin.required' => __('messages.user.validation.messsage.gstin.required'),
            'gstin.in' => __('messages.user.validation.messsage.gstin.in'),
            'tan_number.required' => __('messages.user.validation.messsage.tan_number.required'),
            'tan_number.in' => __('messages.user.validation.messsage.tan_number.in'),
            'status.required' => __('messages.user.validation.messsage.status.required'),
            'status.in' => __('messages.user.validation.messsage.status.in'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'role_id' => $this->role_id,
            'party_type' => $this->party_type,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'party_name' => $this->party_name,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'password' => bcrypt($this->password),
            'aadhar_no' => $this->aadhar_no,
            'esic_number' => $this->esic_number,
            'pancard' => $this->pancard,
            'profile' => $this->profile_image,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'ifsc_code' => $this->ifsc_code,
            'account_holder_name' => $this->account_holder_name,
            'gstin' => $this->gstin,
            'tan_number' => $this->tan_number,
            'status' => $this->status,
        ];
        $user = User::create($data);

        if ($this->profile_image) {
            $realPath = 'user/' . $user->id . '/';
            $resizeImages = $user->resizeImages($this->profile_image, $realPath, true);
            $imagePath = $realPath . pathinfo($resizeImages['image'], PATHINFO_BASENAME);
            $user->update(['profile' => $imagePath]);
        }

        session()->flash('success', __('messages.user.messages.success'));

        return $this->redirect('/user', navigate: true); // redirect to user listing page
    }

    public function render()
    {
        return view('livewire.user.create')->title(__('messages.meta_title.create_user'));
    }
}
