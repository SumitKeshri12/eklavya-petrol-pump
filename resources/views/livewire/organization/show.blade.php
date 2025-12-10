<div>
    <x-show-info-modal modalTitle="{{ __('messages.organization.show.label_organization') }}" :eventName="$event" :showSaveButton="false" :showCancelButton="false">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.organization.show.details.name') }}</flux:label>
        <flux:description>{{ $organization?->name ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.organization.show.details.owner_name') }}</flux:label>
        <flux:description>{{ $organization?->owner_name ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.organization.show.details.contact_number') }}</flux:label>
        <flux:description>{{ $organization?->contact_number ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.organization.show.details.email') }}</flux:label>
        <flux:description>{{ $organization?->email ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.organization.show.details.address') }}</flux:label>
        <flux:description>{{ $organization?->address ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.organization.show.details.state') }}</flux:label>
        <flux:description>{{ $organization?->state ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.organization.show.details.city') }}</flux:label>
        <flux:description>{{ $organization?->city ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.organization.show.details.pincode') }}</flux:label>
        <flux:description>{{ $organization?->pincode ?? '-' }}</flux:description>
    </flux:field>
            </div>
        </div>
    </x-show-info-modal>
</div>
