<div>
    <x-show-info-modal modalTitle="{{ __('messages.demand.show.label_demand') }}" :eventName="$event" :showSaveButton="false" :showCancelButton="false">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.demand.show.details.user_party_name') }}</flux:label>
        <flux:description>{{ !is_null($demand) ? $demand->user_party_name : '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.demand.show.details.fuel_type') }}</flux:label>
        <flux:description>{{ $demand?->fuel_type ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.demand.show.details.demand_date') }}</flux:label>
        <flux:description>{{ !is_null($demand) && !is_null($demand->demand_date)
            ? Carbon\Carbon::parse($demand->demand_date)->format(config('constants.default_date_format'))
            : '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.demand.show.details.with_vehicle') }}</flux:label>
        <flux:description>{{ $demand?->with_vehicle ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.demand.show.details.vehicle_number') }}</flux:label>
        <flux:description>{{ $demand?->vehicle_number ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.demand.show.details.receiver_mobile_no') }}</flux:label>
        <flux:description>{{ $demand?->receiver_mobile_no ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.demand.show.details.fuel_quantity') }}</flux:label>
        <flux:description>{{ $demand?->fuel_quantity ?? '-' }}</flux:description>
    </flux:field>
            </div>
        </div>
    </x-show-info-modal>
</div>
