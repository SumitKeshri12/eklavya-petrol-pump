<?php

namespace App\Livewire\Demand;

use App\Helper;
use App\Livewire\Breadcrumb;
use App\Models\Demand;
use App\Models\DemandProduct;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

use Symfony\Component\HttpFoundation\Response;

class Edit extends Component
{
    use WithFileUploads;

    public $demand;

    public $id;

    public $user_id;

    public $users = [];

    public $fuel_type;

    public $demand_date;

    public $with_vehicle;

    public $vehicle_number;

    public $receiver_mobile_no;

    public $fuel_quantity;

    public $quantity_fullfill;

    public $outstanding_quantity;

    public $status;

    public $shift_id;

    public $shifts = [];

    public $nozzle_id;

    public $dispenser_nozzles = [];

    public $receipt_image;

    public $product_image;

    public $driver_image;

    public $vehicle_image;

    public $products = [];

    public $adds = [];

    public $newAdd = [
        'product_id' => '',
        'quantity' => '',
        'id' => 0,
    ];

    public $isEdit = true;

    public function mount($id)
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.demand.breadcrumb.title'),
            'item_1' => '<a href="/demand" class="text-muted text-hover-primary" wire:navigate>' . __('messages.demand.breadcrumb.demand') . '</a>',
            'item_2' => __('messages.demand.breadcrumb.edit'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->demand = Demand::find($id);

        if ($this->demand) {
            foreach ($this->demand->getAttributes() as $key => $value) {
                $this->{$key} = $value; // Dynamically assign the attributes to the class
            }
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }

        $this->users = Helper::getAllUser();
        $this->shifts = \App\Models\Shift::all();
        $this->dispenser_nozzles = \App\Models\DispenserNozzle::all();
        $this->products = \App\Models\Product::all();
        $DemandProductInfo = DemandProduct::select('product_id', 'quantity', 'id')->where('demand_id', $id)->get();
        if ($DemandProductInfo->isNotEmpty()) {
            foreach ($DemandProductInfo as $index => $addInfo) {
                $this->adds[] = [
                    'product_id' => $addInfo->product_id,
                    'quantity' => $addInfo->quantity,
                    'id' => $addInfo->id,
                ];
            }
        } else {
            $this->adds = [$this->newAdd];
        }
    }

    public function rules()
    {
        $rules = [
            'user_id' => 'required|exists:users,id,deleted_at,NULL',
            'fuel_type' => 'required|in:P,D',
            'demand_date' => 'required:date_format:Y-m-d',
            'with_vehicle' => 'required|in:W,O',
            'vehicle_number' => 'required_if:with_vehicle,W|string|max:12',
            'receiver_mobile_no' => 'required_if:with_vehicle,O|digits:10|regex:/^[6-9]\\d{9}$/',
            'fuel_quantity' => 'required|numeric',
        ];
        foreach ($this->adds as $index => $add) {
            $rules["adds.$index.product_id"] = 'required|exists:products,id,deleted_at,NULL';
            $rules["adds.$index.quantity"] = 'required|numeric';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'user_id.required' => __('messages.demand.validation.messsage.user_id.required'),
            'fuel_type.required' => __('messages.demand.validation.messsage.fuel_type.required'),
            'fuel_type.in' => __('messages.demand.validation.messsage.fuel_type.in'),
            'demand_date.required' => __('messages.demand.validation.messsage.demand_date.required'),
            'with_vehicle.required' => __('messages.demand.validation.messsage.with_vehicle.required'),
            'with_vehicle.in' => __('messages.demand.validation.messsage.with_vehicle.in'),
            'vehicle_number.required' => __('messages.demand.validation.messsage.vehicle_number.required'),
            'vehicle_number.in' => __('messages.demand.validation.messsage.vehicle_number.in'),
            'vehicle_number.max' => __('messages.demand.validation.messsage.vehicle_number.max'),
            'receiver_mobile_no.required' => __('messages.demand.validation.messsage.receiver_mobile_no.required'),
            'fuel_quantity.required' => __('messages.demand.validation.messsage.fuel_quantity.required'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'user_id' => $this->user_id,
            'fuel_type' => $this->fuel_type,
            'demand_date' => $this->demand_date,
            'with_vehicle' => $this->with_vehicle,
            'vehicle_number' => $this->vehicle_number,
            'receiver_mobile_no' => $this->receiver_mobile_no,
            'fuel_quantity' => $this->fuel_quantity,
        ];
        $this->demand->update($data); // Update data into the DB

        foreach ($this->adds as $add) {
            $DemandProductId = $add['id'] ?? 0;
            $DemandProductInfo = DemandProduct::find($DemandProductId);
            $DemandProductData = [
                'product_id' => $add['product_id'],
                'quantity' => $add['quantity'],
                'demand_id' => $this->demand->id,
            ];
            if ($DemandProductInfo) {
                DemandProduct::where('id', $DemandProductId)->update($DemandProductData);
            } else {
                $DemandProductInfo = DemandProduct::create($DemandProductData);
            }
        }

        session()->flash('success', __('messages.demand.messages.update'));

        return $this->redirect('/demand', navigate: true); // redirect to demand listing page
    }

    public function render()
    {
        return view('livewire.demand.edit')->title(__('messages.meta_title.edit_demand'));
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
            DemandProduct::where('id', $id)->forceDelete();
        }
        unset($this->adds[$index]);
        $this->adds = array_values($this->adds);
    }
}
