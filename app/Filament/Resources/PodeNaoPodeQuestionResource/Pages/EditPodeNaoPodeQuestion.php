<?php

namespace App\Filament\Resources\PodeNaoPodeQuestionResource\Pages;

use App\Filament\Resources\PodeNaoPodeQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPodeNaoPodeQuestion extends EditRecord
{
    protected static string $resource = PodeNaoPodeQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
