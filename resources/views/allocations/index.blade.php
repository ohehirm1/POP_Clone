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
                    @if (auther()->is_provider())
                        @unless(auther()->hasVerifiedEmail())
                            <p class="text-red-600 text-xl">
                                Please check your inbox and verify your email to access the
                                system!
                            </p>
                        @else
                            <div class="self-end pb-4">
                                <x-get-button :link="route('allocations.create')">
                                    Add Allocation
                                </x-get-button>
                            </div>
                            <x-table>
                                <x-slot name="head">
                                    <x-lead-cell>
                                        Verified
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Participant Verified
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Bussiness
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Participant
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Support Item
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Price Charged
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Allocated Amount
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Start Date
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        End Date
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Actions
                                    </x-lead-cell>
                                </x-slot>

                                <x-slot name="body">
                                    @foreach ($allocations as $allocation)
                                        <tr class="text-center">
                                            <x-cell>
                                                {{ $allocation->verified_at ? '✔' : '❌' }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $allocation->participant_verified_at ? '✔' : '❌' }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $allocation->business->name }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $allocation->participant->name }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $allocation->support_item }}
                                            </x-cell>
                                            <x-cell>
                                                {{ '$' . $allocation->price_charged }}
                                            </x-cell>
                                            <x-cell>
                                                {{ '$' . $allocation->allocated_amount }}
                                            </x-cell>
                                            <x-cell>
                                                {{ carbon($allocation->start_date)->format('j/n/y') }}
                                            </x-cell>
                                            <x-cell>
                                                {{ carbon($allocation->end_date)->format('j/n/y') }}
                                            </x-cell>
                                            <x-cell>
                                                @if($allocation->verified_at && $allocation->participant_verified_at)
                                                    <x-get-btn-small :link="route('claims.create', ['id' => $allocation->id])">
                                                        Claim
                                                    </x-get-btn-small>
                                                @else
                                                    <x-get-btn-sm-dead>
                                                        Claim
                                                    </x-get-btn-sm-dead>
                                                @endif
                                                <x-get-btn-small :link="route('allocations.show', $allocation->id)">
                                                    Show
                                                </x-get-btn-small>
                                            </x-cell>
                                        </tr>
                                    @endforeach
                                </x-slot>
                                    <x-slot name="foot">
                                        <x-cell colspan="10">
                                            {{ $allocations->links() }}
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
