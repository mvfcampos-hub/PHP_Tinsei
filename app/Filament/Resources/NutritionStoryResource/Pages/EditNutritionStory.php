<?php

namespace App\Filament\Resources\NutritionStoryResource\Pages;

use App\Filament\Resources\NutritionStoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNutritionStory extends EditRecord
{
    protected static string $resource = NutritionStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
