<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Example Manager') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-hyco.form-section submit="store">
                <x-slot name="title">
                    {{ __('Example Information') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Update your example information.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="code" :value="__('Code')" class="mb-1" />
                        <x-input id="code" wire:model="code" class="w-full bg-slate-100" readonly="" />
                        <x-input-error class="mt-2" for="code" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" :value="__('Name')" class="mb-1" />
                        <x-input id="name" wire:model="name" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="name" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Gender')" class="mb-1" />
                        <x-hyco.select wire:model="gender" :options="\App\Models\Gender::pluck('gender','gender')" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="gender" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="birth_date" :value="__('Birth Date')" class="mb-1" />
                        <x-input type="date" id="birth_date" wire:model="birth_date" class="w-full" />
                        <x-input-error class="mt-2" for="birth_date" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="address" :value="__('Address')" class="mb-1" />
                        <x-hyco.textarea id="address" wire:model="address" class="w-full h-[100px]"></x-hyco.textarea>
                        <x-input-error class="mt-2" for="address" />
                    </div>

                    @dump($active)
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="active" :value="__('Active')" class="mb-1" />
                        <x-hyco.checkbox id="active" wire:model.live="active" value="1" :checked="$active" class="" />
                        <x-input-error class="mt-2" for="active" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-hyco.link href="{{ route('example') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </x-slot>
            </x-form-section>

        </div>
    </div>
</div>
