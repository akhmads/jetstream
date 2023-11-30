<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Manager') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-hyco.form-section submit="store">
                <x-slot name="title">
                    {{ __('Contact Information') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Update your contact information and email address.') }}
                </x-slot>



                <x-slot name="form">


                    <div class="col-span-6 sm:col-span-4">
                        <x-hyco.label for="contact_code" :value="__('Customer Code')" />
                        <x-input id="contact_code" wire:model="contact_code" class="w-full bg-slate-100" readonly="" />
                        <x-input-error class="mt-2" for="contact_code" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Contact Type')" class="mb-1" />
                        <x-hyco.select wire:model="contact_type" :options="['Supplier'=>'Supplier','Customer'=>'Customer','Agent'=>'Agent']" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="contact_type" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('type')" class="mb-1" />
                        <x-hyco.select wire:model="type" :options="\App\Models\ContactType::get()->pluck('name','id')" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="type" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" :value="__('Name')" class="mb-1" />
                        <x-input id="name" wire:model="name" class="w-full" autofocus />
                        <x-input-error class="mt-2" for="name" />
                    </div>

					<div class="col-span-6 sm:col-span-4">
                        <x-label for="address" :value="__('Address')" class="mb-1" />
                        <x-input id="address" wire:model="address" class="w-full" />
                        <x-input-error class="mt-2" for="address" />
                    </div>
					<div class="col-span-6 sm:col-span-4">
                        <x-label for="pic" :value="__('Pic')" class="mb-1" />
                        <x-input id="pic" wire:model="pic" class="w-full" />
                        <x-input-error class="mt-2" for="pic" />
                    </div>
					<div class="col-span-6 sm:col-span-4">
                        <x-label for="mobile" :value="__('Mobile')" class="mb-1" />
                        <x-input id="mobile" wire:model="mobile" class="w-full" />
                        <x-input-error class="mt-2" for="mobile" />
                    </div>
					<div class="col-span-6 sm:col-span-4">
                        <x-label for="mobile2" :value="__('Mobile2')" class="mb-1" />
                        <x-input id="mobile2" wire:model="mobile2" class="w-full" />
                        <x-input-error class="mt-2" for="mobile2" />
                    </div>
					<div class="col-span-6 sm:col-span-4">
                        <x-label for="email" :value="__('Email')" class="mb-1" />
                        <x-input id="email" wire:model="email" class="w-full" />
                        <x-input-error class="mt-2" for="email" />
                    </div>
					<div class="col-span-6 sm:col-span-4">
                        <x-label for="nonpwp" :value="__('No npwp')" class="mb-1" />
                        <x-input id="nonpwp" wire:model="nonpwp" class="w-full" />
                        <x-input-error class="mt-2" for="nonpwp" />
                    </div>
					<div class="col-span-6 sm:col-span-4">
                        <x-label for="npwpnm" :value="__('Nama Npwp')" class="mb-1" />
                        <x-input id="npwpnm" wire:model="npwpnm" class="w-full" />
                        <x-input-error class="mt-2" for="npwpnm" />
                    </div>
					<div class="col-span-6 sm:col-span-4">
                        <x-label :value="__('Status')" class="mb-1" />
                        <x-hyco.select wire:model="status" :options="['0'=>'Aktif','1'=>'Not Active']" class="w-full"></x-hyco.select>
                        <x-input-error class="mt-2" for="status" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-hyco.link href="{{ route('contact') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
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
                        <x-label for="type" :value="__('Type')" class="mb-1" />
                        <x-input id="type" wire:model="type" class="w-full" />
                        <x-input-error class="mt-2" for="type" />
                    </div>

					<div class="mb-4">
                        <x-label for="address" :value="__('Address')" class="mb-1" />
                        <x-input id="address" wire:model="address" class="w-full" />
                        <x-input-error class="mt-2" for="address" />
                    </div>
					<div class="mb-4">
                        <x-label for="pic" :value="__('Pic')" class="mb-1" />
                        <x-input id="pic" wire:model="pic" class="w-full" />
                        <x-input-error class="mt-2" for="pic" />
                    </div>
					<div class="mb-4">
                        <x-label for="mobile" :value="__('Mobile')" class="mb-1" />
                        <x-input id="mobile" wire:model="mobile" class="w-full" />
                        <x-input-error class="mt-2" for="mobile" />
                    </div>
					<div class="mb-4">
                        <x-label for="mobile2" :value="__('Mobile2')" class="mb-1" />
                        <x-input id="mobile2" wire:model="mobile2" class="w-full" />
                        <x-input-error class="mt-2" for="mobile2" />
                    </div>
					<div class="mb-4">
                        <x-label for="email" :value="__('Email')" class="mb-1" />
                        <x-input id="email" wire:model="email" class="w-full" />
                        <x-input-error class="mt-2" for="email" />
                    </div>
					<div class="mb-4">
                        <x-label for="nonpwp" :value="__('No npwp')" class="mb-1" />
                        <x-input id="nonpwp" wire:model="nonpwp" class="w-full" />
                        <x-input-error class="mt-2" for="nonpwp" />
                    </div>
					<div class="mb-4">
                        <x-label for="npwpnm" :value="__('Nama Npwp')" class="mb-1" />
                        <x-input id="npwpnm" wire:model="npwpnm" class="w-full" />
                        <x-input-error class="mt-2" for="npwpnm" />
                    </div>
                   <div class="mb-4">
                        <x-label for="status" :value="__('Status')" class="mb-1" />
                        <x-input id="status" wire:model="status" class="w-full" />
                        <x-input-error class="mt-2" for="status" />
                    </div>

                <div class="flex justify-center gap-4">
                    <x-hyco.link href="{{ route('contact') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </div>
            </form> --}}

        </div>
    </div>
</div>
