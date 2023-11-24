<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item Manager') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-hyco.form-section submit="store">
                <x-slot name="title">
                    {{ __('Item Information') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Update your item information.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="item_code" :value="__('Item Code')" class="mb-1" />
                        <x-input id="item_code" wire:model="item_code" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="item_code" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('type')" class="mb-1" />
                        <x-hyco.select wire:model="type" :options="['0'=>'Service','1'=>'Non Inventory','2'=>'Inventory']" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="type" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" :value="__('Name')" class="mb-1" />
                        <x-input id="name" wire:model="name" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="name" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="item_group" :value="__('Item Group')" class="mb-1" />
                        <x-input id="item_group" wire:model="item_group" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="item_group" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Coa Selling')" class="mb-1" />
                        @php
                        $options = App\Models\Coa::select(
                            Illuminate\Support\Facades\DB::raw("CONCAT(code,' : ',name) as code_name,code")
                        )->orderBy('code','asc')->active()->pluck('code_name','code');
                        @endphp
                        <x-hyco.select wire:model="coa_selling" :options="$options" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="coa_selling" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Coa Buying')" class="mb-1" />
                        @php
                        $options = App\Models\Coa::select(
                            Illuminate\Support\Facades\DB::raw("CONCAT(code,' : ',name) as code_name,code")
                        )->orderBy('code','asc')->active()->pluck('code_name','code');
                        @endphp
                        <x-hyco.select wire:model="coa_buying" :options="$options" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="coa_buying" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Coa Cogs')" class="mb-1" />
                        @php
                        $options = App\Models\Coa::select(
                            Illuminate\Support\Facades\DB::raw("CONCAT(code,' : ',name) as code_name,code")
                        )->orderBy('code','asc')->active()->pluck('code_name','code');
                        @endphp
                        <x-hyco.select wire:model="coa_cogs" :options="$options" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="coa_cogs" />
                    </div>
                    
                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Status')" class="mb-1" />
                        <x-hyco.select wire:model="status" :options="['0'=>'Aktif','1'=>'Not Active']" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="status" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-hyco.link href="{{ route('item') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </x-slot>
            </x-form-section>

        </div>
    </div>
</div>
