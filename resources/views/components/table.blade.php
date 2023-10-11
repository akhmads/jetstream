@props(['data'])

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 text-sm">

        <div class="flex flex-row justify-between">
            <div class="flex flex-row gap-2">
                {{ $headingLeft ?? '' }}
            </div>
            <div class="flex flex-row justify-end">
                {{ $headingRight ?? '' }}
            </div>
        </div>

        <div class="w-full mx-auto">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-slate-800">

                    {{ $header }}

                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    {{ $slot }}

                    </tbody>
                </table>
            </div>
        </div>

        {{ $data->links() }}

    </div>
</div>
