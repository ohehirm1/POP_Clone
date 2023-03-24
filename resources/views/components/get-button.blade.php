<a href="{{ $link }}">
    <button
        role="button"
        class="
            bg-laravel
            text-white
            rounded
            text-xl
            p-4
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
