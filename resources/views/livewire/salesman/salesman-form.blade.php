<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Salesman') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-hyco.form-section submit="store">
                <x-slot name="title">
                    {{ __('Salesman Information') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Update your Salesman information and email address.') }}
                </x-slot>

                

                <x-slot name="form">
                    
                    
                    <div class="col-span-6 sm:col-span-4">
                        <x-hyco.label for="salesman_code" :value="__('Sales Code')" />
                        <x-input id="salesman_code" wire:model="salesman_code" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="salesman_code" />
                    </div>


                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" :value="__('Name')" class="mb-1" />
                        <x-input id="name" wire:model="name" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="name" />
                    </div>

					<div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Status')" class="mb-1" />
                        <x-hyco.select wire:model="status" :options="['0'=>'Aktif','1'=>'Not Active']" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="status" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-hyco.link href="{{ route('salesman') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </x-slot>
            </x-form-section>

        </div>
    </div>
</div>
