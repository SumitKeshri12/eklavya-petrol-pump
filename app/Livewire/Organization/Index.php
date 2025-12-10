<?php

namespace App\Livewire\Organization;

use App\Livewire\Breadcrumb;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        /* Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.organization.breadcrumb.title'),
            'item_1' => __('messages.organization.breadcrumb.organization'),
            'item_2' => __('messages.organization.breadcrumb.list'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
    }

    public function render()
    {
        return view('livewire.organization.index')->title(__('messages.meta_title.index_organization'));
    }
}
