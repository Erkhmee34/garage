<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\AdResource as ResourceToDisable; // temporarily point to AdResource to avoid missing class errors
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCar extends CreateRecord
{
    protected static string $resource = ResourceToDisable::class;
}
