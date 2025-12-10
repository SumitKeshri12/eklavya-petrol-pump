<div>
    <x-show-info-modal modalTitle="{{ __('messages.vehicle.show.label_vehicle') }}" :eventName="$event" :showSaveButton="false" :showCancelButton="false">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.vehicle.show.details.user_first_name') }}</flux:label>
        <flux:description>{{ !is_null($vehicle) ? $vehicle->user_first_name : '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.vehicle.show.details.vehicle_number') }}</flux:label>
        <flux:description>{{ $vehicle?->vehicle_number ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.vehicle.show.details.fuel_type') }}</flux:label>
        <flux:description>{{ $vehicle?->fuel_type ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.vehicle.show.details.status') }}</flux:label>
        <flux:description>{{ $vehicle?->status ?? '-' }}</flux:description>
    </flux:field>
            </div>
        </div>
    </x-show-info-modal>
</div>
