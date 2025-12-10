<?php

namespace App\Livewire\PushNotificationTemplate;

use App\Models\PushNotificationTemplate;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public $selectedPushNotificationTemplateIds = [];

    public $tableName;

    public bool $showModal = false;

    public bool $isBulkDelete = false;

    public int $selectedPushNotificationTemplateCount = 0;

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
        $this->selectedPushNotificationTemplateIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $pushnotificationtemplateIds = PushNotificationTemplate::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (! empty($pushnotificationtemplateIds)) {
            $this->selectedPushNotificationTemplateIds = $ids;

            $this->selectedPushNotificationTemplateCount = count($this->selectedPushNotificationTemplateIds);
            $this->isBulkDelete = $this->selectedPushNotificationTemplateCount > 1;

            // Get user name for single delete
            if (! $this->isBulkDelete) {
                $this->message = __('messages.push_notification_template.messages.delete_confirmation_text');
            } else {
                $this->message = __('messages.push_notification_template.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedPushNotificationTemplateIds)]);
            }

            $this->showModal = true;
        } else {
            // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.push_notification_template.delete.record_not_found'),
            ]);
        }
    }

    public function confirmDelete()
    {
        if (! empty($this->selectedPushNotificationTemplateIds)) {
            // Proceed with deletion of selected push-notification-template
            PushNotificationTemplate::whereIn('id', $this->selectedPushNotificationTemplateIds)->delete();

            session()->flash('success', __('messages.push_notification_template.messages.delete'));

            return $this->redirect(route('push-notification-template.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.user.messages.record_not_found'));
        }
    }

    public function hideModal()
    {
        $this->showModal = false;
        $this->selectedPushNotificationTemplateIds = [];
        $this->selectedPushNotificationTemplateCount = 0;
        $this->isBulkDelete = false;
        $this->userName = '';
    }

    public function render()
    {
        return view('livewire.push-notification-template.delete');
    }
}
