<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()->label('Atender')];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if ($this->record->status === 'novo') {
            $this->record->update(['status' => 'em_atendimento']);
        }
    }
}
