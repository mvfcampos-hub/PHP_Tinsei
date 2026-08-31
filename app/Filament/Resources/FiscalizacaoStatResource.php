<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiscalizacaoStatResource\Pages;
use App\Models\FiscalizacaoStat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FiscalizacaoStatResource extends Resource
{
    protected static ?string $model = FiscalizacaoStat::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationGroup = 'Fiscalização em Números';

    protected static ?string $navigationLabel = 'Fiscalização em Números';

    protected static ?string $modelLabel = 'indicador';

    protected static ?string $pluralModelLabel = 'indicadores';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->label('Rótulo')
                    ->placeholder('Ex.: Visitas realizadas')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('value')
                    ->label('Valor')
                    ->placeholder('Ex.: 420')
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
                Tables\Columns\TextColumn::make('label')
                    ->label('Rótulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor'),
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
            'index' => Pages\ListFiscalizacaoStats::route('/'),
            'create' => Pages\CreateFiscalizacaoStat::route('/create'),
            'edit' => Pages\EditFiscalizacaoStat::route('/{record}/edit'),
        ];
    }
}
