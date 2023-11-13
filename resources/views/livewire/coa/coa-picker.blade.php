<div>

    <div wire:loading class="fixed top-0 z-[999]">
        <x-hyco.loading />
    </div>

    <div wire:click="$toggle('modal')" class="w-full h-full px-3 py-2 bg-white cursor-pointer border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $class ?? '' }}">
        {{ empty($label) ? __('-- Choose --') : $label }}
    </div>

    <x-hyco.modal wire:model.live="modal">
        <x-slot name="title">
            {{ __('Choose Chart Of Account') }}
        </x-slot>

        <x-slot name="content">
            <input type="text" wire:model.live.debounce.500ms="searchKeyword" autofocus placeholder="Search" class="w-full border border-slate-300 focus:border-blue-400 focus:outline-none py-1 px-2 mb-4 rounded-md shadow-sm">
            <div class="max-h-80 overflow-y-auto">
                @forelse ( $coas as $coa )
                @if ($coa->code == $value)
                <div class="flex flex-row cursor-pointer bg-sky-100 hover:bg-sky-200 px-4 py-2 rounded" wire:click="pick('{{ $coa->code }}','{{ $coa->code.' - '.$coa->name }}')">
                    <div class="w-[150px]">
                        {{ $coa->code }}
                    </div>
                    <div class="">
                        {{ $coa->name }}
                    </div>
                </div>
                @else
                <div class="flex flex-row cursor-pointer hover:bg-sky-100 px-4 py-2 rounded" wire:click="pick('{{ $coa->code }}','{{ $coa->code.' - '.$coa->name }}')">
                    <div class="w-[150px]">
                        {{ $coa->code }}
                    </div>
                    <div class="">
                        {{ $coa->name }}
                    </div>
                </div>
                @endif
                @empty
                <div>No data found.</div>
                @endforelse
            </div>
            <div class="pt-4">
                {{ $coas->links() }}
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
