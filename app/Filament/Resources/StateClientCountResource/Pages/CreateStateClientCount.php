<?php

namespace App\Filament\Resources\StateClientCountResource\Pages;

use App\Filament\Resources\StateClientCountResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStateClientCount extends CreateRecord
{
    protected static string $resource = StateClientCountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
