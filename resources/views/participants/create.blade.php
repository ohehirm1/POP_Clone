<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Participant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(auth()->user()->is_provider())
                        @unless(auth()->user()->hasVerifiedEmail())
                            <p class="text-red-600 text-xl">Please check your inbox and verify your email to access the system!</p>
                        @else
                            <div>
                                <form method="POST" action="{{ route('participants.store') }}">
                                    @csrf
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                        <x-text-with-label required="required" name="name" label="Name" />
                                        <x-text-with-label required pattern="[0-9]{9}" title="9 Digits" name="ndis" label="NDIS Number" />
                                    </div>
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                        <x-email-with-label required name="email" label="Authorizing Email" />
                                        <x-select-with-label required="required" name="auth_role" label="Authorizing Role" :options="$options" />
                                    </div>
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                        <x-email-with-label name="email1" label="Alternate Email 1" />
                                        <x-email-with-label name="email2" label="Alternate Email 2" />
                                    </div>
                                    <div class="flex justify-end">
                                        <x-post-button value="Add" />
                                    </div>
                                </form>
                            </div>
                        @endunless
                    @else
                        <p class="text-red-600 text-xl">You need to be a provider to access this page!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
