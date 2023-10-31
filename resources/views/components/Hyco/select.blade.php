@props(['options' => [], 'value' => '', 'placeholder' => '-- Select --', 'disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>

    <option value="">
        {{ $placeholder }}
    </option>

    @if(isset($slot))
    {{ $slot }}
    @endif

    @foreach ($options as $option_value => $option_label)
    <option value="{{ $option_value }}" {{ ($option_value==$value) ? 'selected' : '' }}>
        {{-- {{ Illuminate\Support\Str::title($option_label) }} --}}
        {{ $option_label }}
    </option>
    @endforeach

</select>
