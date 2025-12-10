<?php

namespace App\Livewire\Demand;

use App\Models\Demand;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public $selectedDemandIds = [];

    public $tableName;

    public bool $showModal = false;

    public bool $isBulkDelete = false;

    public int $selectedDemandCount = 0;

    public string $userName = '';

    public $message;

    #[On('delete-confirmation')]
    public function deleteConfirmation($ids, $tableName)
    {
        $this->handleDeleteConfirmation($ids, $tableName);
    }

    #[On('bulk-delete-confirmation')]
    public function bulkDeleteConfirmation($data)
    {
        $ids = $data['ids'] ?? [];
        $tableName = $data['tableName'] ?? '';
        $this->handleDeleteConfirmation($ids, $tableName);
    }

    #[On('delete-confirmation')]
    public function handleDeleteConfirmation($ids, $tableName)
    {
        // Initialize table name and reset selected ids
        $this->tableName = $tableName;
        $this->selectedDemandIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $demandIds = Demand::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (! empty($demandIds)) {
            $this->selectedDemandIds = $ids;

            $this->selectedDemandCount = count($this->selectedDemandIds);
            $this->isBulkDelete = $this->selectedDemandCount > 1;

            // Get user name for single delete
            if (! $this->isBulkDelete) {
                $this->message = __('messages.demand.messages.delete_confirmation_text');
            } else {
                $this->message = __('messages.demand.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedDemandIds)]);
            }

            $this->showModal = true;
        } else {
            // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.demand.delete.record_not_found'),
            ]);
        }
    }

    public function confirmDelete()
    {
        if (! empty($this->selectedDemandIds)) {
            // Proceed with deletion of selected demand
            Demand::whereIn('id', $this->selectedDemandIds)->delete();

            session()->flash('success', __('messages.demand.messages.delete'));

            return $this->redirect(route('demand.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.user.messages.record_not_found'));
        }
    }

    public function hideModal()
    {
        $this->showModal = false;
        $this->selectedDemandIds = [];
        $this->selectedDemandCount = 0;
        $this->isBulkDelete = false;
        $this->userName = '';
    }

    public function render()
    {
        return view('livewire.demand.delete');
    }
}
