<?php

namespace App\Filament\Resources\MaxPriceResource\Pages;

use App\Filament\Resources\MaxPriceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMaxPrice extends ViewRecord
{
    protected static string $resource = MaxPriceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
