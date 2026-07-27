<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibraryDocumentResource\Pages;
use App\Filament\Resources\LibraryDocumentResource\RelationManagers\FilesRelationManager;
use App\Models\LibraryDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LibraryDocumentResource extends Resource
{
    protected static ?string $model = LibraryDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Campanhas';

    protected static ?string $navigationLabel = 'Biblioteca Virtual';

    protected static ?string $modelLabel = 'publicação';

    protected static ?string $pluralModelLabel = 'publicações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->label('Descrição / autoria')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('published_at')
                    ->label('Publicado em')
                    ->native(false)
                    ->default(now()),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Ativo')
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
                    ->wrap(),
                Tables\Columns\TextColumn::make('files_count')
                    ->label('Arquivos')
                    ->counts('files'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicado em')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
            ])
            ->defaultSort('title')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Ativo'),
            ])
            ->actions([
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
            FilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibraryDocuments::route('/'),
            'create' => Pages\CreateLibraryDocument::route('/create'),
            'edit' => Pages\EditLibraryDocument::route('/{record}/edit'),
        ];
    }
}
