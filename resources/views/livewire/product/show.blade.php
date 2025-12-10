<div>
    <x-show-info-modal modalTitle="{{ __('messages.product.show.label_product') }}" :eventName="$event" :showSaveButton="false" :showCancelButton="false">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.name') }}</flux:label>
        <flux:description>{{ $product?->name ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.chr_code') }}</flux:label>
        <flux:description>{{ $product?->chr_code ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.hsn_code') }}</flux:label>
        <flux:description>{{ $product?->hsn_code ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.category') }}</flux:label>
        <flux:description>{{ $product?->category ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.unit') }}</flux:label>
        <flux:description>{{ $product?->unit ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.tax_rate') }}</flux:label>
        <flux:description>{{ $product?->tax_rate ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.cess') }}</flux:label>
        <flux:description>{{ $product?->cess ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.opening_quantity') }}</flux:label>
        <flux:description>{{ $product?->opening_quantity ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.opening_rate') }}</flux:label>
        <flux:description>{{ $product?->opening_rate ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.purchase_rate') }}</flux:label>
        <flux:description>{{ $product?->purchase_rate ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.opening_value') }}</flux:label>
        <flux:description>{{ $product?->opening_value ?? '-' }}</flux:description>
    </flux:field>
                             <flux:field class="border-b border-gray-200 dark:border-gray-700 gap-1!">
        <flux:label>{{ __('messages.product.show.details.selling_rate') }}</flux:label>
        <flux:description>{{ $product?->selling_rate ?? '-' }}</flux:description>
    </flux:field>
            </div>
        </div>
    </x-show-info-modal>
</div>
