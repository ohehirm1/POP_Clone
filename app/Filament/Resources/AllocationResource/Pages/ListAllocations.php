<?php

namespace App\Filament\Resources\AllocationResource\Pages;

use App\Filament\Resources\AllocationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAllocations extends ListRecords
{
    protected static string $resource = AllocationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
