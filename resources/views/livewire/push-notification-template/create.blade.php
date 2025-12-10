<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <form wire:submit="store" class="space-y-3">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl lg:border border-gray-200 dark:border-gray-700 p-2 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 lg:gap-6 mb-0">
                    <div class="flex-1">
        <flux:field>
            <flux:label for="type" required>{{ __('messages.push_notification_template.create.label_type') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="type" id="type" wire:model="type" placeholder="Enter {{ __('messages.push_notification_template.create.label_type') }}" required/>
            <flux:error name="type" data-testid="type_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="label" required>{{ __('messages.push_notification_template.create.label_label') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="label" id="label" wire:model="label" placeholder="Enter {{ __('messages.push_notification_template.create.label_label') }}" required/>
            <flux:error name="label" data-testid="label_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="title" required>{{ __('messages.push_notification_template.create.label_title') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="title" id="title" wire:model="title" placeholder="Enter {{ __('messages.push_notification_template.create.label_title') }}" required/>
            <flux:error name="title" data-testid="title_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="body" required>{{ __('messages.push_notification_template.create.label_body') }} <span class="text-red-500">*</span></flux:label>
            <flux:textarea rows="3" wire:model="body" id="body" data-testid="body"  placeholder="Enter {{ __('messages.push_notification_template.create.label_body') }}" required/>
            <flux:error name="body" data-testid="body_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <x-flux.file-upload
            data-testid="image_image"
            model="image_image"
            label="{{ __('messages.push_notification_template.create.label_image') }}"
            note="Extensions: jpeg, png, jpg, gif | Size: Maximum 2048 KB"
            accept="image/*"
            :required="true"
            existingValue=""
        />
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="button_name" required>{{ __('messages.push_notification_template.create.label_button_name') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="button_name" id="button_name" wire:model="button_name" placeholder="Enter {{ __('messages.push_notification_template.create.label_button_name') }}" required/>
            <flux:error name="button_name" data-testid="button_name_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="button_link" required>{{ __('messages.push_notification_template.create.label_button_link') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="button_link" id="button_link" wire:model="button_link" placeholder="Enter {{ __('messages.push_notification_template.create.label_button_link') }}" required/>
            <flux:error name="button_link" data-testid="button_link_error"/>
        </flux:field>
    </div>
            </div>
        </div>

         

        <!-- Action Buttons -->
        <div class="flex items-center justify-top gap-3 mt-3 lg:mt-3 border-t-2 lg:border-none border-gray-100 py-4 lg:py-0">

            <flux:button type="submit" variant="primary" data-testid="submit_button" class="cursor-pointer h-8! lg:h-9!" wire:loading.attr="disabled" wire:target="store">
                {{ __('messages.submit_button_text') }}
            </flux:button>

            <flux:button type="button" data-testid="cancel_button" class="cursor-pointer h-8! lg:h-9!" variant="outline" href="/pushnotificationtemplate" wire:navigate>
                {{ __('messages.cancel_button_text') }}
            </flux:button>
        </div>
    </form>
</div>
