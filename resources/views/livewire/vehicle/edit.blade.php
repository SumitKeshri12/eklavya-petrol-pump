<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <form wire:submit="store" class="space-y-3">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl lg:border border-gray-200 dark:border-gray-700 p-2 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 lg:gap-6 mb-0">
                    <div class="flex-1">
        <x-flux.autocomplete
            name="user_id"
            data-testid="user_id"
            labeltext="{{ __('messages.vehicle.create.label_users') }}"
            placeholder="{{ __('messages.vehicle.create.label_users') }}"
            :options="$users"
            displayOptions="10"
            wire:model="user_id"
           :required="true"
        />
        <flux:error name="user_id" data-testid="user_id_error" />
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="vehicle_number" required>{{ __('messages.vehicle.create.label_vehicle_number') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="vehicle_number" id="vehicle_number" wire:model="vehicle_number" placeholder="Enter {{ __('messages.vehicle.create.label_vehicle_number') }}" required/>
            <flux:error name="vehicle_number" data-testid="vehicle_number_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="fuel_type" required>{{ __('messages.vehicle.create.label_fuel_type') }} <span class="text-red-500">*</span></flux:label>
            <div class="flex gap-6">
            <div class="flex items-center cursor-pointer">
                        <input data-testid="fuel_type" type="radio" value="{{ config('constants.vehicle.fuel_type.key.petrol') }}" name="fuel_type" required wire:model="fuel_type" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="fuel_type" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.vehicle.fuel_type.value.petrol') }}
    </label>&nbsp;&nbsp;    <input data-testid="fuel_type" type="radio" value="{{ config('constants.vehicle.fuel_type.key.diesel') }}" name="fuel_type" required wire:model="fuel_type" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="fuel_type" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.vehicle.fuel_type.value.diesel') }}
    </label>&nbsp;&nbsp;
                </div>
            </div>
            <flux:error name="fuel_type" data-testid="fuel_type_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="status" required>{{ __('messages.vehicle.create.label_status') }} <span class="text-red-500">*</span></flux:label>
            <div class="flex gap-6">
            <div class="flex items-center cursor-pointer">
                        <input data-testid="status" type="radio" value="{{ config('constants.vehicle.status.key.active') }}" name="status" required wire:model="status" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="status" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.vehicle.status.value.active') }}
    </label>&nbsp;&nbsp;    <input data-testid="status" type="radio" value="{{ config('constants.vehicle.status.key.inactive') }}" name="status" required wire:model="status" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="status" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.vehicle.status.value.inactive') }}
    </label>&nbsp;&nbsp;
                </div>
            </div>
            <flux:error name="status" data-testid="status_error"/>
        </flux:field>
    </div>
            </div>
        </div>

         

        <!-- Action Buttons -->
        <div class="flex items-center justify-top gap-3 mt-3 lg:mt-3 border-t-2 lg:border-none border-gray-100 py-4 lg:py-0">

            <flux:button type="submit" variant="primary" data-testid="submit_button" class="cursor-pointer h-8! lg:h-9!" wire:loading.attr="disabled" wire:target="store">
                {{ __('messages.update_button_text') }}
            </flux:button>

            <flux:button type="button" data-testid="cancel_button" class="cursor-pointer h-8! lg:h-9!" variant="outline" href="/vehicle" wire:navigate>
                {{ __('messages.cancel_button_text') }}
            </flux:button>
        </div>
    </form>
</div>
