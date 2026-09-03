<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuccessStoryResource\Pages;
use App\Models\SuccessStory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SuccessStoryResource extends Resource
{
    protected static ?string $model = SuccessStory::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Casos de Sucesso';

    protected static ?string $modelLabel = 'caso de sucesso';

    protected static ?string $pluralModelLabel = 'casos de sucesso';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company')
                    ->label('Empresa')
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->label('Localização')
                    ->placeholder('Belo Horizonte/MG'),
                Forms\Components\TextInput::make('client_since')
                    ->label('Cliente desde')
                    ->numeric()
                    ->minValue(1990)
                    ->maxValue(now()->year),
                Forms\Components\Textarea::make('highlight')
                    ->label('Texto de destaque')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('video_url')
                    ->label('URL do vídeo de depoimento')
                    ->url()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('video_person')
                    ->label('Nome de quem depõe'),
                Forms\Components\TextInput::make('video_role')
                    ->label('Cargo de quem depõe'),
                Forms\Components\FileUpload::make('logo')
                    ->label('Logo da empresa')
                    ->image()
                    ->directory('success-stories'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->numeric()
                    ->default(0)
                    ->required(),
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
                Tables\Columns\TextColumn::make('company')
                    ->label('Empresa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Localização'),
                Tables\Columns\TextColumn::make('client_since')
                    ->label('Cliente desde'),
                Tables\Columns\IconColumn::make('video_url')
                    ->label('Vídeo')
                    ->boolean()
                    ->getStateUsing(fn (SuccessStory $record) => filled($record->video_url)),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuccessStories::route('/'),
            'create' => Pages\CreateSuccessStory::route('/create'),
            'edit' => Pages\EditSuccessStory::route('/{record}/edit'),
        ];
    }
}
