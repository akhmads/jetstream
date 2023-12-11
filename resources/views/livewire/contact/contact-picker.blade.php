<div>

    <div wire:loading class="fixed top-0 z-[999]">
        <x-hyco.loading />
    </div>

    <div class="relative">
        <span wire:click="$toggle('modal')" class="select-none absolute inset-y-0 right-0 flex items-center cursor-pointer pr-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </span>
        <div wire:click="$toggle('modal')" wire:keydown.enter="$toggle('modal')" tabindex="0" class="w-full select-none px-3 pr-8 py-2 text-base truncate cursor-pointer border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-indigo-500 rounded-md shadow-sm">
            {{ empty($label) ? '-- Choose --' : $label }}
        </div>
        {{-- <p wire:click="$parent.set('name','Tesss')">Tezzz</p> --}}
    </div>

    <x-hyco.modal wire:model.live="modal">
        <x-slot name="title">
            {{ __('Choose Contact') }}
        </x-slot>

        <x-slot name="content">
            <input tabindex="0" type="text" wire:model.live.debounce.500ms="searchKeyword" autofocus placeholder="Search" class="w-full border border-slate-300 focus:border-blue-400 focus:outline-none py-1 px-2 mb-2 rounded-md shadow-sm">
            <div class="font-semibold text-gray-900 bg-sky-200 px-4 py-2 mb-2 rounded">
                <span class="text-sky-700">Selected</span> : {{ $label }}
            </div>
            <div class="max-h-80 overflow-y-auto">
                @forelse ( $contacts as $contact )
                @if ($contact->id == $value)
                <div class="flex items-center flex-row cursor-pointer hover:bg-sky-200 px-4 py-2 rounded {{ $loop->odd ? 'bg-white' : 'bg-sky-50' }}" wire:click="pick('{{ $contact->id }}','{{ $contact->name }}')">
                    {{ $contact->name }}
                </div>
                @else
                <div class="flex items-center flex-row cursor-pointer hover:bg-sky-200 px-4 py-2 rounded {{ $loop->odd ? 'bg-white' : 'bg-sky-50' }}" wire:click="pick('{{ $contact->id }}','{{ $contact->name }}')">
                    {{ $contact->name }}
                </div>
                @endif
                @empty
                <div>No data found.</div>
                @endforelse
            </div>
            <div class="pt-4">
                {{ $contacts->links() }}
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-4 scale-90">
                <x-hyco.button type="button" wire:click="$toggle('modal')" wire:loading.attr="disabled" icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">
                    {{ __('Close') }}
                </x-hyco.button>
            </div>
        </x-slot>
    </x-hyco.modal>

</div>
