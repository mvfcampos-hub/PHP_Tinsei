<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMessages extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Últimas mensagens do site';

    public function table(Table $table): Table
    {
        return $table
            ->query(ContactMessage::query()->latest()->limit(5))
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Recebida')->since(),
                Tables\Columns\TextColumn::make('subject_type')->label('Assunto')->badge()
                    ->formatStateUsing(fn ($state) => ContactMessage::SUBJECTS[$state] ?? $state),
                Tables\Columns\TextColumn::make('name')->label('Nome'),
                Tables\Columns\TextColumn::make('company')->label('Empresa'),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()
                    ->formatStateUsing(fn ($state) => ContactMessage::STATUSES[$state] ?? $state)
                    ->color(fn ($state) => $state === 'novo' ? 'warning' : 'gray'),
            ])
            ->recordUrl(fn (ContactMessage $record) => ContactMessageResource::getUrl('view', ['record' => $record]))
            ->emptyStateHeading('Nenhuma mensagem ainda');
    }
}
