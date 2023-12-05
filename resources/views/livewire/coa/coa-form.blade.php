<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Coa Manager') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-hyco.form-section submit="store">
                <x-slot name="title">
                    {{ __('Coa Information') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Update your coa information and email address.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-2">
                        <x-label for="code" :value="__('Code')" class="mb-1" />
                        <x-input id="code" wire:model="code" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="code" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" :value="__('Name')" class="mb-1" />
                        <x-input id="name" wire:model="name" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="name" />
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <x-label :value="__('Normal Balance')" class="mb-1" />
                        <x-hyco.select wire:model="normal_balance" :options="['D'=>'D','C'=>'C']" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="normal_balance" />
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <x-label :value="__('Report Type')" class="mb-1" />
                        <x-hyco.select wire:model="report_type" :options="['BS'=>'BS','PL'=>'PL']" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="report_type" />
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <x-label :value="__('Report Operator')" class="mb-1" />
                        <x-hyco.select wire:model="report_operator" :options="['PLUS'=>'PLUS','MINUS'=>'MINUS','RATE'=>'RATE']" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="report_operator" />
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <x-label :value="__('Status')" class="mb-1" />
                        <x-hyco.select wire:model="status" :options="['active'=>'active','inactive'=>'inactive']" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="status" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-hyco.link href="{{ route('coa') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </x-slot>
            </x-form-section>

            {{-- <form wire:submit.prevent="store">
                <div class="mb-4">
                    <x-label for="name" :value="__('Name')" class="mb-1" />
                    <x-input id="name" wire:model="name" class="w-full" autofocus />
                    <x-input-error class="mt-2" for="name" />
                </div>

                <div class="mb-4">
                    <x-label for="email" :value="__('Email')" class="mb-1" />
                    <x-input id="email" wire:model="email" class="w-full" />
                    <x-input-error class="mt-2" for="email" />
                </div>

                <div class="mb-8">
                    <x-label for="mobile" :value="__('Mobile')" class="mb-1" />
                    <x-input id="mobile" wire:model="mobile" class="w-full" />
                    <x-input-error class="mt-2" for="mobile" />
                </div>

                <div class="flex justify-center gap-4">
                    <x-hyco.link href="{{ route('coa') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </div>
            </form> --}}

        </div>
    </div>
</div>
