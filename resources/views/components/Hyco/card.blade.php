@props(['disabled' => false])

{{-- <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}> --}}

<div {{ $attributes->merge(['class' => 'px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md']) }}>
    {{ $slot }}
</div>
