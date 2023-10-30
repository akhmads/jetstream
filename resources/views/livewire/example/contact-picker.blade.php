<div>
    <input wire:model="label" wire:click="$toggle('modal')" class="w-full cursor-pointer border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" readonly="">

    <x-hyco.modal wire:model.live="modal">
        <x-slot name="title">
            {{ __('Choose Contact') }}
        </x-slot>

        <x-slot name="content">

            <table>
            <tr>
                <th>Name</th>
            </tr>
            @forelse ( $contacts as $contact )
            <tr>
                <td class="cursor-pointer" wire:click="pick('{{ $contact->id }}')">
                    {{ $contact->name }}
                </td>
            </tr>
            @empty
            <tr>
                <td>No data found.</td>
            </tr>
            @endforelse
            </table>

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
