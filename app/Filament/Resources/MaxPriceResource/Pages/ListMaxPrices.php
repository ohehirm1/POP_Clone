<?php

namespace App\Filament\Resources\MaxPriceResource\Pages;

use App\Filament\Resources\MaxPriceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaxPrices extends ListRecords
{
    protected static string $resource = MaxPriceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
