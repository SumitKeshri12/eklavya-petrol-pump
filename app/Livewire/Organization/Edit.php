<?php

namespace App\Livewire\Organization;

use App\Livewire\Breadcrumb;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\Response;

class Edit extends Component
{
    use WithFileUploads;

    public $organization;

    public $id;

    public $name;

    public $owner_name;

    public $contact_number;

    public $email;

    public $address;

    public $state;

    public $city;

    public $pincode;

    public function mount($id)
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.organization.breadcrumb.title'),
            'item_1' => '<a href="/organization" class="text-muted text-hover-primary" wire:navigate>' . __('messages.organization.breadcrumb.organization') . '</a>',
            'item_2' => __('messages.organization.breadcrumb.edit'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->organization = Organization::find($id);

        if ($this->organization) {
            foreach ($this->organization->getAttributes() as $key => $value) {
                $this->{$key} = $value; // Dynamically assign the attributes to the class
            }
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:100',
            'owner_name' => 'required|string|max:100',
            'contact_number' => 'required|string|regex:/^[0-9]{10,15}$/',
            'email' => 'required|email|max:100',
            'address' => 'required|string|max:255',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|digits:6|regex:/^[0-9]{6}$/',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('messages.organization.validation.messsage.name.required'),
            'name.in' => __('messages.organization.validation.messsage.name.in'),
            'name.max' => __('messages.organization.validation.messsage.name.max'),
            'owner_name.required' => __('messages.organization.validation.messsage.owner_name.required'),
            'owner_name.in' => __('messages.organization.validation.messsage.owner_name.in'),
            'owner_name.max' => __('messages.organization.validation.messsage.owner_name.max'),
            'contact_number.required' => __('messages.organization.validation.messsage.contact_number.required'),
            'contact_number.in' => __('messages.organization.validation.messsage.contact_number.in'),
            'email.required' => __('messages.organization.validation.messsage.email.required'),
            'email.email' => __('messages.organization.validation.messsage.email.email'),
            'email.max' => __('messages.organization.validation.messsage.email.max'),
            'address.required' => __('messages.organization.validation.messsage.address.required'),
            'address.in' => __('messages.organization.validation.messsage.address.in'),
            'address.max' => __('messages.organization.validation.messsage.address.max'),
            'state.required' => __('messages.organization.validation.messsage.state.required'),
            'state.in' => __('messages.organization.validation.messsage.state.in'),
            'city.required' => __('messages.organization.validation.messsage.city.required'),
            'city.in' => __('messages.organization.validation.messsage.city.in'),
            'pincode.required' => __('messages.organization.validation.messsage.pincode.required'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'owner_name' => $this->owner_name,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            'address' => $this->address,
            'state' => $this->state,
            'city' => $this->city,
            'pincode' => $this->pincode,
        ];
        $this->organization->update($data); // Update data into the DB

        session()->flash('success', __('messages.organization.messages.update'));

        return $this->redirect('/organization', navigate: true); // redirect to organization listing page
    }

    public function render()
    {
        return view('livewire.organization.edit')->title(__('messages.meta_title.edit_organization'));
    }
}
