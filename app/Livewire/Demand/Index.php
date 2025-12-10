<?php

namespace App\Livewire\Demand;

use App\Livewire\Breadcrumb;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        /* Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.demand.breadcrumb.title'),
            'item_1' => __('messages.demand.breadcrumb.demand'),
            'item_2' => __('messages.demand.breadcrumb.list'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
    }

    public function render()
    {
        return view('livewire.demand.index')->title(__('messages.meta_title.index_demand'));
    }
}
