<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <form wire:submit="store" class="space-y-3">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl lg:border border-gray-200 dark:border-gray-700 p-2 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 lg:gap-6 mb-0">
                     <x-flux.single-select id="fuel_type" label="{{ __('messages.fuel_config.create.label_fuel_type') }}" wire:model="fuel_type" data-testid="fuel_type" required>
        <option value=''>Select {{ __('messages.fuel_config.create.label_fuel_type') }}</option>
<option value="{{ config('constants.fuel_config.fuel_type.key.petrol') }}" > {{ config("constants.fuel_config.fuel_type.value.petrol") }}</option><option value="{{ config('constants.fuel_config.fuel_type.key.diesel') }}" > {{ config("constants.fuel_config.fuel_type.value.diesel") }}</option>
    </x-flux.single-select>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="price" required>{{ __('messages.fuel_config.create.label_price') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="price" id="price" wire:model="price" placeholder="Enter {{ __('messages.fuel_config.create.label_price') }}" required/>
            <flux:error name="price" data-testid="price_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <x-flux.date-picker for="date" wireModel="date" label="{{ __('messages.fuel_config.create.label_date') }}" :required="true"/>
    </div>
            </div>
        </div>

         

        <!-- Action Buttons -->
        <div class="flex items-center justify-top gap-3 mt-3 lg:mt-3 border-t-2 lg:border-none border-gray-100 py-4 lg:py-0">

            <flux:button type="submit" variant="primary" data-testid="submit_button" class="cursor-pointer h-8! lg:h-9!" wire:loading.attr="disabled" wire:target="store">
                {{ __('messages.submit_button_text') }}
            </flux:button>

            <flux:button type="button" data-testid="cancel_button" class="cursor-pointer h-8! lg:h-9!" variant="outline" href="/fuelconfig" wire:navigate>
                {{ __('messages.cancel_button_text') }}
            </flux:button>
        </div>
    </form>
</div>
