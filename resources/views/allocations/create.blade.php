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
                            <form x-data="{max: 0, max_prices: @js($max_prices)}" method="POST" action="{{ route('allocations.store') }}">
                                @csrf
                                <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                    <x-select-with-label required="required" name="business_id" label="Business (NDIS)" :options="$businesses" />
                                    <x-text-with-label title="9 digits NDIS number" pattern="[0-9]{9}" required name="participant_id" label="NDIS Number" />
                                </div>
                                <div
                                    x-data="{support: @js($support), si: '', scc: '', sc: '',}"
                                    class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-3"
                                >
                                    <x-text-with-label 
                                        x-on:keyup="
                                            scc=support.hasOwnProperty(si.split('_')[0]) ? si.split('_')[0] : '';
                                            sc=(support[si.split('_')[0]]??'')
                                                .replace(/(.)([A-Z])/g, '$1 $2');
                                        "
                                        x-on:change="
                                            max=max_prices[si];
                                            $refs.pc.value=max;
                                        "
                                        pattern="[0-1]{1}[0-9]{1}_[0-9]{3}_[0-9]{4}_[0-9]_[0-9]"
                                        title="Underscore seperated support item number"
                                        x-model="si" required name="support_item" label="Support Item"
                                        list="datalist"
                                    />
                                    <x-datalist :options="$items" id="datalist"/>
                                    <x-text-with-label x-model="scc" required name="support_cat_code" label="Support Category Code" disabled />
                                    <x-text-with-label x-model="sc" required name="support_cat" label="Support Category" disabled />
                                </div>
                                <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                    <x-number-with-label required name="price_charged" x-bind:max="max" x-ref="pc" label="Price Charged" step="0.01" />
                                    <x-number-with-label required name="allocated_amount" label="Allocated Amount" step="0.01" />
                                </div>
                                <div class="mb-4 grid gap-4 grid-cols-1 md:grid-cols-2">
                                    <x-date-with-label required name="start_date" label="Start Date" />
                                    <x-date-with-label required name="end_date" label="End Date" />
                                </div>
                                <div class="flex justify-end">
                                    <x-post-button value="Add" />
                                </div>
                            </form>
                        </div>
                    @endunless
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
