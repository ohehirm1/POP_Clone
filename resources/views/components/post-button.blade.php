<input
    type="submit"
    role="button"
    class="
        bg-laravel
        text-white
        rounded
        text-xl
        p-4
        w-40
        font-bold
        shadow-xl
        hover:bg-opacity-90
        active:translate-y-1
        active:shadow-none
    "
    {{ $attributes }}
    value="{{ $value ?? 'Submit' }}"
>
