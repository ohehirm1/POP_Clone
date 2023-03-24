<div class="flex flex-col">
    <label
        for="{{ $name }}">{{ $label }}
        <span
            class="text-laravel"
        >
        {{ $attributes['required'] ? '*' : '' }}
        </span>
    </label>
    <input
        class="rounded disabled:bg-gray-200 disabled:cursor-not-allowed"
        id="{{ $name }}"
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        value="{{ $value ?? old($name) }}"
        {{ $attributes }}
    >
    <p class="text-laravel">@error($name){{ $message }}@enderror</p>
</div>