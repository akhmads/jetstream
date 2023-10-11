<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form wire:submit.prevent="store">

                <div class="mb-4">
                    <x-label for="title" :value="__('Title')" class="mb-1" />
                    <x-input id="title" wire:model="title" class="w-full" autofocus autocomplete="title" />
                    <x-input-error class="mt-2" for="title" />
                </div>

                <div class="mb-8">
                    <x-label for="content" :value="__('Content')" class="mb-1" />
                    <x-hyco.textarea id="content" wire:model="content" class="w-full h-[300px]"></x-hyco.textarea>
                    <x-input-error class="mt-2" for="content" />
                </div>

                <div class="flex justify-center gap-4">
                    <x-hyco.link href="{{ route('post') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </div>
            </form>
        </div>
    </div>
</div>
