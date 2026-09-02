<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CloudPlanResource\Pages;
use App\Filament\Resources\CloudPlanResource\RelationManagers;
use App\Models\CloudPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CloudPlanResource extends Resource
{
    protected static ?string $model = CloudPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud';

    protected static ?string $navigationGroup = 'Produtos & Serviços';

    protected static ?string $navigationLabel = 'Planos DataCloud';

    protected static ?string $modelLabel = 'plano de cloud';

    protected static ?string $pluralModelLabel = 'planos de cloud';

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
                Forms\Components\TextInput::make('vcpu')
                    ->label('vCPU')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('ram_gb')
                    ->label('RAM (GB)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('disk_gb')
                    ->label('Disco SSD (GB)')
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
                Tables\Columns\TextColumn::make('vcpu')
                    ->label('vCPU'),
                Tables\Columns\TextColumn::make('ram_gb')
                    ->label('RAM (GB)'),
                Tables\Columns\TextColumn::make('disk_gb')
                    ->label('Disco (GB)'),
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
            'index' => Pages\ListCloudPlans::route('/'),
            'create' => Pages\CreateCloudPlan::route('/create'),
            'edit' => Pages\EditCloudPlan::route('/{record}/edit'),
        ];
    }
}
