<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StateClientCountResource\Pages;
use App\Models\StateClientCount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;

// Mapa de clientes por estado: cada linha é uma UF (ou "EX", exterior).
// A quantidade pode ser editada direto na listagem.
class StateClientCountResource extends Resource
{
    protected static ?string $model = StateClientCount::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Comercial';

    protected static ?string $navigationLabel = 'Mapa de Clientes';

    protected static ?string $modelLabel = 'estado';

    protected static ?string $pluralModelLabel = 'clientes por estado';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('code')
                    ->label('Estado')
                    ->options(StateClientCount::options())
                    ->searchable()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->live()
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('name', StateClientCount::options()[$state] ?? '')),
                Forms\Components\TextInput::make('name')->label('Nome de exibição')->required(),
                Forms\Components\TextInput::make('client_count')->label('Clientes ativos')->numeric()->minValue(0)->required(),
                Forms\Components\Toggle::make('is_active')->label('Exibir no mapa')->default(true),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('UF')->badge()->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Estado')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('region')->label('Região')
                    ->getStateUsing(fn (StateClientCount $record) => StateClientCount::regionOf($record->code) ?? 'Exterior'),
                Tables\Columns\TextInputColumn::make('client_count')
                    ->label('Clientes ativos')
                    ->type('number')
                    ->rules(['required', 'integer', 'min:0'])
                    ->sortable()
                    ->summarize(Sum::make()->label('Total')),
                Tables\Columns\ToggleColumn::make('is_active')->label('No mapa'),
            ])
            ->defaultSort('client_count', 'desc')
            ->paginated([30, 50])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStateClientCounts::route('/'),
            'create' => Pages\CreateStateClientCount::route('/create'),
            'edit' => Pages\EditStateClientCount::route('/{record}/edit'),
        ];
    }
}
