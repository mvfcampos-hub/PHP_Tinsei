<?php

namespace App\Filament\Resources\PodeNaoPodeQuestionResource\Pages;

use App\Filament\Resources\PodeNaoPodeQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPodeNaoPodeQuestions extends ListRecords
{
    protected static string $resource = PodeNaoPodeQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
