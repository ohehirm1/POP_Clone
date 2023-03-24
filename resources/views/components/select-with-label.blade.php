<div class="flex flex-col">
    <label
        for="{{ $name }}">{{ $label }}
        <span
            class="text-laravel"
        >
        {{ $required ? '*' : '' }}
        </span>
    </label>
    <select
        class="rounded"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name) }}"
        {{ $attributes->except('options') }}
    >
        <option value="">— Select —</option>
        @foreach ($options as $value => $text)
            <option value="{{ $value }}">{{ $text }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="text-laravel">{{ $message }}</p>
    @enderror
</div>
