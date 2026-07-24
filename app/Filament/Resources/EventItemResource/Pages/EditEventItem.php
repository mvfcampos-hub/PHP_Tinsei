<?php

namespace App\Filament\Resources\EventItemResource\Pages;

use App\Filament\Resources\EventItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventItem extends EditRecord
{
    protected static string $resource = EventItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
