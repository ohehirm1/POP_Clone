<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Claim') }}
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
                                <form x-data="{qty: 1, today: dayjs().format('YYYY-MM-DD'),pr_ch: @js($allocation->price_charged), alcn: @js($allocation->allocated_balance()), advn: @js($allocation->advance_balance($x))}" method="POST" action="{{ route('claims.store') }}"
                                    x-on:submit.prevent="const valid=(alcn - (pr_ch * qty)) >= 0 && (advn - (pr_ch * qty)) >= 0; if (valid) {$event.target.submit();} else {alert('Balance not enough, please contact help desk.')}">
                                    @csrf
                                    <input type="hidden" name="allocation_id" value="{{ $allocation->id }}">
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-3">
                                        <x-text-with-label disabled value="{{ $allocation->business->name }}"
                                            name="business" label="Business" />
                                        <x-text-with-label disabled value="{{ $allocation->support_item }}"
                                            name="support_item" label="Support Item" />
                                        <x-text-with-label disabled value="{{ $allocation->participant->name }}"
                                            name="participant" label="Participant" />
                                    </div>
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                        <x-date-with-label required min="{{ $allocation->start_date }}"
                                            max="{{ $allocation->end_date }}" x-bind:value="today" name="from" label="From Date" />
                                        <x-date-with-label required min="{{ $allocation->start_date }}"
                                            max="{{ $allocation->end_date }}" x-bind:value="today" name="to" label="To Date" />
                                    </div>
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-3">
                                        <x-number-with-label x-model="pr_ch" required name="claimed_amount" :max="$allocation->price_charged" label="Claim Amount" step="0.01" />
                                        <x-number-with-label x-model="qty" required name="qty" :min="1" :max="$allocation->price_charged" label="Quantity" step="1" />
                                        <x-number-with-label x-bind:value="pr_ch * qty" name="total" label="Total" disabled />
                                    </div>
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                        <x-text-with-label disabled x-model="advn"
                                            name="advance_amount" label="Advance Balance" />
                                        <x-text-with-label disabled x-bind:value="(advn - (pr_ch * qty)).toFixed(2)"
                                            name="advance_after_claim" label="Advance Balance After Claim" />
                                    </div>
                                    <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                        <x-text-with-label disabled x-model="alcn"
                                            name="allocated_amount" label="Allocated Balance" />
                                        <x-text-with-label disabled x-bind:value="(alcn - (pr_ch * qty)).toFixed(2)"
                                            name="allocated_after_claim" label="Allocated Balance After Claim" />
                                    </div>
                                    <div class="flex justify-end">
                                        <x-post-button value="Claim" />
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
