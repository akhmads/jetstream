@props([ 'data' => [], 'value' => '' ])

<select {!! $attributes->merge(['class' => 'w-[75px] border border-slate-300 focus:border-blue-400 py-2 px-3 rounded-md shadow-sm text-sm scale-90']) !!}>
    @foreach($data as $val)
    <option value="{{ $val }}" @if($val==$value) selected @endif>{{ $val }}</option>
    @endforeach
</select>
