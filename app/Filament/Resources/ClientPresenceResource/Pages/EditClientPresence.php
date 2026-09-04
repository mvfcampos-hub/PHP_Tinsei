<?php

namespace App\Filament\Resources\ClientPresenceResource\Pages;

use App\Filament\Resources\ClientPresenceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientPresence extends EditRecord
{
    protected static string $resource = ClientPresenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
