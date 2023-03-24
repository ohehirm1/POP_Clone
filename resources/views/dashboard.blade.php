<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>You're logged in!</p>
                    @if (auth()->user()->is_provider())
                        @unless(auth()->user()->hasVerifiedEmail())
                            <p class="text-red-600 text-xl">Please check your inbox
                                and verify your email to access the
                                system!</p>
                        @else
                            <div class="grid justify-items-center grid-cols-1 xl:grid-cols-3">
                                {{-- Participants --}}
                                <div class="py-10">  
                                    <div class="max-w-lg bg-orange-100 rounded overflow-hidden shadow-lg">
                                        <div class="px-6 py-4">
                                            <div class="font-bold text-xl mb-2">Recent {{ $participants->count() }} Participants</div>
                                            <p class="text-gray-700 text-base">
                                                @forelse($participants as $participant)
                                                    <a href="{{ route('participants.show', $participant) }}" class="text-orange-500 hover:text-orange-700">{{ $participant->name }}</a>
                                                    <br>
                                                @empty
                                                    <p class="text-gray-700 text-base">No Participants</p>
                                                @endforelse
                                            </p>
                                        </div>
                                        <div class="px-6 pt-4 pb-2">
                                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                                <a href="{{ route('participants.index') }}">
                                                    View All 👁
                                                </a>
                                            </span>
                                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                                <a href="{{ route('participants.create') }}">
                                                    Add New ➕
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                {{-- Businesses --}}
                                <div class="py-10">  
                                    <div class="max-w-lg bg-orange-100 rounded overflow-hidden shadow-lg">
                                        <div class="px-6 py-4">
                                            <div class="font-bold text-xl mb-2">Recent {{ $businesses->count() }} Businesses</div>
                                            <p class="text-gray-700 text-base">
                                                @forelse($businesses as $business)
                                                    <a href="{{ route('businesses.show', $business) }}" class="text-orange-500 hover:text-orange-700">{{ $business->name }}</a>
                                                    <br>
                                                @empty
                                                    <p class="text-gray-700 text-base">No Businesses</p>
                                                @endforelse
                                            </p>
                                        </div>
                                        <div class="px-6 pt-4 pb-2">
                                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                                <a href="{{ route('businesses.index') }}">
                                                    View All 👁
                                                </a>
                                            </span>
                                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                                <a href="{{ route('businesses.create') }}">
                                                    Add New ➕
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                {{-- Allocations --}}
                                <div class="py-10">  
                                    <div class="max-w-lg bg-orange-100 rounded overflow-hidden shadow-lg">
                                        <div class="px-6 py-4">
                                            <div class="font-bold text-xl mb-2">Recent {{ $allocations->count() }}Allocations</div>
                                            <p class="text-gray-700 text-base">
                                                @forelse($allocations as $allocation)
                                                    <a href="{{ route('allocations.show', $allocation) }}" class="text-orange-500 hover:text-orange-700">{{ "{$allocation->support_item_name()}" }}</a>
                                                    <br>
                                                @empty
                                                    <p class="text-gray-700 text-base">No Allocations</p>
                                                @endforelse
                                            </p>
                                        </div>
                                        <div class="px-6 pt-4 pb-2">
                                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                                <a href="{{ route('allocations.index') }}">
                                                    View All 👁
                                                </a>
                                            </span>
                                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                                <a href="{{ route('allocations.create') }}">
                                                    Add New ➕
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endunless
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
