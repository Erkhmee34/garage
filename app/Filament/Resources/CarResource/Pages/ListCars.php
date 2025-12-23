<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\AdResource as ResourceToDisable; // temporarily point to AdResource to avoid missing class errors
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCars extends ListRecords
{
    protected static string $resource = ResourceToDisable::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
