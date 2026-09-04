<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MspWorkstationTierResource\Pages;
use App\Models\MspWorkstationTier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MspWorkstationTierResource extends Resource
{
    protected static ?string $model = MspWorkstationTier::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Produtos & Serviços';

    protected static ?string $navigationLabel = 'Faixas de Preço MSP';

    protected static ?string $modelLabel = 'faixa de preço';

    protected static ?string $pluralModelLabel = 'faixas de preço';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('range')
                    ->label('Faixa de dispositivos')
                    ->helperText('Ex.: "4 a 10" ou "Acima de 30"')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->label('Preço por dispositivo (R$/mês)')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),
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
                Tables\Columns\TextColumn::make('range')
                    ->label('Faixa de dispositivos'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Preço/dispositivo/mês')
                    ->money('BRL')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMspWorkstationTiers::route('/'),
            'create' => Pages\CreateMspWorkstationTier::route('/create'),
            'edit' => Pages\EditMspWorkstationTier::route('/{record}/edit'),
        ];
    }
}
