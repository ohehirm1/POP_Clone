<datalist {{ $attributes->except('options') }}>
    @foreach ($options as $value)
        <option value="{{ $value }}">
    @endforeach
</datalist>
