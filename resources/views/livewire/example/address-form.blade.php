<div>
    <x-hyco.form-section submit="" class="mb-8">
        <x-slot name="title">
            {{ __('Example Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update your example information.') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-6">
                <x-hyco.button wire:loading.attr="disabled" icon="plus">
                    {{ __('Add') }}
                </x-hyco.button>
            </div>

            <div class="col-span-6 sm:col-span-6">
                <table>
                <tr>
                    <td>Address</td>
                    <td>: Lorem ipsum</td>
                </tr>
                </table>
            </div>
        </x-slot>

        {{-- <x-slot name="actions">
            <x-hyco.link href="{{ route('example') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
            <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
        </x-slot> --}}
    </x-form-section>

    <x-modal wire:model.live="addressModal">
        <x-slot name="title">
            {{ __('Address') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="addressStore">

                <div class="col-span-6 sm:col-span-4">
                    <x-label for="address" :value="__('Address')" class="mb-1" />
                    <x-hyco.textarea id="address" wire:model="address" class="w-full h-[100px]" autofocus></x-hyco.textarea>
                    <x-input-error class="mt-2" for="address" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-label for="city" :value="__('City')" class="mb-1" />
                    <x-input id="city" wire:model="city" class="w-full" />
                    <x-input-error class="mt-2" for="city" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-label for="province" :value="__('Province')" class="mb-1" />
                    <x-input id="province" wire:model="province" class="w-full" />
                    <x-input-error class="mt-2" for="province" />
                </div>

            </form>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('addressModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-hyco.button wire:loading.attr="disabled" icon="check">
                {{ __('Save') }}
            </x-hyco.button>
        </x-slot>
    </x-modal>
</div>
