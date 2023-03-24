<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Businesses') }}
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
                                <x-get-button :link="route('businesses.create')">
                                    Add Business
                                </x-get-button>
                            </div>
                            <x-table>
                                <x-slot name="head">
                                    <x-lead-cell>
                                        Verified
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        ABN Number
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Business Name
                                    </x-lead-cell>
                                    <x-lead-cell>
                                        Actions
                                    </x-lead-cell>
                                </x-slot>

                                <x-slot name="body">
                                    @foreach ($businesses as $business)
                                        <tr class="text-center">
                                            <x-cell>
                                                {{ $business->verified_at ? '✔' : '❌' }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $business->abn }}
                                            </x-cell>
                                            <x-cell>
                                                {{ $business->name }}
                                            </x-cell>
                                            <x-cell>
                                                <x-get-btn-small :link="route('businesses.show', $business->id)">
                                                    Show
                                                </x-get-btn-small>
                                            </x-cell>
                                        </tr>
                                    @endforeach
                                </x-slot>
                                <x-slot name="foot">
                                    <x-cell colspan="4">
                                        {{ $businesses->links() }}
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
