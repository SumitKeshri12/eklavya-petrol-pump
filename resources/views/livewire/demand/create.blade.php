<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <form wire:submit="store" class="space-y-3">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl lg:border border-gray-200 dark:border-gray-700 p-2 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 lg:gap-6 mb-0">
                     <x-flux.single-select id="user_id" label="{{ __('messages.demand.create.label_users') }}" wire:model="user_id" data-testid="user_id" required>
        <option value='' >Select {{ __('messages.demand.create.label_users') }}</option>
   @if (!empty($users))
       @foreach ($users as $value) 
           <option value="{{ $value->id}}" >{{$value->party_name}}</option>
       @endforeach 
   @endif
    </x-flux.single-select>
                              <x-flux.single-select id="fuel_type" label="{{ __('messages.demand.create.label_fuel_type') }}" wire:model="fuel_type" data-testid="fuel_type" required>
        <option value=''>Select {{ __('messages.demand.create.label_fuel_type') }}</option>
<option value="{{ config('constants.demand.fuel_type.key.petrol') }}" > {{ config("constants.demand.fuel_type.value.petrol") }}</option><option value="{{ config('constants.demand.fuel_type.key.diesel') }}" > {{ config("constants.demand.fuel_type.value.diesel") }}</option>
    </x-flux.single-select>
                             <div class="flex-1">
        <x-flux.date-picker for="demand_date" wireModel="demand_date" label="{{ __('messages.demand.create.label_demand_date') }}" :required="true"/>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="with_vehicle" required>{{ __('messages.demand.create.label_with_vehicle') }} <span class="text-red-500">*</span></flux:label>
            <div class="flex gap-6">
            <div class="flex items-center cursor-pointer">
                        <input data-testid="with_vehicle" type="radio" value="{{ config('constants.demand.with_vehicle.key.with vehicle') }}" name="with_vehicle" required wire:model="with_vehicle" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="with_vehicle" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.demand.with_vehicle.value.with vehicle') }}
    </label>&nbsp;&nbsp;    <input data-testid="with_vehicle" type="radio" value="{{ config('constants.demand.with_vehicle.key.without vehicle') }}" name="with_vehicle" required wire:model="with_vehicle" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="with_vehicle" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.demand.with_vehicle.value.without vehicle') }}
    </label>&nbsp;&nbsp;
                </div>
            </div>
            <flux:error name="with_vehicle" data-testid="with_vehicle_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="vehicle_number" required>{{ __('messages.demand.create.label_vehicle_number') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="vehicle_number" id="vehicle_number" wire:model="vehicle_number" placeholder="Enter {{ __('messages.demand.create.label_vehicle_number') }}" required/>
            <flux:error name="vehicle_number" data-testid="vehicle_number_error"/>
        </flux:field>
    </div>
                         <div class="flex-1">
    <flux:field>
        <flux:label for="receiver_mobile_no" required>{{ __('messages.demand.create.label_receiver_mobile_no') }} <span class="text-red-500">*</span></flux:label>
        <flux:input type="number" wire:model="receiver_mobile_no" data-testid="receiver_mobile_no" required />
        <flux:error name="receiver_mobile_no" data-testid="receiver_mobile_no_error"/>
    </flux:field>
</div>
                         <div class="flex-1">
    <flux:field>
        <flux:label for="fuel_quantity" required>{{ __('messages.demand.create.label_fuel_quantity') }} <span class="text-red-500">*</span></flux:label>
        <flux:input type="number" wire:model="fuel_quantity" data-testid="fuel_quantity" required />
        <flux:error name="fuel_quantity" data-testid="fuel_quantity_error"/>
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
        <x-flux.autocomplete
            name="adds.{{$index}}.product_id"
            data-testid="adds.{{$index}}.product_id"
            labeltext="{{ __('messages.demand.create.label_products') }}"
            placeholder="{{ __('messages.demand.create.label_products') }}"
            :options="$products"
            displayOptions="10"
            wire:model="adds.{{$index}}.product_id"
           :required="true"
        />
        <flux:error name="adds.{{$index}}.product_id" data-testid="adds.{{$index}}.product_id_error" />
    </div>
                 <div class="flex-1">
    <flux:field>
        <flux:label for="quantity_{{$index}}" required>{{ __('messages.demand.create.label_quantity') }} <span class="text-red-500">*</span></flux:label>
        <flux:input type="number" wire:model="adds.{{$index}}.quantity" data-testid="adds.{{$index}}.quantity" required />
        <flux:error name="adds.{{$index}}.quantity" data-testid="adds.{{$index}}.quantity_error"/>
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

            <flux:button type="button" data-testid="cancel_button" class="cursor-pointer h-8! lg:h-9!" variant="outline" href="/demand" wire:navigate>
                {{ __('messages.cancel_button_text') }}
            </flux:button>
        </div>
    </form>
</div>
