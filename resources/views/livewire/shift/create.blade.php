<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <form wire:submit="store" class="space-y-3">
        <!-- Basic Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl lg:border border-gray-200 dark:border-gray-700 p-2 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 lg:gap-6 mb-0">
                     <x-flux.single-select id="user_id" label="{{ __('messages.shift.create.label_users') }}" wire:model="user_id" data-testid="user_id" required>
        <option value='' >Select {{ __('messages.shift.create.label_users') }}</option>
   @if (!empty($users))
       @foreach ($users as $value) 
           <option value="{{ $value->id}}" >{{$value->first_name}}</option>
       @endforeach 
   @endif
    </x-flux.single-select>
                             <div class="flex-1">
        <x-flux.time-picker wireModel="start_time"
        for="start_time"
        label="{{ __('messages.shift.create.label_start_time') }}"
        :required="false"
        />
    </div>
                             <div class="flex-1">
        <x-flux.time-picker wireModel="end_time"
        for="end_time"
        label="{{ __('messages.shift.create.label_end_time') }}"
        :required="false"
        />
    </div>
                             <div class="flex-1">
        <flux:field>
            <flux:label for="status" required>{{ __('messages.shift.create.label_status') }} <span class="text-red-500">*</span></flux:label>
            <div class="flex gap-6">
            <div class="flex items-center cursor-pointer">
                        <input data-testid="status" type="radio" value="{{ config('constants.shift.status.key.ongoing') }}" name="status" required wire:model="status" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="status" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.shift.status.value.ongoing') }}
    </label>&nbsp;&nbsp;    <input data-testid="status" type="radio" value="{{ config('constants.shift.status.key.completed') }}" name="status" required wire:model="status" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
    <label for="status" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        {{ config('constants.shift.status.value.completed') }}
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
                {{ __('messages.submit_button_text') }}
            </flux:button>

            <flux:button type="button" data-testid="cancel_button" class="cursor-pointer h-8! lg:h-9!" variant="outline" href="/shift" wire:navigate>
                {{ __('messages.cancel_button_text') }}
            </flux:button>
        </div>
    </form>
</div>
