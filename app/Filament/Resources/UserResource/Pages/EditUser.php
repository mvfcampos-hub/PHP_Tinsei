<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->disabled(fn () => $this->record->id === auth()->id())
                ->tooltip(fn () => $this->record->id === auth()->id() ? 'Você não pode excluir seu próprio usuário.' : null),
        ];
    }
}
