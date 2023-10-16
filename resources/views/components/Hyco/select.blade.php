@props(['options' => [], 'value' => '', 'disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>

    @if(isset($slot))
    {{ $slot }}
    @endif

    @foreach ($options as $option_value => $option_label)
    <option value="{{ $option_value }}" {{ ($option_value==$value) ? 'selected' : '' }}>
        {{ $option_label }}
    </option>
    @endforeach

</select>
