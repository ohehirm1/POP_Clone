<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class UnverifiedStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Unverified Allocations', \App\Models\Allocation::where('verified_at', null)->count())
                ->url(route('filament.resources.allocations.index')),
            Card::make('Unverified Businesses', \App\Models\Business::where('verified_at', null)->count())
                ->url(route('filament.resources.businesses.index')),
            Card::make('Unverified Participants', \App\Models\Participant::where('verified_at', null)->count())
                ->url(route('filament.resources.participants.index')),
        ];
    }
}
