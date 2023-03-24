<?php

namespace App\Filament\Resources\MaxPriceResource\Pages;

use App\Filament\Resources\MaxPriceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaxPrice extends EditRecord
{
    protected static string $resource = MaxPriceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
