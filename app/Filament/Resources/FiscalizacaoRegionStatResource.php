<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiscalizacaoRegionStatResource\Pages;
use App\Models\FiscalizacaoRegionStat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FiscalizacaoRegionStatResource extends Resource
{
    protected static ?string $model = FiscalizacaoRegionStat::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Fiscalização em Números';

    protected static ?string $navigationLabel = 'Visitas por Região';

    protected static ?string $modelLabel = 'região';

    protected static ?string $pluralModelLabel = 'regiões';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('region')
                    ->label('Região (Sede ou Delegacia)')
                    ->placeholder('Ex.: Sede (Belo Horizonte)')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('visits_count')
                    ->label('Visitas realizadas')
                    ->numeric()
                    ->default(0)
                    ->required(),
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
                Tables\Columns\TextColumn::make('region')
                    ->label('Região')
                    ->searchable(),
                Tables\Columns\TextColumn::make('visits_count')
                    ->label('Visitas')
                    ->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiscalizacaoRegionStats::route('/'),
            'create' => Pages\CreateFiscalizacaoRegionStat::route('/create'),
            'edit' => Pages\EditFiscalizacaoRegionStat::route('/{record}/edit'),
        ];
    }
}
