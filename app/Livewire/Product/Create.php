<?php

namespace App\Livewire\Product;

use App\Livewire\Breadcrumb;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id;

    public $name;

    public $chr_code;

    public $hsn_code;

    public $category;

    public $unit = 'LI';

    public $tax_rate;

    public $cess;

    public $opening_quantity;

    public $opening_rate;

    public $purchase_rate;

    public $opening_value;

    public $selling_rate;

    public function mount()
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.product.breadcrumb.title'),
            'item_1' => '<a href="/product" class="text-muted text-hover-primary" wire:navigate>' . __('messages.product.breadcrumb.product') . '</a>',
            'item_2' => __('messages.product.breadcrumb.create'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:50|unique:products,name',
            'chr_code' => 'required|string|max:20|unique:products,chr_code|regex:/^[A-Z0-9]+$/',
            'hsn_code' => 'required|string|max:8',
            'category' => 'required|string',
            'unit' => 'required|in:LI,ML,GA,PT,QT,CU,QT',
            'tax_rate' => 'required|numeric',
            'cess' => 'nullable|numeric',
            'opening_quantity' => 'required|numeric',
            'opening_rate' => 'required|numeric',
            'purchase_rate' => 'required|numeric',
            'opening_value' => 'required|numeric',
            'selling_rate' => 'required|numeric',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('messages.product.validation.messsage.name.required'),
            'name.in' => __('messages.product.validation.messsage.name.in'),
            'name.max' => __('messages.product.validation.messsage.name.max'),
            'chr_code.required' => __('messages.product.validation.messsage.chr_code.required'),
            'chr_code.in' => __('messages.product.validation.messsage.chr_code.in'),
            'chr_code.max' => __('messages.product.validation.messsage.chr_code.max'),
            'hsn_code.required' => __('messages.product.validation.messsage.hsn_code.required'),
            'hsn_code.in' => __('messages.product.validation.messsage.hsn_code.in'),
            'hsn_code.max' => __('messages.product.validation.messsage.hsn_code.max'),
            'category.required' => __('messages.product.validation.messsage.category.required'),
            'category.in' => __('messages.product.validation.messsage.category.in'),
            'unit.required' => __('messages.product.validation.messsage.unit.required'),
            'unit.in' => __('messages.product.validation.messsage.unit.in'),
            'tax_rate.required' => __('messages.product.validation.messsage.tax_rate.required'),
            'opening_quantity.required' => __('messages.product.validation.messsage.opening_quantity.required'),
            'opening_rate.required' => __('messages.product.validation.messsage.opening_rate.required'),
            'purchase_rate.required' => __('messages.product.validation.messsage.purchase_rate.required'),
            'opening_value.required' => __('messages.product.validation.messsage.opening_value.required'),
            'selling_rate.required' => __('messages.product.validation.messsage.selling_rate.required'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'chr_code' => $this->chr_code,
            'hsn_code' => $this->hsn_code,
            'category' => $this->category,
            'unit' => $this->unit,
            'tax_rate' => $this->tax_rate,
            'cess' => $this->cess,
            'opening_quantity' => $this->opening_quantity,
            'opening_rate' => $this->opening_rate,
            'purchase_rate' => $this->purchase_rate,
            'opening_value' => $this->opening_value,
            'selling_rate' => $this->selling_rate,
        ];
        $product = Product::create($data);

        Cache::forget('getAllProduct');

        session()->flash('success', __('messages.product.messages.success'));

        return $this->redirect('/product', navigate: true); // redirect to product listing page
    }

    public function render()
    {
        return view('livewire.product.create')->title(__('messages.meta_title.create_product'));
    }
}
