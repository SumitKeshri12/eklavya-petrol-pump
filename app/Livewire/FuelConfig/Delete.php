<?php

namespace App\Livewire\FuelConfig;

use App\Models\FuelConfig;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public $selectedFuelConfigIds = [];

    public $tableName;

    public bool $showModal = false;

    public bool $isBulkDelete = false;

    public int $selectedFuelConfigCount = 0;

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
        $this->selectedFuelConfigIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $fuelconfigIds = FuelConfig::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (! empty($fuelconfigIds)) {
            $this->selectedFuelConfigIds = $ids;

            $this->selectedFuelConfigCount = count($this->selectedFuelConfigIds);
            $this->isBulkDelete = $this->selectedFuelConfigCount > 1;

            // Get user name for single delete
            if (! $this->isBulkDelete) {
                $this->message = __('messages.fuel_config.messages.delete_confirmation_text');
            } else {
                $this->message = __('messages.fuel_config.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedFuelConfigIds)]);
            }

            $this->showModal = true;
        } else {
            // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.fuel_config.delete.record_not_found'),
            ]);
        }
    }

    public function confirmDelete()
    {
        if (! empty($this->selectedFuelConfigIds)) {
            // Proceed with deletion of selected fuel-config
            FuelConfig::whereIn('id', $this->selectedFuelConfigIds)->delete();

            session()->flash('success', __('messages.fuel_config.messages.delete'));

            return $this->redirect(route('fuel-config.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.user.messages.record_not_found'));
        }
    }

    public function hideModal()
    {
        $this->showModal = false;
        $this->selectedFuelConfigIds = [];
        $this->selectedFuelConfigCount = 0;
        $this->isBulkDelete = false;
        $this->userName = '';
    }

    public function render()
    {
        return view('livewire.fuel-config.delete');
    }
}
