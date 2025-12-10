<div>
    <x-show-info-modal modalTitle="{{ __('messages.dispenser.show.label_dispenser') }}" :eventName="$event" :showSaveButton="false" :showCancelButton="false">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.dispenser.show.details.number') }}</flux:label>
        <flux:description>{{ $dispenser?->number ?? '-' }}</flux:description>
    </flux:field>
            </div>
        </div>
    </x-show-info-modal>
</div>
