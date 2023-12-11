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

    <x-hyco.container>
        <x-hyco.card>

            <div class="grid grid-cols-12 gap-6">

                <div class="col-span-12 md:col-span-3">
                    <x-hyco.label for="number" :value="__('Number')" />
                    <x-input id="number" wire:model="number" class="w-full bg-slate-100" readonly="" />
                    <x-input-error class="mt-2" for="number" />
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-label for="date" :value="__('Date')" class="mb-1" />
                    <x-input type="date" id="date" wire:model="date" class="w-full" />
                    <x-input-error class="mt-2" for="date" />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-label for="contact_id" :value="__('Contact')" class="mb-1" />
                    <livewire:contact.contact-picker id="contact_id" :value="$contact_id" />
                    <x-input-error class="mt-2" for="contact_id" />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-label for="ref_number" :value="__('Ref Number')" class="mb-1" />
                    <x-input wire:model="ref_number" class="w-full" />
                    <x-input-error class="mt-2" for="ref_name" />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-label for="cash_account_id" :value="__('Account')" class="mb-1" />
                    <x-hyco.select wire:model="cash_account_id" :options="\App\Models\CashAccount::active()->pluck('name','id')" class="w-full"></x-hyco.select>
                    <x-input-error class="mt-2" for="cash_account_id" />
                </div>
                <div class="col-span-12 md:col-span-6">
                    <x-label for="note" :value="__('Note')" class="mb-1" />
                    <x-input id="note" wire:model="note" class="w-full" />
                    <x-input-error class="mt-2" for="note" />
                </div>
                <div class="hidden md:block col-span-12 md:col-span-3">&nbsp;</div>

            </div>

            <div class="hidden sm:block">
                <div class="py-2">
                    <div class="border-t border-gray-200"></div>
                </div>
            </div>

            <div class="col-span-6 flex flex-row justify-end">
                <x-hyco.button wire:click.prevent="addDetail" wire:loading.attr="disabled" icon="plus" class="scale-90">
                    Add
                </x-hyco.button>
            </div>

            @error('tmp*')
            <div class="flex flex-row justify-center">
                <div class="text-sm text-red-500">{{ $message }}</div>
            </div>
            @enderror
            @error('credit_total')
            <div class="flex flex-row justify-center">
                <div class="text-sm text-red-500">{{ $message }}</div>
            </div>
            @enderror

            <table class="w-full text-sm">
            <thead>
            <tr>
                <th class="w-[20%]">Coa Code</th>
                <th>Description</th>
                {{-- <th class="w-[70px]">D/C</th> --}}
                <th class="w-[140px]">Amount</th>
                <th class="w-[90px]">Curr</th>
                <th class="w-[100px]">Rate</th>
                <th class="w-[150px]">Total</th>
                <th class="w-[60px]">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ( $tmp as $index => $tm )
            <tr>
                <td>
                    <livewire:coa.coa-picker :index="$index" :value="$tm['coa_code'] ?? ''" wire:key="coa_code_{{ $index }}" class="w-full text-base" />
                </td>
                <td>
                    <x-input wire:model="tmp.{{$index}}.note" wire:loading.attr="disabled" class="w-full" />
                </td>
                {{-- <td>
                    <x-input value="C" class="w-full text-center bg-slate-100" readonly="" />
                </td> --}}
                <td>
                    <x-input wire:model="tmp.{{$index}}.amount" wire:loading.attr="disabled" class="w-full text-end" />
                </td>
                <td>
                    <x-hyco.select wire:model="tmp.{{$index}}.currency" :options="App\Models\Currency::active()->pluck('code')" placeholder="" wire:loading.attr="disabled" class="w-full"></x-hyco.select>
                </td>
                <td>
                    <x-input wire:model="tmp.{{$index}}.rate" wire:loading.attr="disabled" class="w-full text-end" />
                </td>
                <td>
                    <x-input wire:model="tmp.{{$index}}.hamount" wire:loading.attr="disabled" class="w-full text-end bg-slate-100" readonly />
                </td>
                <td class="text-center">
                    <x-hyco.button class="bg-red-500 hover:bg-red-400 scale-90" wire:click.prevent="removeDetail('{{$index}}')" wire:loading.attr="disabled">X</x-hyco.button>
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center py-2" colspan="100">No items</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="5" class="text-end px-2">Total :</td>
                <td class=""><x-input wire:model="total" class="w-full text-end bg-slate-100" readonly /></td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
            </table>

            <x-slot name="actions">
                <x-hyco.link href="{{ route('cash_bank.cash-in') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                <x-hyco.button wire:click.prevent="store" wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
            </x-slot>

        </x-hyco.card>
    </x-hyco.container>
</div>
