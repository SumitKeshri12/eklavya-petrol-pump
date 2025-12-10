<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <form wire:submit="store" class="space-y-3">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl lg:border border-gray-200 dark:border-gray-700 p-2 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 lg:gap-6 mb-0">
                    <div class="flex-1">
        <x-flux.autocomplete
            name="user_id"
            data-testid="user_id"
            labeltext="{{ __('messages.sanction.create.label_users') }}"
            placeholder="{{ __('messages.sanction.create.label_users') }}"
            :options="$users"
            displayOptions="10"
            wire:model="user_id"
           :required="true"
        />
        <flux:error name="user_id" data-testid="user_id_error" />
    </div>
                             <div class="flex-1">
        <x-flux.date-picker for="month" wireModel="month" label="{{ __('messages.sanction.create.label_month') }}" :required="true"/>
    </div>
                             <div class="flex-1">
        <x-flux.date-picker for="year" wireModel="year" label="{{ __('messages.sanction.create.label_year') }}" :required="true"/>
    </div>
                              <x-flux.single-select id="fuel_type" label="{{ __('messages.sanction.create.label_fuel_type') }}" wire:model="fuel_type" data-testid="fuel_type" required>
        <option value=''>Select {{ __('messages.sanction.create.label_fuel_type') }}</option>
<option value="{{ config('constants.sanction.fuel_type.key.petrol') }}" > {{ config("constants.sanction.fuel_type.value.petrol") }}</option><option value="{{ config('constants.sanction.fuel_type.key.diesel') }}" > {{ config("constants.sanction.fuel_type.value.diesel") }}</option>
    </x-flux.single-select>
                         <div class="flex-1">
    <flux:field>
        <flux:label for="quantity" >{{ __('messages.sanction.create.label_quantity') }} </flux:label>
        <flux:input type="number" wire:model="quantity" data-testid="quantity"  />
        <flux:error name="quantity" data-testid="quantity_error"/>
    </flux:field>
</div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="remarks" >{{ __('messages.sanction.create.label_remarks') }} </flux:label>
            <flux:input type="text" data-testid="remarks" id="remarks" wire:model="remarks" placeholder="Enter {{ __('messages.sanction.create.label_remarks') }}" />
            <flux:error name="remarks" data-testid="remarks_error"/>
        </flux:field>
    </div>
            </div>
        </div>

         

        <!-- Action Buttons -->
        <div class="flex items-center justify-top gap-3 mt-3 lg:mt-3 border-t-2 lg:border-none border-gray-100 py-4 lg:py-0">

            <flux:button type="submit" variant="primary" data-testid="submit_button" class="cursor-pointer h-8! lg:h-9!" wire:loading.attr="disabled" wire:target="store">
                {{ __('messages.submit_button_text') }}
            </flux:button>

            <flux:button type="button" data-testid="cancel_button" class="cursor-pointer h-8! lg:h-9!" variant="outline" href="/sanction" wire:navigate>
                {{ __('messages.cancel_button_text') }}
            </flux:button>
        </div>
    </form>
</div>
