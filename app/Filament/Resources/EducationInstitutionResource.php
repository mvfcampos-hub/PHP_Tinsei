<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationInstitutionResource\Pages;
use App\Models\EducationInstitution;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EducationInstitutionResource extends Resource
{
    protected static ?string $model = EducationInstitution::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Instituições de Ensino';

    protected static ?string $modelLabel = 'instituição de ensino';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome da Instituição')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('city')
                    ->label('Cidade'),
                Forms\Components\TextInput::make('phone')
                    ->label('Telefone'),
                Forms\Components\TextInput::make('address')
                    ->label('Endereço')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone'),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->limit(30),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\SelectFilter::make('city')
                    ->label('Cidade')
                    ->options(fn () => EducationInstitution::query()->whereNotNull('city')->distinct()->orderBy('city')->pluck('city', 'city')->all()),
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
            'index' => Pages\ListEducationInstitutions::route('/'),
            'create' => Pages\CreateEducationInstitution::route('/create'),
            'edit' => Pages\EditEducationInstitution::route('/{record}/edit'),
            'import' => Pages\ImportEducationInstitutions::route('/importar'),
        ];
    }
}
