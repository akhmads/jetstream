<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Example Form') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />
    <div wire:loading class="fixed top-0">
        <x-hyco.loading />
    </div>

    <x-hyco.table>
        <x-slot name="headingLeft">
            <x-hyco.table-perpage wire:model.live="perPage" :data="[5,10,25,50,100]" :value="$perPage" />
            <x-hyco.table-search wire:model.live.debounce.300ms="searchKeyword" />
        </x-slot>

        <x-slot name="headingRight">
            <x-hyco.link wire:navigate href="{{ route('example.form',0) }}" icon="plus" class="scale-90">
                Create
            </x-hyco.link>
        </x-slot>

        <x-slot name="header">
            <tr>
                <x-hyco.table-th name="code" :sort="$sortLink" wire:click="sortOrder('code')" class="cursor-pointer"></x-hyco.table-th>
                <x-hyco.table-th name="name" :sort="$sortLink" wire:click="sortOrder('name')" class="cursor-pointer"></x-hyco.table-th>
                <x-hyco.table-th name="gender" :sort="$sortLink" wire:click="sortOrder('gender')" class="cursor-pointer"></x-hyco.table-th>
                <x-hyco.table-th name="birth_date" :sort="$sortLink" wire:click="sortOrder('birth_date')" class="cursor-pointer"></x-hyco.table-th>
                <x-hyco.table-th name="created_at" :sort="$sortLink" wire:click="sortOrder('created_at')" class="cursor-pointer w-[180px]"></x-hyco.table-th>
                <th class="px-4 py-2 text-left w-[150px]">Action</th>
            </tr>
        </x-slot>

        @forelse ($examples as $example)
        <x-hyco.table-tr>
            <td class="px-4 py-3 text-gray-600">
                {{ $example->code }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $example->name }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ ucwords($example->gender) }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ ($example->birth_date)->format('d/m/Y') }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ ($example->created_at)->format('d/m/Y, H:i') }}
            </td>
            <td class="h-px w-px whitespace-nowrap px-4 py-3">
                <a href="{{ route('example.form',$example->id) }}" wire:navigate class="text-xs text-white bg-blue-600 px-3 py-1 rounded-lg">Edit</a>
                <a href="javascript:void(0)" wire:click="delete({{ $example->id }})" class="text-xs bg-red-600 text-white px-3 py-1 rounded-lg">Del</a>
            </td>
        </x-hyco.table-tr>
        @empty
        <tr>
            <td colspan="100" class="text-center py-10">No data</td>
        </tr>
        @endforelse

        <x-slot name="footer">
            {{ $examples->links() }}
        </x-slot>
    </x-hyco.table>

    <x-confirmation-modal wire:model.live="confirmDeletion">
        <x-slot name="title">
            {{ __('Delete Example') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this example?') }}
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
