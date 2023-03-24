<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Participants') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="p-6 flex flex-col bg-white border-b border-gray-200">
                    @if (auther()->is_provider())
                        @unless(auther()->hasVerifiedEmail())
                            <p class="text-red-600 text-xl">
                                Please check your inbox and verify your email to access the
                                system!
                            </p>
                        @else
                            <div class="self-end pb-4">
                                <x-get-button :link="route('participants.create')">
                                    Add Participant
                                </x-get-button>
                            </div>
                            <x-table>
                                <x-slot name="head">
                                    <x-lead-cell>
                                        Verified
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        NDIS Number
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Name
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Authorizing
                                        Email
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Authorizing Role
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Actions
                                    </x-lead-cell>
                                </x-slot>

                                <x-slot name="body">
                                    @foreach ($participants as $participant)
                                        <tr class="text-center">
                                            <x-cell>
                                                {{ $participant->verified_at ? '✔' : '❌' }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $participant->ndis }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $participant->name }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $participant->email }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $participant->authRole() }}
                                            </x-cell>
                                            <x-cell>
                                                <x-get-btn-small :link="route('participants.show', $participant->id)">
                                                    Show
                                                </x-get-btn-small>
                                            </x-cell>
                                        </tr>
                                    @endforeach
                                </x-slot>
                                    <x-slot name="foot">
                                        <x-cell colspan="6">
                                            {{ $participants->links() }}
                                        </x-cell>
                                    </x-slot>
                            </x-table>
                        @endunless
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
