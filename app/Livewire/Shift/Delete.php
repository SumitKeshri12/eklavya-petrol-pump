<?php

namespace App\Livewire\Shift;

use App\Models\Shift;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public $selectedShiftIds = [];

    public $tableName;

    public bool $showModal = false;

    public bool $isBulkDelete = false;

    public int $selectedShiftCount = 0;

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
        $this->selectedShiftIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $shiftIds = Shift::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (! empty($shiftIds)) {
            $this->selectedShiftIds = $ids;

            $this->selectedShiftCount = count($this->selectedShiftIds);
            $this->isBulkDelete = $this->selectedShiftCount > 1;

            // Get user name for single delete
            if (! $this->isBulkDelete) {
                $this->message = __('messages.shift.messages.delete_confirmation_text');
            } else {
                $this->message = __('messages.shift.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedShiftIds)]);
            }

            $this->showModal = true;
        } else {
            // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.shift.delete.record_not_found'),
            ]);
        }
    }

    public function confirmDelete()
    {
        if (! empty($this->selectedShiftIds)) {
            // Proceed with deletion of selected shift
            Shift::whereIn('id', $this->selectedShiftIds)->delete();

            session()->flash('success', __('messages.shift.messages.delete'));

            return $this->redirect(route('shift.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.user.messages.record_not_found'));
        }
    }

    public function hideModal()
    {
        $this->showModal = false;
        $this->selectedShiftIds = [];
        $this->selectedShiftCount = 0;
        $this->isBulkDelete = false;
        $this->userName = '';
    }

    public function render()
    {
        return view('livewire.shift.delete');
    }
}
