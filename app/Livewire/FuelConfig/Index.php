<?php

namespace App\Livewire\FuelConfig;

use App\Livewire\Breadcrumb;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        /* Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.fuel_config.breadcrumb.title'),
            'item_1' => __('messages.fuel_config.breadcrumb.fuel_config'),
            'item_2' => __('messages.fuel_config.breadcrumb.list'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
    }

    public function render()
    {
        return view('livewire.fuel-config.index')->title(__('messages.meta_title.index_fuel_config'));
    }
}
