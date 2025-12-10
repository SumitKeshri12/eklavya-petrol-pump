<?php

namespace App\Livewire\Vehicle;

use App\Models\Vehicle;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public $selectedVehicleIds = [];

    public $tableName;

    public bool $showModal = false;

    public bool $isBulkDelete = false;

    public int $selectedVehicleCount = 0;

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
        $this->selectedVehicleIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $vehicleIds = Vehicle::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (! empty($vehicleIds)) {
            $this->selectedVehicleIds = $ids;

            $this->selectedVehicleCount = count($this->selectedVehicleIds);
            $this->isBulkDelete = $this->selectedVehicleCount > 1;

            // Get user name for single delete
            if (! $this->isBulkDelete) {
                $this->message = __('messages.vehicle.messages.delete_confirmation_text');
            } else {
                $this->message = __('messages.vehicle.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedVehicleIds)]);
            }

            $this->showModal = true;
        } else {
            // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.vehicle.delete.record_not_found'),
            ]);
        }
    }

    public function confirmDelete()
    {
        if (! empty($this->selectedVehicleIds)) {
            // Proceed with deletion of selected vehicle
            Vehicle::whereIn('id', $this->selectedVehicleIds)->delete();

            session()->flash('success', __('messages.vehicle.messages.delete'));

            return $this->redirect(route('vehicle.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.user.messages.record_not_found'));
        }
    }

    public function hideModal()
    {
        $this->showModal = false;
        $this->selectedVehicleIds = [];
        $this->selectedVehicleCount = 0;
        $this->isBulkDelete = false;
        $this->userName = '';
    }

    public function render()
    {
        return view('livewire.vehicle.delete');
    }
}
