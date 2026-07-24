<?php

namespace App\Filament\Resources\EventItemResource\Pages;

use App\Filament\Resources\EventItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEventItem extends CreateRecord
{
    protected static string $resource = EventItemResource::class;
}
