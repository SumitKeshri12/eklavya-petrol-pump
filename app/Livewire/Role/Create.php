<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id;

    public $name;

    public function mount() {}

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:50|regex:/^[a-zA-Z\\s]+$/',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('messages.role.validation.messsage.name.required'),
            'name.in' => __('messages.role.validation.messsage.name.in'),
            'name.max' => __('messages.role.validation.messsage.name.max'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
        ];
        $role = Role::create($data);

        Cache::forget('getAllRole');

        session()->flash('success', __('messages.role.messages.success'));

        return $this->redirect('/role', navigate: true); // redirect to role listing page
    }

    public function render()
    {
        return view('livewire.role.create');
    }
}
