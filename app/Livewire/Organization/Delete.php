<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public $selectedOrganizationIds = [];

    public $tableName;

    public bool $showModal = false;

    public bool $isBulkDelete = false;

    public int $selectedOrganizationCount = 0;

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
        $this->selectedOrganizationIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $organizationIds = Organization::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (! empty($organizationIds)) {
            $this->selectedOrganizationIds = $ids;

            $this->selectedOrganizationCount = count($this->selectedOrganizationIds);
            $this->isBulkDelete = $this->selectedOrganizationCount > 1;

            // Get user name for single delete
            if (! $this->isBulkDelete) {
                $this->message = __('messages.organization.messages.delete_confirmation_text');
            } else {
                $this->message = __('messages.organization.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedOrganizationIds)]);
            }

            $this->showModal = true;
        } else {
            // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.organization.delete.record_not_found'),
            ]);
        }
    }

    public function confirmDelete()
    {
        if (! empty($this->selectedOrganizationIds)) {
            // Proceed with deletion of selected organization
            Organization::whereIn('id', $this->selectedOrganizationIds)->delete();

            session()->flash('success', __('messages.organization.messages.delete'));

            return $this->redirect(route('organization.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.user.messages.record_not_found'));
        }
    }

    public function hideModal()
    {
        $this->showModal = false;
        $this->selectedOrganizationIds = [];
        $this->selectedOrganizationCount = 0;
        $this->isBulkDelete = false;
        $this->userName = '';
    }

    public function render()
    {
        return view('livewire.organization.delete');
    }
}
