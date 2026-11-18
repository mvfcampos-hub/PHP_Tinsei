<?php

namespace App\Filament\Resources\StateClientCountResource\Pages;

use App\Filament\Resources\StateClientCountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStateClientCount extends EditRecord
{
    protected static string $resource = StateClientCountResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
