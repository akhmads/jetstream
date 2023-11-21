<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('General Ledger') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />
    <div wire:loading class="fixed top-0">
        <x-hyco.loading />
    </div>

    <x-hyco.table>
        <x-slot name="headingLeft">
            <x-hyco.table-perpage wire:model.live="perPage" :data="[10,25,50,100]" :value="$perPage" />
            <div class="w-full lg:col-span-5 grid grid-cols-1">
                <livewire:coa.coa-picker />
            </div>
            <x-hyco.table-search wire:model.live.debounce.300ms="searchKeyword" />
        </x-slot>

        {{-- <x-slot name="headingRight">
            <x-hyco.link wire:navigate href="{{ route('finance.gl.form',0) }}" icon="plus" class="scale-90">
                Create
            </x-hyco.link>
        </x-slot> --}}

        <x-slot name="header">
            <tr>
                <x-hyco.table-th name="code"></x-hyco.table-th>
                <x-hyco.table-th name="date"></x-hyco.table-th>
                <x-hyco.table-th name="note"></x-hyco.table-th>
                <x-hyco.table-th name="coa_code"></x-hyco.table-th>
                <x-hyco.table-th name="coa_name"></x-hyco.table-th>
                <x-hyco.table-th name="debit"></x-hyco.table-th>
                <x-hyco.table-th name="credit"></x-hyco.table-th>
                <x-hyco.table-th name="balance"></x-hyco.table-th>
                {{-- <x-hyco.table-th name="created_at" :sort="$sortLink" wire:click="sortOrder('created_at')" class="cursor-pointer w-[180px]"></x-hyco.table-th> --}}
                {{-- <th class="px-4 py-2 text-left w-[150px]">
                    Action
                </th> --}}
            </tr>
        </x-slot>

        @forelse ($GL as $gl)
        @php
        if(!isset($balance)) $balance = 0;
        $balance = $balance + $gl->debit - $gl->credit;
        @endphp
        <x-hyco.table-tr>
            <td class="px-4 py-3 text-gray-600">
                {{ $gl->code }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ ($gl->date)->format('d/m/Y') }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $gl->note }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $gl->coa_code }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $gl->coa_name }}
            </td>
            <td class="px-4 py-3 text-gray-600 text-end">
                {{ number_format($gl->debit,2) }}
            </td>
            <td class="px-4 py-3 text-gray-600 text-end">
                {{ number_format($gl->credit,2) }}
            </td>
            <td class="px-4 py-3 text-gray-600 text-end">
                {{ number_format($balance,2) }}
            </td>
            {{-- <td class="px-4 py-3 text-gray-600">
                {{ ($coa->created_at)->format('d/m/Y, H:i') }}
            </td> --}}
            {{-- <td class="h-px w-px whitespace-nowrap px-4 py-3">
                <a href="{{ route('finance.gl.form',$gl->id) }}" wire:navigate class="text-xs text-white bg-blue-600 px-3 py-1 rounded-lg">Edit</a>
                <a href="javascript:void(0)" wire:click="delete({{ $gl->id }})" class="text-xs bg-red-600 text-white px-3 py-1 rounded-lg">Del</a>
            </td> --}}
        </x-hyco.table-tr>
        @empty
        <tr>
            <td colspan="100" class="text-center py-10">No data</td>
        </tr>
        @endforelse

        <x-slot name="footer">
            {{ $GL->links('vendor.livewire.custom-tailwind') }}
        </x-slot>
    </x-hyco.table>

    <x-confirmation-modal wire:model.live="confirmDeletion">
        <x-slot name="title">
            {{ __('Delete GL') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this GL?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="destroy" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

</div>
