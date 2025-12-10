<div>
    <x-show-info-modal modalTitle="{{ __('messages.sanction.show.label_sanction') }}" :eventName="$event" :showSaveButton="false" :showCancelButton="false">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.sanction.show.details.user_first_name') }}</flux:label>
        <flux:description>{{ !is_null($sanction) ? $sanction->user_first_name : '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.sanction.show.details.month') }}</flux:label>
        <flux:description>{{ !is_null($sanction) && !is_null($sanction->month)
            ? Carbon\Carbon::parse($sanction->month)->format(config('constants.default_date_format'))
            : '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.sanction.show.details.year') }}</flux:label>
        <flux:description>{{ !is_null($sanction) && !is_null($sanction->year)
            ? Carbon\Carbon::parse($sanction->year)->format(config('constants.default_date_format'))
            : '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.sanction.show.details.fuel_type') }}</flux:label>
        <flux:description>{{ $sanction?->fuel_type ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.sanction.show.details.quantity') }}</flux:label>
        <flux:description>{{ $sanction?->quantity ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.sanction.show.details.remarks') }}</flux:label>
        <flux:description>{{ $sanction?->remarks ?? '-' }}</flux:description>
    </flux:field>
            </div>
        </div>
    </x-show-info-modal>
</div>
