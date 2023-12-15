<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Common Setting') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-hyco.form-section submit="store">
                <x-slot name="title">
                    {{ __('Common Setting') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Update your configuration') }}.
                    <div class="hidden sm:block">
                        <div class="py-4">
                            <div class="border-t border-gray-200"></div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="period" :value="__('Period')" class="mb-1" />
                        <x-input id="period" wire:model="period" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="period" />
                    </div>

                </x-slot>

                <x-slot name="actions">
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save Changes</x-hyco.button>
                </x-slot>
            </x-form-section>

        </div>
    </div>
</div>
