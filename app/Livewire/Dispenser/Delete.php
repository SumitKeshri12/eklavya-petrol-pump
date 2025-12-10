<?php

namespace App\Livewire\Dispenser;

use App\Models\Dispenser;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public $selectedDispenserIds = [];

    public $tableName;

    public bool $showModal = false;

    public bool $isBulkDelete = false;

    public int $selectedDispenserCount = 0;

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
        $this->selectedDispenserIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $dispenserIds = Dispenser::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (! empty($dispenserIds)) {
            $this->selectedDispenserIds = $ids;

            $this->selectedDispenserCount = count($this->selectedDispenserIds);
            $this->isBulkDelete = $this->selectedDispenserCount > 1;

            // Get user name for single delete
            if (! $this->isBulkDelete) {
                $this->message = __('messages.dispenser.messages.delete_confirmation_text');
            } else {
                $this->message = __('messages.dispenser.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedDispenserIds)]);
            }

            $this->showModal = true;
        } else {
            // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.dispenser.delete.record_not_found'),
            ]);
        }
    }

    public function confirmDelete()
    {
        if (! empty($this->selectedDispenserIds)) {
            // Proceed with deletion of selected dispenser
            Dispenser::whereIn('id', $this->selectedDispenserIds)->delete();

            session()->flash('success', __('messages.dispenser.messages.delete'));

            return $this->redirect(route('dispenser.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.user.messages.record_not_found'));
        }
    }

    public function hideModal()
    {
        $this->showModal = false;
        $this->selectedDispenserIds = [];
        $this->selectedDispenserCount = 0;
        $this->isBulkDelete = false;
        $this->userName = '';
    }

    public function render()
    {
        return view('livewire.dispenser.delete');
    }
}
