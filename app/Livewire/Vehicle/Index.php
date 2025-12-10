<?php

namespace App\Livewire\Vehicle;

use App\Livewire\Breadcrumb;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        /* Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.vehicle.breadcrumb.title'),
            'item_1' => __('messages.vehicle.breadcrumb.vehicle'),
            'item_2' => __('messages.vehicle.breadcrumb.list'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
    }

    public function render()
    {
        return view('livewire.vehicle.index')->title(__('messages.meta_title.index_vehicle'));
    }
}
