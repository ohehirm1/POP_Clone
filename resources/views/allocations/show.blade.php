<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Allocation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @unless(auth()->user()->hasVerifiedEmail())
                        <p class="text-red-600 text-xl">Please check your inbox and verify your email to access the system!</p>
                    @else
                        <div>
                            <form x-data @submit.prevent="console.log(1)">
                                <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                    <x-text-with-label disabled :value="$allocation->business->name" name="business" label="Business" />
                                    <x-text-with-label disabled :value="$allocation->business->abn" name="abn" label="ABN" />
                                </div>
                                <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                    <x-text-with-label disabled :value="$allocation->participant->name" name="participant" label="Participant" />
                                    <x-text-with-label disabled :value="$allocation->participant->ndis" name="ndis" label="NDIS" />
                                </div>
                                <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                    <x-text-with-label disabled name="support_item" label="Support Item" :value="$allocation->support_item" />
                                    <x-text-with-label disabled name="support_category" label="Support Category" :value="$allocation->support_item_name()" />
                                </div>
                                <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                    <x-text-with-label disabled name="start_date" :value="$allocation->start_date" label="Start Date" />
                                    <x-text-with-label disabled name="end_date" :value="$allocation->end_date" label="End Date" />
                                </div>
                                <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                    <x-text-with-label disabled name="allocated_amount" :value="$allocation->allocated_amount" label="Allocated Amount" />
                                    <x-text-with-label disabled name="allocated_balance" :value="$allocation->allocated_balance()" label="Allocated Balance" />
                                </div>
                                <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                    <x-text-with-label disabled name="advance_amount" :value="$allocation->advance_amount" label="Advance Amount" />
                                    <x-text-with-label disabled name="advance_balance" :value="$allocation->advance_balance($x)" label="Advance Balance" />
                                </div>
                                <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-3">
                                    <x-text-with-label disabled name="price_charged" :value="$allocation->price_charged" label="Price Charged" />
                                    <x-text-with-label disabled name="verified" :value="$allocation->verified_at ?? 'Not Verified'" label="Staff Verified Time" />
                                    <x-text-with-label disabled name="participant_verified" :value="$allocation->participant_verified_at ?? 'Not Verified'" label="Participant Verified Time" />
                                </div>
                                @if($allocation->verified_at && $allocation->participant_verified_at)
                                <div class="flex justify-end mb-4">
                                    <a  class="
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
                                            text-center
                                            "
                                        href="{{ route('claims.create', ['id' => $allocation->id]) }}">
                                        Claim
                                    </a>
                                </div>
                                @endif
                            </form>
                            <hr class="my-8">
                            <h3 class="font-bold text-xl">Related Allocations</h3>
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
                                        Quantity
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Total
                                    </x-lead-cell>
                                    {{-- <x-lead-cell>
                                        Actions
                                    </x-lead-cell> --}}
                                </x-slot>

                                <x-slot name="body">
                                    @forelse ($allocation->claims as $claim)
                                        <tr class="text-center">
                                            <x-cell>
                                                {{ $claim->from }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $claim->to }}
                                            </x-cell>
                                            <x-cell>
                                                ${{ $claim->claimed_amount }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $claim->qty }}
                                            </x-cell>
                                            <x-cell>
                                                ${{ $claim->total }}
                                            </x-cell>
                                            {{-- <x-cell>
                                                <x-get-btn-small link="{{ route('claims.show', $claim) }}">
                                                    View
                                                </x-get-btn-small>
                                            </x-cell> --}}
                                        </tr>
                                    @empty
                                        <tr><td colspan="3">No claims found</td></tr>
                                    @endforelse
                                </x-slot>
                                <x-slot name="foot">
                                    {{-- Pagination? --}}
                                </x-slot>
                            </x-table>
                        </div>
                    @endunless
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
