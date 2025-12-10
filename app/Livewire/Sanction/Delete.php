<?php

namespace App\Livewire\Sanction;

use App\Models\Sanction;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public $selectedSanctionIds = [];

    public $tableName;

    public bool $showModal = false;

    public bool $isBulkDelete = false;

    public int $selectedSanctionCount = 0;

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
        $this->selectedSanctionIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $sanctionIds = Sanction::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (! empty($sanctionIds)) {
            $this->selectedSanctionIds = $ids;

            $this->selectedSanctionCount = count($this->selectedSanctionIds);
            $this->isBulkDelete = $this->selectedSanctionCount > 1;

            // Get user name for single delete
            if (! $this->isBulkDelete) {
                $this->message = __('messages.sanction.messages.delete_confirmation_text');
            } else {
                $this->message = __('messages.sanction.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedSanctionIds)]);
            }

            $this->showModal = true;
        } else {
            // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.sanction.delete.record_not_found'),
            ]);
        }
    }

    public function confirmDelete()
    {
        if (! empty($this->selectedSanctionIds)) {
            // Proceed with deletion of selected sanction
            Sanction::whereIn('id', $this->selectedSanctionIds)->delete();

            session()->flash('success', __('messages.sanction.messages.delete'));

            return $this->redirect(route('sanction.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.user.messages.record_not_found'));
        }
    }

    public function hideModal()
    {
        $this->showModal = false;
        $this->selectedSanctionIds = [];
        $this->selectedSanctionCount = 0;
        $this->isBulkDelete = false;
        $this->userName = '';
    }

    public function render()
    {
        return view('livewire.sanction.delete');
    }
}
