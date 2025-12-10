<?php

namespace App\Livewire\Shift;

use App\Livewire\Breadcrumb;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        /* Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.shift.breadcrumb.title'),
            'item_1' => __('messages.shift.breadcrumb.shift'),
            'item_2' => __('messages.shift.breadcrumb.list'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
    }

    public function render()
    {
        return view('livewire.shift.index')->title(__('messages.meta_title.index_shift'));
    }
}
