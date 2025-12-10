<?php

namespace App\Livewire\FuelConfig;

use App\Livewire\Breadcrumb;
use App\Models\FuelConfig;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\Response;

class Edit extends Component
{
    use WithFileUploads;

    public $fuelconfig;

    public $id;

    public $fuel_type;

    public $price;

    public $date;

    public function mount($id)
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.fuel_config.breadcrumb.title'),
            'item_1' => '<a href="/fuel_config" class="text-muted text-hover-primary" wire:navigate>' . __('messages.fuel_config.breadcrumb.fuel_config') . '</a>',
            'item_2' => __('messages.fuel_config.breadcrumb.edit'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->fuelconfig = FuelConfig::find($id);

        if ($this->fuelconfig) {
            foreach ($this->fuelconfig->getAttributes() as $key => $value) {
                $this->{$key} = $value; // Dynamically assign the attributes to the class
            }
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
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
        $this->fuelconfig->update($data); // Update data into the DB

        session()->flash('success', __('messages.fuel_config.messages.update'));

        return $this->redirect('/fuel-config', navigate: true); // redirect to fuel-config listing page
    }

    public function render()
    {
        return view('livewire.fuel-config.edit')->title(__('messages.meta_title.edit_fuel_config'));
    }
}
