<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Claims') }}
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
                            <x-table>
                                <x-slot name="head">
                                    <x-lead-cell>
                                        From Date
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        To Date
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Claim Amount
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Actions
                                    </x-lead-cell>
                                </x-slot>

                                <x-slot name="body">
                                    @foreach ($claims as $claim)
                                        <tr class="text-center">
                                            <x-cell>
                                                {{ $claim->from }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $claim->to }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $claim->claimed_amount }}
                                            </x-cell>
                                            <x-cell>
                                                <x-get-btn-small :link="route('claims.show', $claim->id)">
                                                    Show
                                                </x-get-btn-small>
                                            </x-cell>
                                        </tr>
                                    @endforeach
                                </x-slot>
                                <x-slot name="foot">
                                    <x-cell colspan="3">
                                        {{ $claims->links() }}
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
