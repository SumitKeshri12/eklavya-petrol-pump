<div>
    <x-show-info-modal modalTitle="{{ __('messages.push_notification_template.show.label_push_notification_template') }}" :eventName="$event" :showSaveButton="false" :showCancelButton="false">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.push_notification_template.show.details.type') }}</flux:label>
        <flux:description>{{ $pushnotificationtemplate?->type ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.push_notification_template.show.details.label') }}</flux:label>
        <flux:description>{{ $pushnotificationtemplate?->label ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.push_notification_template.show.details.title') }}</flux:label>
        <flux:description>{{ $pushnotificationtemplate?->title ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.push_notification_template.show.details.body') }}</flux:label>
        <flux:description>{{ $pushnotificationtemplate?->body ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.push_notification_template.show.details.image') }}</flux:label>
        <flux:description>{!! isset($pushnotificationtemplate) && $pushnotificationtemplate->image !='' ? '<a target="_blank" class="btn btn-light-info" href="' . $pushnotificationtemplate->image . '">View Image <i class="las la-file-image fs-4 me-2"></i></a>' : '-' !!}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.push_notification_template.show.details.button_name') }}</flux:label>
        <flux:description>{{ $pushnotificationtemplate?->button_name ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.push_notification_template.show.details.button_link') }}</flux:label>
        <flux:description>{{ $pushnotificationtemplate?->button_link ?? '-' }}</flux:description>
    </flux:field>
            </div>
        </div>
    </x-show-info-modal>
</div>
