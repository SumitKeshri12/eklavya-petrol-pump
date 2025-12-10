<div>
    <x-show-info-modal modalTitle="{{ __('messages.user.show.label_user') }}" :eventName="$event" :showSaveButton="false" :showCancelButton="false">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.role_name') }}</flux:label>
        <flux:description>{{ !is_null($user) ? $user->role_name : '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.party_type') }}</flux:label>
        <flux:description>{{ $user?->party_type ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.first_name') }}</flux:label>
        <flux:description>{{ $user?->first_name ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.last_name') }}</flux:label>
        <flux:description>{{ $user?->last_name ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.party_name') }}</flux:label>
        <flux:description>{{ $user?->party_name ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.email') }}</flux:label>
        <flux:description>{{ $user?->email ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.mobile_number') }}</flux:label>
        <flux:description>{{ $user?->mobile_number ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.aadhar_no') }}</flux:label>
        <flux:description>{{ $user?->aadhar_no ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.esic_number') }}</flux:label>
        <flux:description>{{ $user?->esic_number ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.pancard') }}</flux:label>
        <flux:description>{{ $user?->pancard ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.profile') }}</flux:label>
        <flux:description>{!! isset($user) && $user->profile !='' ? '<a target="_blank" class="btn btn-light-info" href="' . $user->profile . '">View Image <i class="las la-file-image fs-4 me-2"></i></a>' : '-' !!}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.bank_name') }}</flux:label>
        <flux:description>{{ $user?->bank_name ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.account_number') }}</flux:label>
        <flux:description>{{ $user?->account_number ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.ifsc_code') }}</flux:label>
        <flux:description>{{ $user?->ifsc_code ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.account_holder_name') }}</flux:label>
        <flux:description>{{ $user?->account_holder_name ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.gstin') }}</flux:label>
        <flux:description>{{ $user?->gstin ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.tan_number') }}</flux:label>
        <flux:description>{{ $user?->tan_number ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.user.show.details.status') }}</flux:label>
        <flux:description>{{ $user?->status ?? '-' }}</flux:description>
    </flux:field>
            </div>
        </div>
    </x-show-info-modal>
</div>
