<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $product;

    public $event = 'showproductInfoModal';

    #[On('show-product-info')]
    public function show($id)
    {
        $this->product = null;

        $this->product = Product::select(
            'products.id',
            'products.name',
            'products.chr_code',
            'products.hsn_code',
            'products.category',
            DB::raw(
                '(CASE
                                        WHEN products.unit = "' . config('constants.product.unit.key.liter') . '" THEN  "' . config('constants.product.unit.value.liter') . '"
                                        WHEN products.unit = "' . config('constants.product.unit.key.milliliter') . '" THEN  "' . config('constants.product.unit.value.milliliter') . '"
                                        WHEN products.unit = "' . config('constants.product.unit.key.gallon') . '" THEN  "' . config('constants.product.unit.value.gallon') . '"
                                        WHEN products.unit = "' . config('constants.product.unit.key.pint') . '" THEN  "' . config('constants.product.unit.value.pint') . '"
                                        WHEN products.unit = "' . config('constants.product.unit.key.qty') . '" THEN  "' . config('constants.product.unit.value.qty') . '"
                                        WHEN products.unit = "' . config('constants.product.unit.key.cup') . '" THEN  "' . config('constants.product.unit.value.cup') . '"
                                ELSE " "
                                END) AS unit'
            ),
            'products.tax_rate',
            'products.cess',
            'products.opening_quantity',
            'products.opening_rate',
            'products.purchase_rate',
            'products.opening_value',
            'products.selling_rate'
        )

            ->where('products.id', $id)

            ->first();

        if (! is_null($this->product)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.product.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.product.show');
    }
}
