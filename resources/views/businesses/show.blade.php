<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Business') }}
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
                                <form method="POST" action="{{ route('businesses.store') }}">
                                    @csrf
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                        <x-text-with-label disabled value="{{ $business->name }}" name="name" label="Business Name" />
                                        <x-text-with-label disabled value="{{ $business->abn }}" name="abn" label="ABN Number" />
                                    </div>
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                        <x-text-with-label disabled value="{{ $business->verified_at ? carbon($business->verified_at)->diffForHumans() : 'Not Verified' }}" name="verified_at" label="Verified At" />
                                        <x-text-with-label disabled value="{{ $business->createdBy->name }}" title="9 Digits" name="created_by" label="Created By" />
                                    </div>
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                        <x-text-with-label disabled value="{{ $business->created_at ? carbon($business->created_at)->diffForHumans() : 'N/A' }}" name="created_at" label="Created At" />
                                        <x-text-with-label disabled value="{{ $business->updated_at ? carbon($business->updated_at)->diffForHumans() : 'N/A' }}" name="updated_at" label="Updated At" />
                                    </div>
                                    {{-- <div class="flex justify-end">
                                        <x-post-button value="Add" />
                                    </div> --}}
                                </form>
                            </div>
                            <hr class="my-8">
                            <h3 class="font-bold text-xl">Related Allocations</h3>
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
                                    @forelse ($business->allocations as $allocation)
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
                                    @empty
                                        <tr><td colspan="9">No allocations found</td></tr>
                                    @endforelse
                                </x-slot>
                                    <x-slot name="foot">
                                        {{-- <x-cell colspan="9">
                                            {{ $allocations->links() }}
                                        </x-cell> --}}
                                    </x-slot>
                            </x-table>
                        @endunless
                    @else
                        <p class="text-red-600 text-xl">You need to be a provider to access this page!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
