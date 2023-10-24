<div>
    <x-hyco.form-section submit="" class="mb-8">
        <x-slot name="title">
            {{ __('Example Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update your example information.') }}
        </x-slot>

        <x-slot name="form">

            <div class="flex justify-between col-span-6 sm:col-span-6">
                <div wire:loading wire:target="add,edit">
                    <x-hyco.loading />
                </div>
            </div>

            <div class="col-span-6 sm:col-span-6">
                @forelse ($addresses as $address)
                <div class="text-sm rounded-lg cursor-pointer hover:bg-slate-100 py-3 px-4" wire:click="edit({{ $address->id }})">
                    <table class="w-full">
                    <tbody>
                    <tr>
                        <td class="w-[80px] align-top">Address</td>
                        <td class="w-[20px] align-top text-center">:</td>
                        <td>{{ $address->address }}</td>
                    </tr>
                    <tr>
                        <td class="align-top">City</td>
                        <td class="align-top text-center">:</td>
                        <td>{{ $address->city }}</td>
                    </tr>
                    <tr>
                        <td class="align-top">Province</td>
                        <td class="align-top text-center">:</td>
                        <td>{{ $address->province }}</td>
                    </tr>
                    </tbody>
                    </table>
                </div>
                @empty
                <p>No address found</p>
                @endforelse
            </div>
        </x-slot>

        <x-slot name="actions">
            <div class="scale-90">
                <x-hyco.button icon="plus" wire:click="add" wire:loading.attr="disabled">
                    {{ __('Add Address') }}
                </x-hyco.button>
            </div>
        </x-slot>
    </x-hyco.form-section>

    <x-hyco.modal wire:model.live="addressModal">
        <x-slot name="title">
            {{ __('Address') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="store">

                <div class="mb-4">
                    <x-label for="address" :value="__('Address')" class="mb-1" />
                    <x-hyco.textarea id="address" wire:model="address" class="w-full h-[100px]" autofocus></x-hyco.textarea>
                    <x-input-error class="mt-1" for="address" />
                </div>

                <div class="mb-4">
                    <x-label for="city" :value="__('City')" class="mb-1" />
                    <x-input id="city" wire:model="city" class="w-full" />
                    <x-input-error class="mt-1" for="city" />
                </div>

                <div class="mb-4">
                    <x-label for="province" :value="__('Province')" class="mb-1" />
                    <x-input id="province" wire:model="province" class="w-full" />
                    <x-input-error class="mt-1" for="province" />
                </div>

            </form>
        </x-slot>

        <x-slot name="footer">
            @if (!empty($set_id))
            <x-hyco.button wire:click="$set('confirmDeletion',true)" wire:loading.attr="disabled" icon="x-mark" class="bg-red-500 hover:bg-red-400">
                {{ __('Delete') }}
            </x-hyco.button>
            @endif

            <x-secondary-button wire:click="$toggle('addressModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-hyco.button wire:click="store" wire:loading.attr="disabled" icon="check">
                {{ __('Save') }}
            </x-hyco.button>
        </x-slot>
    </x-hyco.modal>

    <x-confirmation-modal wire:model.live="confirmDeletion">
        <x-slot name="title">
            {{ __('Delete Address') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this address?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
