<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cash In') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />
    <div wire:loading class="fixed top-0">
        <x-hyco.loading />
    </div>

    <x-hyco.table>
        <x-slot name="headingLeft">
            <x-hyco.table-perpage wire:model.live="perPage" :data="[10,25,50,100]" :value="$perPage" />
            <x-hyco.table-search wire:model.live.debounce.300ms="searchKeyword" />
            <x-hyco.select wire:model.live="filterStatus" :options="\App\Hyco\Code::approve()" class="w-full col-span-12 lg:col-span-2"></x-hyco.select>
        </x-slot>

        <x-slot name="headingRight">
            <x-hyco.link wire:navigate href="{{ route('cash_bank.cash-in.form',0) }}" icon="plus" class="">
                Create
            </x-hyco.link>
        </x-slot>

        <x-slot name="header">
            <tr>
                <x-hyco.table-th name="code" :sort="$sortLink" wire:click="sortOrder('code')" class="cursor-pointer w-[150px]"></x-hyco.table-th>
                <x-hyco.table-th name="date" :sort="$sortLink" wire:click="sortOrder('date')" class="cursor-pointer w-[100px]"></x-hyco.table-th>
                <x-hyco.table-th name="account" :sort="$sortLink" wire:click="sortOrder('cash_account.name')" class="cursor-pointer w-[200px]"></x-hyco.table-th>
                <th class="px-4 py-2 text-left">Contact</th>
                <th class="px-4 py-2 text-left">Note</th>
                <th class="px-4 py-2 text-left w-[100px]">Amount</th>
                <x-hyco.table-th name="status" :sort="$sortLink" wire:click="sortOrder('status')" class="cursor-pointer w-[100px]"></x-hyco.table-th>
                <th class="px-4 py-2 text-left w-[150px]">Action</th>
            </tr>
        </x-slot>

        @forelse ($data as $CashTrans)
        <x-hyco.table-tr>
            <td class="px-4 py-3 text-gray-600">
                {{ $CashTrans->code }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ ($CashTrans->created_at)->format('d/m/Y') }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $CashTrans->account->name }}
            </td>

            <td class="px-4 py-3 text-gray-600">
                {{ $CashTrans->contact->name }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $CashTrans->note }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ number_format($CashTrans->amount,2) }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                @if($CashTrans->status=='unapprove')
                <span class="bg-indigo-100 text-indigo-700 px-2 rounded">{{ $CashTrans->status }}</span>
                @elseif($CashTrans->status=='approve')
                <span class="bg-green-100 text-green-700 px-2 rounded">{{ $CashTrans->status }}</span>
                @else
                <span class="bg-red-100 text-red-700 px-2 rounded">{{ $CashTrans->status }}</span>
                @endif
            </td>
            <td class="h-px w-px whitespace-nowrap px-4 py-3">
                <a href="{{ route('cash_bank.cash-in.form',$CashTrans->id) }}" wire:navigate class="text-xs text-white bg-blue-600 px-3 py-1 rounded-lg">Edit</a>
                {{-- <a href="javascript:void(0)" wire:click="delete({{ $CashTrans->id }})" class="text-xs bg-red-600 text-white px-3 py-1 rounded-lg">Del</a> --}}
            </td>
        </x-hyco.table-tr>
        @empty
        <tr>
            <td colspan="100" class="text-center py-10">No data</td>
        </tr>
        @endforelse

        <x-slot name="footer">
            {{ $data->links() }}
        </x-slot>
    </x-hyco.table>

    <x-confirmation-modal wire:model.live="confirmDeletion">
        <x-slot name="title">
            {{ __('Delete Cash') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this cash?') }}
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
