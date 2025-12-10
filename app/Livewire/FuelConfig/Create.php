<?php

namespace App\Livewire\FuelConfig;

use App\Livewire\Breadcrumb;
use App\Models\FuelConfig;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id;

    public $fuel_type;

    public $price;

    public $date;

    public function mount()
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.fuel_config.breadcrumb.title'),
            'item_1' => '<a href="/fuel-config" class="text-muted text-hover-primary" wire:navigate>' . __('messages.fuel_config.breadcrumb.fuelconfig') . '</a>',
            'item_2' => __('messages.fuel_config.breadcrumb.create'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */
    }

    public function rules()
    {
        $rules = [
            'fuel_type' => 'required|in:P,D',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'fuel_type.required' => __('messages.fuel_config.validation.messsage.fuel_type.required'),
            'fuel_type.in' => __('messages.fuel_config.validation.messsage.fuel_type.in'),
            'price.required' => __('messages.fuel_config.validation.messsage.price.required'),
            'date.required' => __('messages.fuel_config.validation.messsage.date.required'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'fuel_type' => $this->fuel_type,
            'price' => $this->price,
            'date' => $this->date,
        ];
        $fuelconfig = FuelConfig::create($data);

        session()->flash('success', __('messages.fuel_config.messages.success'));

        return $this->redirect('/fuel-config', navigate: true); // redirect to fuel-config listing page
    }

    public function render()
    {
        return view('livewire.fuel-config.create')->title(__('messages.meta_title.create_fuel_config'));
    }
}
