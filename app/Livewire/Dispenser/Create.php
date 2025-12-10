<?php

namespace App\Livewire\Dispenser;

use App\Livewire\Breadcrumb;
use App\Models\Dispenser;
use App\Models\DispenserNozzle;
use Livewire\Component;

use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id;

    public $number;

    public $adds = [];

    public $newAdd = [
        'nozzle_number' => '',
        'fuel_type' => '',
        'status' => '',
        'id' => 0,
    ];

    public $isEdit = false;

    public function mount()
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.dispenser.breadcrumb.title'),
            'item_1' => '<a href="/dispenser" class="text-muted text-hover-primary" wire:navigate>' . __('messages.dispenser.breadcrumb.dispenser') . '</a>',
            'item_2' => __('messages.dispenser.breadcrumb.create'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->adds[] = $this->newAdd;
    }

    public function rules()
    {
        $rules = [
            'number' => 'required|min:1|max:100',
        ];
        foreach ($this->adds as $index => $add) {
            $rules["adds.$index.nozzle_number"] = 'required|min:1|max:20';
            $rules["adds.$index.fuel_type"] = 'required|in:P,D';
            $rules["adds.$index.status"] = 'required|in:Y,N';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'number.required' => __('messages.dispenser.validation.messsage.number.required'),
            'number.min' => __('messages.dispenser.validation.messsage.number.min'),
            'number.max' => __('messages.dispenser.validation.messsage.number.max'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'number' => $this->number,
        ];
        $dispenser = Dispenser::create($data);

        foreach ($this->adds as $add) {
            $DispenserNozzleId = $add['id'] ?? 0;
            $DispenserNozzleInfo = DispenserNozzle::find($DispenserNozzleId);
            $DispenserNozzleData = [
                'nozzle_number' => $add['nozzle_number'],
                'fuel_type' => $add['fuel_type'],
                'status' => $add['status'],
                'dispenser_id' => $dispenser->id,
            ];
            if ($DispenserNozzleInfo) {
                DispenserNozzle::where('id', $DispenserNozzleId)->update($DispenserNozzleData);
            } else {
                $DispenserNozzleInfo = DispenserNozzle::create($DispenserNozzleData);
            }
        }

        session()->flash('success', __('messages.dispenser.messages.success'));

        return $this->redirect('/dispenser', navigate: true); // redirect to dispenser listing page
    }

    public function render()
    {
        return view('livewire.dispenser.create')->title(__('messages.meta_title.create_dispenser'));
    }

    public function add()
    {
        if (count($this->adds) < 5) {
            $this->adds[] = $this->newAdd;
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.maximum_record_limit_error'));
        }
    }

    public function remove($index, $id)
    {
        if ($id != 0) {
            DispenserNozzle::where('id', $id)->forceDelete();
        }
        unset($this->adds[$index]);
        $this->adds = array_values($this->adds);
    }
}
