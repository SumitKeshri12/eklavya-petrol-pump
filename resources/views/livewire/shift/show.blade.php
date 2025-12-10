<div>
    <x-show-info-modal modalTitle="{{ __('messages.shift.show.label_shift') }}" :eventName="$event" :showSaveButton="false" :showCancelButton="false">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.shift.show.details.user_first_name') }}</flux:label>
        <flux:description>{{ !is_null($shift) ? $shift->user_first_name : '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.shift.show.details.start_time') }}</flux:label>
        <flux:description>{{ !is_null($shift) && !is_null($shift->start_time)
            ? Carbon\Carbon::parse($shift->start_time)->format(config('constants.default_time_format'))
            : '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.shift.show.details.end_time') }}</flux:label>
        <flux:description>{{ !is_null($shift) && !is_null($shift->end_time)
            ? Carbon\Carbon::parse($shift->end_time)->format(config('constants.default_time_format'))
            : '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.shift.show.details.status') }}</flux:label>
        <flux:description>{{ $shift?->status ?? '-' }}</flux:description>
    </flux:field>
            </div>
        </div>
    </x-show-info-modal>
</div>
