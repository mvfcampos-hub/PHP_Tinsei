<?php

namespace App\Filament\Resources\ClientPresenceResource\Pages;

use App\Filament\Resources\ClientPresenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientPresences extends ListRecords
{
    protected static string $resource = ClientPresenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
