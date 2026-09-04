<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BackupPlanResource\Pages;
use App\Models\BackupPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BackupPlanResource extends Resource
{
    protected static ?string $model = BackupPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-up';

    protected static ?string $navigationGroup = 'Produtos & Serviços';

    protected static ?string $navigationLabel = 'Planos DataBackup+';

    protected static ?string $modelLabel = 'plano de backup';

    protected static ?string $pluralModelLabel = 'planos de backup';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome do plano')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price_monthly')
                    ->label('Preço mensal (R$)')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),
                Forms\Components\TextInput::make('storage_gb')
                    ->label('Espaço de armazenamento (GB)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('device_limit')
                    ->label('Limite de dispositivos/fontes')
                    ->numeric()
                    ->helperText('Deixe em branco para ilimitado'),
                Forms\Components\TextInput::make('retention_days')
                    ->label('Retenção (dias)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Descrição curta')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Forms\Components\Toggle::make('is_popular')
                    ->label('Plano mais contratado (destaque)'),
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
                    ->label('Plano')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price_monthly')
                    ->label('Preço/mês')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('storage_gb')
                    ->label('Armazenamento (GB)'),
                Tables\Columns\TextColumn::make('device_limit')
                    ->label('Dispositivos')
                    ->formatStateUsing(fn (?int $state) => $state ?? 'Ilimitado'),
                Tables\Columns\TextColumn::make('retention_days')
                    ->label('Retenção (dias)'),
                Tables\Columns\IconColumn::make('is_popular')
                    ->label('Popular')
                    ->boolean(),
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
            'index' => Pages\ListBackupPlans::route('/'),
            'create' => Pages\CreateBackupPlan::route('/create'),
            'edit' => Pages\EditBackupPlan::route('/{record}/edit'),
        ];
    }
}
