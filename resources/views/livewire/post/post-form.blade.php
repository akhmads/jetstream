<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>

    <x-flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form wire:submit.prevent="store">

                <div class="mb-4">
                    <x-label for="title" :value="__('Title')" />
                    <x-input id="title" wire:model="title" class="block w-full" autofocus autocomplete="title" />
                    <x-input-error class="mt-2" for="title" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Content</label>
                    <textarea wire:model="content" class="w-full h-[400px] border border-slate-300 focus:border-blue-400 focus:outline-none py-2 px-3 rounded-md shadow-sm text-sm"></textarea>
                    @error('content')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('post') }}" wire:navigate class="bg-yellow-500 py-2 px-4 text-white rounded-lg hover:bg-yellow-400">Back</a>
                    <button type="submit" class="bg-blue-500 py-2 px-4 text-white rounded-lg hover:bg-blue-400">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
