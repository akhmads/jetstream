<div>
    {{-- @dump($value)
    @dump($label) --}}
    <div wire:click="$toggle('modal')" class="w-full cursor-pointer border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        {{ $label }}
    </div>

    <x-hyco.modal wire:model.live="modal">
        <x-slot name="title">
            {{ __('Choose Contact') }}
        </x-slot>

        <x-slot name="content">
            <input type="text" wire:model.live.debounce.300ms="searchKeyword" placeholder="Search" class="w-full border border-slate-300 focus:border-blue-400 focus:outline-none py-1 px-2 mb-4 rounded-md shadow-sm">
            @forelse ( $contacts as $contact )
            @if ($contact->id == $setvalue)
            <div class="cursor-pointer bg-sky-100 hover:bg-sky-200 px-4 py-2 rounded" wire:click="pick('{{ $contact->id }}','{{ $contact->name }}')">
                {{ $contact->name }}
            </div>
            @else
            <div class="cursor-pointer hover:bg-sky-100 px-4 py-2 rounded" wire:click="pick('{{ $contact->id }}','{{ $contact->name }}')">
                {{ $contact->name }}
            </div>
            @endif

            @empty
            <div>No data found.</div>
            @endforelse

            {{ $contacts->links() }}
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
