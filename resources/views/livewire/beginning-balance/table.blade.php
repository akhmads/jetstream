<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beginning Balance') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />
    <div wire:loading class="fixed top-0">
        <x-hyco.loading />
    </div>

    <x-hyco.table>
        <x-slot name="headingLeft">
            <x-hyco.table-perpage wire:model.live="perPage" :data="[10,25,50,100]" :value="$perPage" />
            <x-hyco.table-search wire:model.live.debounce.300ms="year" class="md:w-[100px]" />
            <x-hyco.table-search wire:model.live.debounce.300ms="searchKeyword" class="md:w-[300px]" />
        </x-slot>

        {{-- <x-slot name="headingRight">
            <x-hyco.link wire:navigate href="{{ route('finance.gl.form',0) }}" icon="plus" class="scale-90">
                Create
            </x-hyco.link>
        </x-slot> --}}

        <x-slot name="header">
            <tr>
                <x-hyco.table-th name="coa_code"></x-hyco.table-th>
                <x-hyco.table-th name="coa_name"></x-hyco.table-th>
                <x-hyco.table-th name="debit"></x-hyco.table-th>
                <x-hyco.table-th name="credit"></x-hyco.table-th>
                <th class="px-4 py-2 text-center w-[150px]">Action</th>
            </tr>
        </x-slot>

        @forelse ($COA as $coa)
        <x-hyco.table-tr>
            <td class="px-4 py-3 text-gray-600">
                {{ $coa->code }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $coa->name }}
            </td>
            <td class="px-4 py-3 text-gray-600 text-end">
                {{ number_format(App\Hyco\Acc::beginning($year,$coa->code,'D'),2) }}
            </td>
            <td class="px-4 py-3 text-gray-600 text-end">
                {{ number_format(App\Hyco\Acc::beginning($year,$coa->code,'C'),2) }}
            </td>
            <td class="h-px w-px whitespace-nowrap px-4 py-3 text-center">
                <a href="javascript:void(0)" wire:click="edit('{{ $year }}','{{ $coa->code }}','{{ $coa->name }}')" class="text-xs text-white bg-blue-600 px-3 py-1 rounded-lg">Edit</a>
            </td>
        </x-hyco.table-tr>
        @empty
        <tr>
            <td colspan="100" class="text-center py-10">No data</td>
        </tr>
        @endforelse

        <tr>
            <td colspan="2" class="px-4 py-3 text-gray-600 text-center font-bold text-base">
                {{ __('Balance') }}
            </td>
            <td class="px-4 py-3 text-gray-600 text-right font-bold text-base">
                {{ number_format(App\Hyco\Acc::beginning($year,false,'D'),2) }}
            </td>
            <td class="px-4 py-3 text-gray-600 text-right font-bold text-base">
                {{ number_format(App\Hyco\Acc::beginning($year,false,'C'),2) }}
            </td>
            <td></td>
        </tr>

        <x-slot name="footer">
            {{ $COA->links('vendor.livewire.custom-tailwind') }}
        </x-slot>
    </x-hyco.table>

    <x-hyco.modal wire:model.live="updateModal">
        <x-slot name="title">
            {{ __('Update').' '.__('Beginning Balance') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="store">

                <div class="grid grid-cols-4 gap-5">
                    <div class="mb-4">
                        <x-label for="coa_code" :value="__('COA Code')" class="mb-1" />
                        <x-input id="coa_code" wire:model="coa_code" class="w-full bg-slate-50" readonly />
                        <x-input-error for="coa_code" />
                    </div>

                    <div class="col-span-3 mb-4">
                        <x-label for="coa_name" :value="__('COA Name')" class="mb-1" />
                        <x-input id="coa_name" wire:model="coa_name" class="w-full bg-slate-50" readonly />
                        <x-input-error for="coa_name" />
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-5">
                    <div class="mb-4">
                        <x-label for="year" :value="__('Year')" class="mb-1" />
                        <x-input id="year" wire:model="year" class="w-full bg-slate-50" readonly />
                        <x-input-error for="year" />
                    </div>

                    <div class="mb-4">
                        <x-label for="dc" :value="__('D/C')" class="mb-1" />
                        <x-hyco.select wire:model="dc" :options="['D'=>'D','C'=>'C']" placeholder="" wire:loading.attr="disabled" class="w-full"></x-hyco.select>
                        <x-input-error for="dc" />
                    </div>

                    <div class="col-span-2 mb-4">
                        <x-label for="amount" :value="__('Amount')" class="mb-1" />
                        <x-input id="amount" wire:model="amount" class="w-full" autofocus />
                        <x-input-error for="amount" />
                    </div>
                </div>

            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-4 scale-90">
                <x-hyco.button wire:click="$toggle('updateModal')" wire:loading.attr="disabled" icon="arrow-left" class="bg-yellow-500 hover:bg-yellow-400">
                    {{ __('Cancel') }}
                </x-hyco.button>

                <x-hyco.button wire:click="store" wire:loading.attr="disabled" icon="check">
                    {{ __('Save') }}
                </x-hyco.button>
            </div>
        </x-slot>
    </x-hyco.modal>
</div>
