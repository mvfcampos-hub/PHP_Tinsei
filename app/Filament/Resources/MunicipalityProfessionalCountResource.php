<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MunicipalityProfessionalCountResource\Pages;
use App\Filament\Resources\MunicipalityProfessionalCountResource\RelationManagers;
use App\Models\MunicipalityProfessionalCount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MunicipalityProfessionalCountResource extends Resource
{
    protected static ?string $model = MunicipalityProfessionalCount::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Fiscalização';

    protected static ?string $navigationLabel = 'Profissionais por Município';

    protected static ?string $modelLabel = 'registro';

    protected static ?string $pluralModelLabel = 'profissionais por município';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('municipality')
                    ->label('Município')
                    ->required(),
                Forms\Components\TextInput::make('state')
                    ->label('UF')
                    ->maxLength(2)
                    ->required()
                    ->default('MG'),
                Forms\Components\TextInput::make('nutritionists_count')
                    ->label('Nutricionistas')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('technicians_count')
                    ->label('TND (Téc. em Nutrição e Dietética)')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('legal_entities_count')
                    ->label('Pessoas Jurídicas')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('total_count')
                    ->label('Total')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\DatePicker::make('reference_date')
                    ->label('Atualizado em')
                    ->native(false)
                    ->default(now()),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('municipality')
                    ->label('Município')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->label('UF'),
                Tables\Columns\TextColumn::make('nutritionists_count')
                    ->label('Nutricionistas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('technicians_count')
                    ->label('TND')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('legal_entities_count')
                    ->label('Pessoas Jurídicas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_count')
                    ->label('Total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference_date')
                    ->label('Atualizado em')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('municipality')
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
            'index' => Pages\ListMunicipalityProfessionalCounts::route('/'),
            'create' => Pages\CreateMunicipalityProfessionalCount::route('/create'),
            'edit' => Pages\EditMunicipalityProfessionalCount::route('/{record}/edit'),
        ];
    }
}
