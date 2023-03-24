<?php

namespace App\Filament\Resources\MaxPriceResource\Pages;

use App\Filament\Resources\MaxPriceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMaxPrice extends CreateRecord
{
    protected static string $resource = MaxPriceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
