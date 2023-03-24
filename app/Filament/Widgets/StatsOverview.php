<?php

namespace App\Filament\Widgets;

use App\Enums\Role;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Allocations', \App\Models\Allocation::count())
                ->url(route('filament.resources.allocations.index')),
            Card::make('Businesses', \App\Models\Business::count())
                ->url(route('filament.resources.businesses.index')),
            Card::make('Claims', \App\Models\Claim::count())
                ->url(route('filament.resources.claims.index')),
            Card::make('Max Prices', \App\Models\MaxPrice::count())
                ->url(route('filament.resources.max-prices.index')),
            Card::make('Participants', \App\Models\Participant::count())
                ->url(route('filament.resources.participants.index')),
            Card::make('Staffs', \App\Models\User::where('role', Role::Staff)->count())
                ->url(route('filament.resources.users.index')),
        ];
    }
}
