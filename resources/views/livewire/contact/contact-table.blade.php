<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Manager') }}
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
        </x-slot>

        <x-slot name="headingRight">
            <x-hyco.link wire:navigate href="{{ route('contact.form',0) }}" icon="plus" class="scale-90">
                Create
            </x-hyco.link>
        </x-slot>

        <x-slot name="header">
            <tr>
                <x-hyco.table-th name="contact_code" :sort="$sortLink" wire:click="sortOrder('contact_code')" class="cursor-pointer"></x-hyco.table-th>
				<x-hyco.table-th name="contact_type" :sort="$sortLink" wire:click="sortOrder('contact_type')" class="cursor-pointer"></x-hyco.table-th>
                <x-hyco.table-th name="type" :sort="$sortLink" wire:click="sortOrder('type')" class="cursor-pointer"></x-hyco.table-th>                
                <x-hyco.table-th name="name" :sort="$sortLink" wire:click="sortOrder('name')" class="cursor-pointer"></x-hyco.table-th>
				<x-hyco.table-th name="email" :sort="$sortLink" wire:click="sortOrder('email')" class="cursor-pointer"></x-hyco.table-th>
                <x-hyco.table-th name="No npwp" :sort="$sortLink" wire:click="sortOrder('nonpwp')" class="cursor-pointer"></x-hyco.table-th>
                <x-hyco.table-th name="mobile" :sort="$sortLink" wire:click="sortOrder('mobile')" class="cursor-pointer"></x-hyco.table-th>
                
				<x-hyco.table-th name="status" :sort="$sortLink" wire:click="sortOrder('status')" class="cursor-pointer"></x-hyco.table-th>
                <th class="px-4 py-2 text-left w-[150px]">
                    Action
                </th>
            </tr>
        </x-slot>

        @forelse ($contacts as $contact)
        <x-hyco.table-tr>
            <td class="px-4 py-3 text-gray-600">
                {{ $contact->contact_code }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $contact->contact_type }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $contact->type }}
            </td>
			<td class="px-4 py-3 text-gray-600">
                {{ $contact->name }}
            </td>
			 <td class="px-4 py-3 text-gray-600">
                {{ $contact->email }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $contact->nonpwp }}
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ $contact->mobile }}
            </td>
   
			@if($contact->status =='0')         
			<td class="px-4 py-3 text-green-600"><b>Active</b><a></td>         
			@else
			<td class="px-4 py-3 text-red-600"><b>Inactive</b></td>        
			@endif
			

            <td class="h-px w-px whitespace-nowrap px-4 py-3">
                <a href="{{ route('contact.form',$contact->id) }}" wire:navigate class="text-xs text-white bg-blue-600 px-3 py-1 rounded-lg">Edit</a>
                <a href="javascript:void(0)" wire:click="delete({{ $contact->id }})" class="text-xs bg-red-600 text-white px-3 py-1 rounded-lg">Del</a>
            </td>
        </x-hyco.table-tr>
        @empty
        <tr>
            <td colspan="100" class="text-center py-10">No data</td>
        </tr>
        @endforelse

        <x-slot name="footer">
            {{ $contacts->links() }}
        </x-slot>
    </x-hyco.table>

    <x-confirmation-modal wire:model.live="confirmDeletion">
        <x-slot name="title">
            {{ __('Delete Contact') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this contact?') }}
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
