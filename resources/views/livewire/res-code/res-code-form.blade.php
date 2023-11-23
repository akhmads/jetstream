<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ResCode Manager') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-hyco.form-section submit="store">
                <x-slot name="title">
                    {{ __('Resource Code Information') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Update your resource code information.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="resource" :value="__('Resource')" class="mb-1" />
                        <x-input id="resource" wire:model="resource" class="w-full bg-slate-100" readonly />
                        <x-input-error class="mt-2" for="resource" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="code" :value="__('Code')" class="mb-1" />
                        <x-input id="code" wire:model="code" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="code" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-hyco.link href="{{ route('master.res-code') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </x-slot>
            </x-form-section>

        </div>
    </div>
</div>
