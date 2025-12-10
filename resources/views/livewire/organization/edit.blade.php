<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <form wire:submit="store" class="space-y-3">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl lg:border border-gray-200 dark:border-gray-700 p-2 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 lg:gap-6 mb-0">
                    <div class="flex-1">
        <flux:field>
            <flux:label for="name" required>{{ __('messages.organization.create.label_name') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="name" id="name" wire:model="name" placeholder="Enter {{ __('messages.organization.create.label_name') }}" required/>
            <flux:error name="name" data-testid="name_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="owner_name" required>{{ __('messages.organization.create.label_owner_name') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="owner_name" id="owner_name" wire:model="owner_name" placeholder="Enter {{ __('messages.organization.create.label_owner_name') }}" required/>
            <flux:error name="owner_name" data-testid="owner_name_error"/>
        </flux:field>
    </div>
                         <div class="flex-1">
    <flux:field>
        <flux:label for="contact_number" required>{{ __('messages.organization.create.label_contact_number') }} <span class="text-red-500">*</span></flux:label>
        <flux:input type="number" wire:model="contact_number" data-testid="contact_number" required />
        <flux:error name="contact_number" data-testid="contact_number_error"/>
    </flux:field>
</div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="email" required>{{ __('messages.organization.create.label_email') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="email" data-testid="email" id="email" wire:model="email" placeholder="Enter {{ __('messages.organization.create.label_email') }}" required/>
            <flux:error name="email" data-testid="email_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="address" required>{{ __('messages.organization.create.label_address') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="address" id="address" wire:model="address" placeholder="Enter {{ __('messages.organization.create.label_address') }}" required/>
            <flux:error name="address" data-testid="address_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="state" required>{{ __('messages.organization.create.label_state') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="state" id="state" wire:model="state" placeholder="Enter {{ __('messages.organization.create.label_state') }}" required/>
            <flux:error name="state" data-testid="state_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="city" required>{{ __('messages.organization.create.label_city') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="city" id="city" wire:model="city" placeholder="Enter {{ __('messages.organization.create.label_city') }}" required/>
            <flux:error name="city" data-testid="city_error"/>
        </flux:field>
    </div>
                         <div class="flex-1">
    <flux:field>
        <flux:label for="pincode" required>{{ __('messages.organization.create.label_pincode') }} <span class="text-red-500">*</span></flux:label>
        <flux:input type="number" wire:model="pincode" data-testid="pincode" required />
        <flux:error name="pincode" data-testid="pincode_error"/>
    </flux:field>
</div>
            </div>
        </div>

         

        <!-- Action Buttons -->
        <div class="flex items-center justify-top gap-3 mt-3 lg:mt-3 border-t-2 lg:border-none border-gray-100 py-4 lg:py-0">

            <flux:button type="submit" variant="primary" data-testid="submit_button" class="cursor-pointer h-8! lg:h-9!" wire:loading.attr="disabled" wire:target="store">
                {{ __('messages.update_button_text') }}
            </flux:button>

            <flux:button type="button" data-testid="cancel_button" class="cursor-pointer h-8! lg:h-9!" variant="outline" href="/organization" wire:navigate>
                {{ __('messages.cancel_button_text') }}
            </flux:button>
        </div>
    </form>
</div>
