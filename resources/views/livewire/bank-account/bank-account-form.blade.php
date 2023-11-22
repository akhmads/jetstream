<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bank Account Manager') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-hyco.form-section submit="store">
                <x-slot name="title">
                    {{ __('Bank Account Information') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Update your bank account information.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="number" :value="__('Number')" class="mb-1" />
                        <x-input id="number" wire:model="number" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="number" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Bank')" class="mb-1" />
                        <x-hyco.select wire:model="bank_id" :options="\App\Models\Bank::active()->pluck('name','id')" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="bank_id" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Coa')" class="mb-1" />
                        @php
                        $options = App\Models\Coa::select(
                            Illuminate\Support\Facades\DB::raw("CONCAT(code,' : ',name) as code_name,code")
                        )->orderBy('code','asc')->active()->pluck('code_name','code');
                        @endphp
                        <x-hyco.select wire:model="coa_code" :options="$options" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="bank_id" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Status')" class="mb-1" />
                        <x-hyco.select wire:model="status" :options="['active'=>'active','inactive'=>'inactive']" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="status" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-hyco.link href="{{ route('master.bank-account') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </x-slot>
            </x-form-section>

        </div>
    </div>
</div>
