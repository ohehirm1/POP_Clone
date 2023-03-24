<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing in! Before getting started, please verify 6 digit authenticator code') }}
        </div>

        <div class="mt-4 flex flex-col justify-between">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form method="POST" action="two-factor-challenge">
                @csrf
                <x-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus />
                <button type="submit" class="w-full text-center underline mt-1 text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Verify') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
