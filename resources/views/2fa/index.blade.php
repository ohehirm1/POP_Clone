<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Allocations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="p-6 flex flex-col bg-white border-b border-gray-200">
                    @if (true)
                        @unless(auther()->hasVerifiedEmail())
                            <p class="text-red-600 text-xl">
                                Please check your inbox and verify your email to access the
                                system!
                            </p>
                        @else
                            @if(auther()->two_factor_confirmed_at)
                                <div class="self-end pb-4">
                                    <form method="POST" action="{{ route('two-factor.enable') }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="flex justify-end">
                                            <x-post-button value="Disable" />
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="self-end pb-4">
                                    <form method="POST" action="{{ route('two-factor.enable') }}">
                                        @csrf
                                        <div class="flex justify-end">
                                            <x-post-button value="Enable" />
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if (session('status') == 'two-factor-authentication-confirmed')
                                <div class="mb-4 font-medium text-sm">
                                    Two factor authentication confirmed and enabled successfully.
                                    Please note down your recovery codes.
                                    <hr class="my-4">
                                    <code>{{ request()->user()->recoveryCodes()[0] }}</code>
                                    <hr class="my-4">
                                </div>
                            @endif
                            @if (session('status') == 'two-factor-authentication-enabled')
                                <div class="mb-4 font-medium text-sm">
                                    Please finish configuring two factor authentication below.
                                    Scan the QR code with your authenticator app and enter the
                                    code below.
                                    <hr class="my-4">
                                    {!! request()->user()->twoFactorQrCodeSvg() !!}
                                    <hr class="my-4">
                                    <form method="POST" action="{{ route('two-factor.confirm') }}">
                                        @csrf
                                        <div class="flex flex-col gap-4">
                                            <x-text-with-label name="code" label="Code" />
                                            <x-post-button value="Sumbit" />
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endunless
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
