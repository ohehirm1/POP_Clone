<a href="{{ $link }}">
    <button
        {{ $attributes->except('link') }}
        role="button"
        class="
            bg-laravel
            my-1
            text-white
            rounded
            p-2
            font-bold
            shadow-xl
            hover:bg-opacity-90
            active:translate-y-1
            active:shadow-none
        "
    >
        {{ $slot }}
    </button>
</a>
