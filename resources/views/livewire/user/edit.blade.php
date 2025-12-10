<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <form wire:submit="store" class="space-y-3">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl lg:border border-gray-200 dark:border-gray-700 p-2 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 lg:gap-6 mb-0">
                     <x-flux.single-select id="role_id" label="{{ __('messages.user.create.label_roles') }}" wire:model="role_id" data-testid="role_id" required>
        <option value='' >Select {{ __('messages.user.create.label_roles') }}</option>
   @if (!empty($roles))
       @foreach ($roles as $value) 
           <option value="{{ $value->id}}" >{{$value->name}}</option>
       @endforeach 
   @endif
    </x-flux.single-select>
                              <x-flux.single-select id="party_type" label="{{ __('messages.user.create.label_party_type') }}" wire:model="party_type" data-testid="party_type" >
        <option value=''>Select {{ __('messages.user.create.label_party_type') }}</option>
<option value="{{ config('constants.user.party_type.key.individual') }}" > {{ config("constants.user.party_type.value.individual") }}</option><option value="{{ config('constants.user.party_type.key.business') }}" > {{ config("constants.user.party_type.value.business") }}</option>
    </x-flux.single-select>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="first_name" required>{{ __('messages.user.create.label_first_name') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="first_name" id="first_name" wire:model="first_name" placeholder="Enter {{ __('messages.user.create.label_first_name') }}" required/>
            <flux:error name="first_name" data-testid="first_name_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="last_name" required>{{ __('messages.user.create.label_last_name') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="last_name" id="last_name" wire:model="last_name" placeholder="Enter {{ __('messages.user.create.label_last_name') }}" required/>
            <flux:error name="last_name" data-testid="last_name_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="party_name" >{{ __('messages.user.create.label_party_name') }} </flux:label>
            <flux:input type="text" data-testid="party_name" id="party_name" wire:model="party_name" placeholder="Enter {{ __('messages.user.create.label_party_name') }}" />
            <flux:error name="party_name" data-testid="party_name_error"/>
        </flux:field>
    </div>
                         
                             <div class="flex-1">
        <flux:field>
            <flux:label for="mobile_number" required>{{ __('messages.user.create.label_mobile_number') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="mobile_number" id="mobile_number" wire:model="mobile_number" placeholder="Enter {{ __('messages.user.create.label_mobile_number') }}" required/>
            <flux:error name="mobile_number" data-testid="mobile_number_error"/>
        </flux:field>
    </div>
                         <div class="flex-1">
    <flux:field>
        <flux:label for="aadhar_no" >{{ __('messages.user.create.label_aadhar_no') }} </flux:label>
        <flux:input type="number" wire:model="aadhar_no" data-testid="aadhar_no"  />
        <flux:error name="aadhar_no" data-testid="aadhar_no_error"/>
    </flux:field>
</div>
                         <div class="flex-1">
    <flux:field>
        <flux:label for="esic_number" >{{ __('messages.user.create.label_esic_number') }} </flux:label>
        <flux:input type="number" wire:model="esic_number" data-testid="esic_number"  />
        <flux:error name="esic_number" data-testid="esic_number_error"/>
    </flux:field>
</div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="pancard" required>{{ __('messages.user.create.label_pancard') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="pancard" id="pancard" wire:model="pancard" placeholder="Enter {{ __('messages.user.create.label_pancard') }}" required/>
            <flux:error name="pancard" data-testid="pancard_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <x-flux.file-upload
            data-testid="profile_image"
            model="profile_image"
            label="{{ __('messages.user.create.label_profile') }}"
            note="Extensions: jpeg, png, jpg, gif | Size: Maximum 2048 KB"
            accept="image/*"
            :required="false"
            existingValue="{{ $user->profile }}"
        />
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="bank_name" >{{ __('messages.user.create.label_bank_name') }} </flux:label>
            <flux:input type="text" data-testid="bank_name" id="bank_name" wire:model="bank_name" placeholder="Enter {{ __('messages.user.create.label_bank_name') }}" />
            <flux:error name="bank_name" data-testid="bank_name_error"/>
        </flux:field>
    </div>
                         <div class="flex-1">
    <flux:field>
        <flux:label for="account_number" >{{ __('messages.user.create.label_account_number') }} </flux:label>
        <flux:input type="number" wire:model="account_number" data-testid="account_number"  />
        <flux:error name="account_number" data-testid="account_number_error"/>
    </flux:field>
</div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="ifsc_code" >{{ __('messages.user.create.label_ifsc_code') }} </flux:label>
            <flux:input type="text" data-testid="ifsc_code" id="ifsc_code" wire:model="ifsc_code" placeholder="Enter {{ __('messages.user.create.label_ifsc_code') }}" />
            <flux:error name="ifsc_code" data-testid="ifsc_code_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="account_holder_name" >{{ __('messages.user.create.label_account_holder_name') }} </flux:label>
            <flux:input type="text" data-testid="account_holder_name" id="account_holder_name" wire:model="account_holder_name" placeholder="Enter {{ __('messages.user.create.label_account_holder_name') }}" />
            <flux:error name="account_holder_name" data-testid="account_holder_name_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="gstin" required>{{ __('messages.user.create.label_gstin') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="gstin" id="gstin" wire:model="gstin" placeholder="Enter {{ __('messages.user.create.label_gstin') }}" required/>
            <flux:error name="gstin" data-testid="gstin_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="tan_number" required>{{ __('messages.user.create.label_tan_number') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="tan_number" id="tan_number" wire:model="tan_number" placeholder="Enter {{ __('messages.user.create.label_tan_number') }}" required/>
            <flux:error name="tan_number" data-testid="tan_number_error"/>
        </flux:field>
    </div>
                             <div class="flex-1" x-data="{ status: @entangle('status') }">
        <flux:field>
            <flux:label for="status_switch">{{ __('messages.user.create.label_status') }}
                <span class="text-red-500">*</span></flux:label>
            <div class="flex items-center gap-3">
                <flux:switch
                    id="status_switch"
                    data-testid="status"
                    x-bind:checked="status === 'Y'"
                    x-on:change="$wire.set('status', $event.target.checked ? 'Y' : 'N')"
                    class="cursor-pointer"
                />
                <label for="status_switch"
                    class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer"
                    x-text="status === 'Y' ? 'Active' : 'Inactive'">
                </label>
            </div>
            <flux:error name="status" data-testid="status_error" />
        </flux:field>
    </div>
            </div>
        </div>

         

        <!-- Action Buttons -->
        <div class="flex items-center justify-top gap-3 mt-3 lg:mt-3 border-t-2 lg:border-none border-gray-100 py-4 lg:py-0">

            <flux:button type="submit" variant="primary" data-testid="submit_button" class="cursor-pointer h-8! lg:h-9!" wire:loading.attr="disabled" wire:target="store">
                {{ __('messages.update_button_text') }}
            </flux:button>

            <flux:button type="button" data-testid="cancel_button" class="cursor-pointer h-8! lg:h-9!" variant="outline" href="/user" wire:navigate>
                {{ __('messages.cancel_button_text') }}
            </flux:button>
        </div>
    </form>
</div>
