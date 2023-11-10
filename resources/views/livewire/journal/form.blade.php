<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Journal') }}
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
                    <x-hyco.label for="code" :value="__('Code')" />
                    <x-input id="code" wire:model="code" class="w-full bg-slate-100" readonly="" />
                    <x-input-error class="mt-2" for="code" />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-label for="date" :value="__('Date')" class="mb-1" />
                    <x-input type="date" id="date" wire:model="date" class="w-full" />
                    <x-input-error class="mt-2" for="date" />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-label for="contact_id" :value="__('Contact')" class="mb-1" />
                    <livewire:example.contact-picker id="contact_id" :value="$contact_id" />
                    <x-input-error class="mt-2" for="contact_id" />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-label for="ref_name" :value="__('Ref Module')" class="mb-1" />
                    <x-input id="ref_name" :value="$ref_name" class="w-full bg-slate-100" readonly />
                    <x-input-error class="mt-2" for="ref_name" />
                </div>
                <div class="col-span-12 md:col-span-6">
                    <x-label for="note" :value="__('Note')" class="mb-1" />
                    <x-input id="note" wire:model="note" class="w-full" />
                    <x-input-error class="mt-2" for="note" />
                </div>
                <div class="hidden md:block col-span-12 md:col-span-3">&nbsp;</div>
                <div class="col-span-12 md:col-span-3">
                    <x-label for="ref_id" :value="__('Ref ID')" class="mb-1" />
                    <x-input id="ref_id" :value="$ref_id" class="w-full bg-slate-100" readonly />
                    <x-input-error class="mt-2" for="ref_id" />
                </div>

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
                <th class="w-[30%]">Coa Code</th>
                <th>Description</th>
                <th class="w-[80px]">D/C</th>
                <th class="w-[150px]">Amount</th>
                <th class="w-[100px]">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ( $tmp as $index => $tm )
            <tr>
                <td>
                    <x-hyco.select wire:model="tmp.{{$index}}.coa_code" :options="\App\Models\Coa::select('name','code')->orderBy('code')->get()->pluck('name','code')" class="w-full"></x-hyco.select>
                </td>
                <td>
                    <x-input wire:model="tmp.{{$index}}.description" wire:loading.attr="disabled" class="w-full" />
                </td>
                <td>
                    <x-hyco.select wire:model="tmp.{{$index}}.dc" :options="['D'=>'D','C'=>'C']" placeholder="" wire:loading.attr="disabled" class="w-full"></x-hyco.select>
                </td>
                <td>
                    <x-input wire:model="tmp.{{$index}}.amount" wire:loading.attr="disabled" class="w-full text-end" />
                </td>
                <td class="text-center">
                    <x-hyco.button class="bg-red-500 hover:bg-red-400 scale-90" wire:click.prevent="removeDetail('{{$index}}')" wire:loading.attr="disabled">del</x-hyco.button>
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center py-2" colspan="7">No items</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="3" class="text-end px-2">Total Debt:</td>
                <td class=""><x-input wire:model.live="debit_total" class="w-full text-end" readonly /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" class="text-end px-2">Total Credit:</td>
                <td class=""><x-input wire:model.live="credit_total" class="w-full text-end" readonly /></td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
            </table>

            <x-slot name="actions">
                <x-hyco.link href="{{ route('finance.journal') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                <x-hyco.button wire:click.prevent="store" wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
            </x-slot>

        </x-hyco.card>
    </x-hyco.container>
</div>
