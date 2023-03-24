<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Xero Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                @if(auther()->is_admin())
                @if($error)
                    <h1>Your connection to Xero failed</h1>
                    <p>{{ $error }}</p>
                    <a href="{{ route('xero.auth.authorize') }}" class="bg-laravel
                                                                        my-8
                                                                        text-white
                                                                        rounded
                                                                        p-2
                                                                        font-bold
                                                                        shadow-xl
                                                                        hover:bg-opacity-90
                                                                        active:translate-y-1
                                                                        active:shadow-none">
                        Reconnect to Xero
                    </a>
                @elseif($connected)
                    <h1>You are connected to Xero</h1>
                    <p>{{ $organisationName }} via {{ $username }}</p>

                    <hr class="my-8">

                    <a href="{{ route('xero.auth.authorize') }}" class="bg-laravel my-8
                                                                        text-white
                                                                        rounded
                                                                        p-2
                                                                        font-bold
                                                                        shadow-xl
                                                                        hover:bg-opacity-90
                                                                        active:translate-y-1
                                                                        active:shadow-none">
                        Reconnect to Xero
                    </a>

                    <hr class="my-8">
                @else
                    <h1>You are not connected to Xero</h1>
                    <hr class="my-8">
                    <a href="{{ route('xero.auth.authorize') }}" class="bg-laravel
                                                                        my-8
                                                                        text-white
                                                                        rounded
                                                                        p-2
                                                                        font-bold
                                                                        shadow-xl
                                                                        hover:bg-opacity-90
                                                                        active:translate-y-1
                                                                        active:shadow-none">
                        Connect to Xero
                    </a>
                @endif
                @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

