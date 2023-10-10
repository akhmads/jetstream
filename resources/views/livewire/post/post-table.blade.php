<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>

    <x-flash-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 text-sm">

            <div class="flex flex-row justify-between">
                <div class="flex flex-row gap-2">
                    <select wire:model.live="perPage" class="w-[75px] border border-slate-300 focus:border-blue-400 py-2 px-3 rounded-md shadow-sm">
                        @foreach([5,10,25,50,100] as $val)
                        <option value="{{ $val }}" @if($val==$perPage) selected @endif>{{ $val }}</option>
                        @endforeach
                    </select>
                    <input wire:model.live.debounce.200ms="searchKeyword" type="text" class="border border-slate-300 focus:border-blue-400 focus:outline-none py-2 px-3 rounded-md shadow-sm">
                </div>
                <div class="flex flex-row justify-end">
                    <a href="{{ route('post.form',0) }}" wire:navigate class="inline-flex items-center bg-blue-500 hover:bg-blue-400 text-white delay-50 duration-300 ease-in-out rounded-md px-4 py-2 font-medium">
                        <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                        Create
                    </a>
                </div>
            </div>

            <div class="w-full mx-auto">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                        <tr>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left w-[200px]">Created At</th>
                            <th class="px-4 py-2 text-left w-[150px]">Action</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($posts as $post)
                        <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                            <td class="px-4 py-3 text-gray-600">{{ $post->title }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ ($post->created_at)->format('d/m/Y, H:i') }}</td>
                            <td class="h-px w-px whitespace-nowrap px-4 py-3">
                                <a href="{{ route('post.form',$post->id) }}" wire:navigate class="text-xs text-white bg-blue-600 px-3 py-1 rounded-lg">Edit</a>
                                <a href="javascript:void(0)" wire:click="delete({{ $post->id }})" class="text-xs bg-red-600 text-white px-3 py-1 rounded-lg">Del</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100" class="text-center py-10">No data</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{ $posts->links() }}

        </div>
    </div>

    <div x-data>
        <div x-cloak x-show="$wire.showModal" class="w-full h-full fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50">
            <div x-cloak x-show="$wire.showModal" x-transition.opacity.duration.300ms class="w-full sm:w-[400px] mx-auto shadow-lg overflow-y-auto bg-white border border-gray-200 rounded-lg py-6 px-8">
                <div class="text-lg mb-5">Delete this item?</div>
                <div class="flex justify-center gap-5">
                    {{-- <button type="button" wire:click="closeModal" class="bg-yellow-500 py-2 px-4 text-white rounded-lg hover:bg-yellow-400">Close</button> --}}
                    <button type="button" wire:click="closeModal" class="bg-yellow-500 py-2 px-4 text-white rounded-lg hover:bg-yellow-400">No</button>
                    <button type="button" wire:click="destroy" class="bg-red-500 py-2 px-4 text-white rounded-lg hover:bg-red-400">Yes</button>
                </div>
            </div>
        </div>
    </div>

</div>
