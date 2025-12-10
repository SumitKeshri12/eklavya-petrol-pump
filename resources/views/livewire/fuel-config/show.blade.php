<div>
    <x-show-info-modal modalTitle="{{ __('messages.fuel_config.show.label_fuel_config') }}" :eventName="$event" :showSaveButton="false" :showCancelButton="false">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.fuel_config.show.details.fuel_type') }}</flux:label>
        <flux:description>{{ $fuelconfig?->fuel_type ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.fuel_config.show.details.price') }}</flux:label>
        <flux:description>{{ $fuelconfig?->price ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.fuel_config.show.details.date') }}</flux:label>
        <flux:description>{{ !is_null($fuelconfig) && !is_null($fuelconfig->date)
            ? Carbon\Carbon::parse($fuelconfig->date)->format(config('constants.default_date_format'))
            : '-' }}</flux:description>
    </flux:field>
            </div>
        </div>
    </x-show-info-modal>
</div>
