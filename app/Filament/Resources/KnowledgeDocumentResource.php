<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeDocumentResource\Pages;
use App\Filament\Resources\KnowledgeDocumentResource\RelationManagers;
use App\Jobs\ProcessKnowledgeDocument;
use App\Models\KnowledgeDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KnowledgeDocumentResource extends Resource
{
    protected static ?string $model = KnowledgeDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Base de Conhecimento (IA)';

    protected static ?string $modelLabel = 'documento de IA';

    protected static ?string $pluralModelLabel = 'documentos de IA';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título do documento')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('solution_type')
                    ->label('Tipo de solução')
                    ->options(KnowledgeDocument::SOLUTION_TYPES)
                    ->native(false)
                    ->live()
                    ->required(),
                Forms\Components\Select::make('product_id')
                    ->label('Módulo (produto)')
                    ->relationship('product', 'name', function (Builder $query, Forms\Get $get) {
                        return match ($get('solution_type')) {
                            'sistemas' => $query->systems(),
                            'cloud' => $query->category('cloud'),
                            default => $query->whereRaw('0 = 1'),
                        };
                    })
                    ->searchable()
                    ->preload()
                    ->visible(fn (Forms\Get $get) => in_array($get('solution_type'), ['sistemas', 'cloud'], true)),
                Forms\Components\Radio::make('source_type')
                    ->label('Origem do conteúdo')
                    ->options(KnowledgeDocument::SOURCE_TYPES)
                    ->default('pdf')
                    ->live()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Arquivo PDF')
                    ->disk('public')
                    ->directory('knowledge-docs')
                    ->acceptedFileTypes(['application/pdf'])
                    ->visible(fn (Forms\Get $get) => $get('source_type') === 'pdf')
                    ->required(fn (Forms\Get $get) => $get('source_type') === 'pdf')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('raw_text')
                    ->label('Texto do documento')
                    ->rows(10)
                    ->visible(fn (Forms\Get $get) => $get('source_type') === 'text')
                    ->required(fn (Forms\Get $get) => $get('source_type') === 'text')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Ativo (usado nas respostas da IA)')
                    ->default(true)
                    ->required(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('solution_type')
                    ->label('Tipo de solução')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => KnowledgeDocument::SOLUTION_TYPES[$state] ?? $state),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Módulo')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('source_type')
                    ->label('Origem')
                    ->formatStateUsing(fn (string $state) => KnowledgeDocument::SOURCE_TYPES[$state] ?? $state),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'ready' => 'success',
                        'processing', 'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => KnowledgeDocument::STATUSES[$state] ?? $state),
                Tables\Columns\TextColumn::make('chunk_count')
                    ->label('Trechos'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('solution_type')
                    ->label('Tipo de solução')
                    ->options(KnowledgeDocument::SOLUTION_TYPES),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(KnowledgeDocument::STATUSES),
            ])
            ->actions([
                Tables\Actions\Action::make('reprocess')
                    ->label('Reprocessar')
                    ->icon('heroicon-o-arrow-path')
                    ->color('gray')
                    ->action(function (KnowledgeDocument $record) {
                        ProcessKnowledgeDocument::dispatch($record->id);

                        Notification::make()
                            ->title('Reprocessamento iniciado')
                            ->body('O documento será reprocessado em segundo plano.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKnowledgeDocuments::route('/'),
            'create' => Pages\CreateKnowledgeDocument::route('/create'),
            'edit' => Pages\EditKnowledgeDocument::route('/{record}/edit'),
        ];
    }
}
