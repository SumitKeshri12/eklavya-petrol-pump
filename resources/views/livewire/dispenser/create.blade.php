<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <form wire:submit="store" class="space-y-3">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl lg:border border-gray-200 dark:border-gray-700 p-2 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 lg:gap-6 mb-0">
                    <div class="flex-1">
        <flux:field>
            <flux:label for="number" required>{{ __('messages.dispenser.create.label_number') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="number" id="number" wire:model="number" placeholder="Enter {{ __('messages.dispenser.create.label_number') }}" required/>
            <flux:error name="number" data-testid="number_error"/>
        </flux:field>
    </div>
            </div>
        </div>

         <div class="bg-white flex flex-row items-center justify-between dark:bg-gray-800 shadow rounded-xl p-6">
    <h3 class="font-bold text-lg">Add New Entries</h3>
    <flux:button icon:trailing="plus" wire:click.prevent="add" variant="primary" data-testid="plus_button" class="cursor-pointer"/>
</div>
<div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 space-y-4">
      @if (!empty($adds))
        <div class="space-y-4">
            @foreach ($adds as $index => $add)
                @php
                    $hasError = $errors->getBag('default')->keys()
                        ? collect($errors->getBag('default')->keys())->contains(
                            fn($key) => Str::startsWith($key, "adds.$index"),
                        )
                        : false;

                    $showAccordion = $isEdit || $hasError || $index === 0;
                @endphp
                <div x-data="{ open: {{ $showAccordion ? 'true' : 'false' }} }" class="border rounded shadow-sm">
                    <!-- Accordion Header -->
                    <button
                        type="button"
                        @click="open = !open"
                        class="flex cursor-pointer justify-between items-center w-full px-4 py-2 font-semibold text-gray-800 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 rounded-t hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <span>Add New {{ $index + 1 }}</span>
                        <span class="flex items-center gap-2">
                            @if ($index > 0)
                            <flux:icon.trash variant="solid" data-testid="remove_{{ $add['id'] }}" wire:click.prevent="remove({{ $index }}, {{ $add['id'] ?? 0 }})" class="w-5 h-5 text-red-500" />
                            @endif
                            <!-- Chevron Icon with rotation -->
                            <flux:icon.chevron-down :class="{ 'rotate-180': open }" class="transition-transform duration-200" />
                        </span>
                    </button>
                    <!-- Accordion Body -->
                    <div x-show="open" x-transition class="px-4 py-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                            <input type="hidden" name="add_id[]" value="{{ $add['id'] }}">
                                <div class="flex-1">
        <flux:field>
            <flux:label for="nozzle_number_{{$index}}" required>{{ __('messages.dispenser.create.label_nozzle_number') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="adds.{{$index}}.nozzle_number" id="nozzle_number_{{$index}}" wire:model="adds.{{$index}}.nozzle_number" placeholder="Enter {{ __('messages.dispenser.create.label_nozzle_number') }}" required/>
            <flux:error name="adds.{{$index}}.nozzle_number" data-testid="adds.{{$index}}.nozzle_number_error"/>
        </flux:field>
    </div>
                     <div class="flex-1">
        <flux:field>
            <flux:label for="fuel_type_{{$index}}" required>{{ __('messages.dispenser.create.label_fuel_type') }} <span class="text-red-500">*</span></flux:label>
            <div class="flex gap-6">
            <div class="flex items-center cursor-pointer">
                        <input data-testid="adds.{{$index}}.fuel_type" type="radio" value="{{ config('constants.dispenser.fuel_type.key.petrol') }}"  name="fuel_type_{{$index}}" required wire:model="adds.{{$index}}.fuel_type" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="fuel_type_{{$index}}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.dispenser.fuel_type.value.petrol') }}
    </label>&nbsp;&nbsp;    <input data-testid="adds.{{$index}}.fuel_type" type="radio" value="{{ config('constants.dispenser.fuel_type.key.diesel') }}"  name="fuel_type_{{$index}}" required wire:model="adds.{{$index}}.fuel_type" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="fuel_type_{{$index}}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.dispenser.fuel_type.value.diesel') }}
    </label>&nbsp;&nbsp;
                </div>
            </div>
            <flux:error name="adds.{{$index}}.fuel_type" data-testid="adds.{{$index}}.fuel_type_error"/>
        </flux:field>
    </div>
                     <div class="flex-1">
        <flux:field>
            <flux:label for="status_{{$index}}" required>{{ __('messages.dispenser.create.label_status') }} <span class="text-red-500">*</span></flux:label>
            <div class="flex gap-6">
            <div class="flex items-center cursor-pointer">
                        <input data-testid="adds.{{$index}}.status" type="radio" value="{{ config('constants.dispenser.status.key.active') }}"  name="status_{{$index}}" required wire:model="adds.{{$index}}.status" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="status_{{$index}}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.dispenser.status.value.active') }}
    </label>&nbsp;&nbsp;    <input data-testid="adds.{{$index}}.status" type="radio" value="{{ config('constants.dispenser.status.key.inactive') }}"  name="status_{{$index}}" required wire:model="adds.{{$index}}.status" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="status_{{$index}}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.dispenser.status.value.inactive') }}
    </label>&nbsp;&nbsp;
                </div>
            </div>
            <flux:error name="adds.{{$index}}.status" data-testid="adds.{{$index}}.status_error"/>
        </flux:field>
    </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-top gap-3 mt-3 lg:mt-3 border-t-2 lg:border-none border-gray-100 py-4 lg:py-0">

            <flux:button type="submit" variant="primary" data-testid="submit_button" class="cursor-pointer h-8! lg:h-9!" wire:loading.attr="disabled" wire:target="store">
                {{ __('messages.submit_button_text') }}
            </flux:button>

            <flux:button type="button" data-testid="cancel_button" class="cursor-pointer h-8! lg:h-9!" variant="outline" href="/dispenser" wire:navigate>
                {{ __('messages.cancel_button_text') }}
            </flux:button>
        </div>
    </form>
</div>
