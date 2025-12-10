<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <form wire:submit="store" class="space-y-3">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl lg:border border-gray-200 dark:border-gray-700 p-2 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 lg:gap-6 mb-0">
                    <div class="flex-1">
        <flux:field>
            <flux:label for="name" required>{{ __('messages.product.create.label_name') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="name" id="name" wire:model="name" placeholder="Enter {{ __('messages.product.create.label_name') }}" required/>
            <flux:error name="name" data-testid="name_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="chr_code" required>{{ __('messages.product.create.label_chr_code') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="chr_code" id="chr_code" wire:model="chr_code" placeholder="Enter {{ __('messages.product.create.label_chr_code') }}" required/>
            <flux:error name="chr_code" data-testid="chr_code_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="hsn_code" required>{{ __('messages.product.create.label_hsn_code') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="hsn_code" id="hsn_code" wire:model="hsn_code" placeholder="Enter {{ __('messages.product.create.label_hsn_code') }}" required/>
            <flux:error name="hsn_code" data-testid="hsn_code_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="category" required>{{ __('messages.product.create.label_category') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="category" id="category" wire:model="category" placeholder="Enter {{ __('messages.product.create.label_category') }}" required/>
            <flux:error name="category" data-testid="category_error"/>
        </flux:field>
    </div>
                              <x-flux.single-select id="unit" label="{{ __('messages.product.create.label_unit') }}" wire:model="unit" data-testid="unit" required>
        <option value=''>Select {{ __('messages.product.create.label_unit') }}</option>
<option value="{{ config('constants.product.unit.key.liter') }}" > {{ config("constants.product.unit.value.liter") }}</option><option value="{{ config('constants.product.unit.key.milliliter') }}" > {{ config("constants.product.unit.value.milliliter") }}</option><option value="{{ config('constants.product.unit.key.gallon') }}" > {{ config("constants.product.unit.value.gallon") }}</option><option value="{{ config('constants.product.unit.key.pint') }}" > {{ config("constants.product.unit.value.pint") }}</option><option value="{{ config('constants.product.unit.key.qty') }}" > {{ config("constants.product.unit.value.qty") }}</option><option value="{{ config('constants.product.unit.key.cup') }}" > {{ config("constants.product.unit.value.cup") }}</option>
    </x-flux.single-select>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="tax_rate" required>{{ __('messages.product.create.label_tax_rate') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="tax_rate" id="tax_rate" wire:model="tax_rate" placeholder="Enter {{ __('messages.product.create.label_tax_rate') }}" required/>
            <flux:error name="tax_rate" data-testid="tax_rate_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="cess" >{{ __('messages.product.create.label_cess') }} </flux:label>
            <flux:input type="text" data-testid="cess" id="cess" wire:model="cess" placeholder="Enter {{ __('messages.product.create.label_cess') }}" />
            <flux:error name="cess" data-testid="cess_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="opening_quantity" required>{{ __('messages.product.create.label_opening_quantity') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="opening_quantity" id="opening_quantity" wire:model="opening_quantity" placeholder="Enter {{ __('messages.product.create.label_opening_quantity') }}" required/>
            <flux:error name="opening_quantity" data-testid="opening_quantity_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="opening_rate" required>{{ __('messages.product.create.label_opening_rate') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="opening_rate" id="opening_rate" wire:model="opening_rate" placeholder="Enter {{ __('messages.product.create.label_opening_rate') }}" required/>
            <flux:error name="opening_rate" data-testid="opening_rate_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="purchase_rate" required>{{ __('messages.product.create.label_purchase_rate') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="purchase_rate" id="purchase_rate" wire:model="purchase_rate" placeholder="Enter {{ __('messages.product.create.label_purchase_rate') }}" required/>
            <flux:error name="purchase_rate" data-testid="purchase_rate_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="opening_value" required>{{ __('messages.product.create.label_opening_value') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="opening_value" id="opening_value" wire:model="opening_value" placeholder="Enter {{ __('messages.product.create.label_opening_value') }}" required/>
            <flux:error name="opening_value" data-testid="opening_value_error"/>
        </flux:field>
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="selling_rate" required>{{ __('messages.product.create.label_selling_rate') }} <span class="text-red-500">*</span></flux:label>
            <flux:input type="text" data-testid="selling_rate" id="selling_rate" wire:model="selling_rate" placeholder="Enter {{ __('messages.product.create.label_selling_rate') }}" required/>
            <flux:error name="selling_rate" data-testid="selling_rate_error"/>
        </flux:field>
    </div>
            </div>
        </div>

         

        <!-- Action Buttons -->
        <div class="flex items-center justify-top gap-3 mt-3 lg:mt-3 border-t-2 lg:border-none border-gray-100 py-4 lg:py-0">

            <flux:button type="submit" variant="primary" data-testid="submit_button" class="cursor-pointer h-8! lg:h-9!" wire:loading.attr="disabled" wire:target="store">
                {{ __('messages.submit_button_text') }}
            </flux:button>

            <flux:button type="button" data-testid="cancel_button" class="cursor-pointer h-8! lg:h-9!" variant="outline" href="/product" wire:navigate>
                {{ __('messages.cancel_button_text') }}
            </flux:button>
        </div>
    </form>
</div>
