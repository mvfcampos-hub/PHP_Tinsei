<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientPresenceResource\Pages;
use App\Models\ClientPresence;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientPresenceResource extends Resource
{
    protected static ?string $model = ClientPresence::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Presença de Clientes';

    protected static ?string $modelLabel = 'presença de clientes';

    protected static ?string $pluralModelLabel = 'presença de clientes';

    public static function brazilStateOptions(): array
    {
        return collect(require resource_path('data/brazil-states.php'))['states']
            ->pluck('name', 'code')
            ->sortBy(fn ($name) => $name)
            ->all();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('region_type')
                    ->label('Tipo de região')
                    ->options([
                        ClientPresence::TYPE_STATE => 'Estado (Brasil)',
                        ClientPresence::TYPE_COUNTRY => 'País (fora do Brasil)',
                    ])
                    ->default(ClientPresence::TYPE_STATE)
                    ->live()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('code')
                    ->label('Estado (UF)')
                    ->options(fn () => static::brazilStateOptions())
                    ->searchable()
                    ->required()
                    ->visible(fn (Forms\Get $get) => $get('region_type') === ClientPresence::TYPE_STATE)
                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                        $name = static::brazilStateOptions()[$state] ?? null;
                        if ($name) {
                            $set('name', $name);
                        }
                    })
                    ->live(),
                Forms\Components\TextInput::make('code')
                    ->label('Código do país')
                    ->placeholder('MX, US...')
                    ->maxLength(2)
                    ->required()
                    ->visible(fn (Forms\Get $get) => $get('region_type') === ClientPresence::TYPE_COUNTRY),
                Forms\Components\TextInput::make('name')
                    ->label('Nome de exibição')
                    ->placeholder('México, Estados Unidos...')
                    ->required(),
                Forms\Components\TextInput::make('device_count')
                    ->label('Quantidade de dispositivos')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
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
                Tables\Columns\TextColumn::make('region_type')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state) => $state === ClientPresence::TYPE_STATE ? 'Estado' : 'País')
                    ->badge(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Código'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('device_count')
                    ->label('Dispositivos')
                    ->numeric()
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
                Tables\Filters\SelectFilter::make('region_type')
                    ->label('Tipo')
                    ->options([
                        ClientPresence::TYPE_STATE => 'Estado',
                        ClientPresence::TYPE_COUNTRY => 'País',
                    ]),
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
            'index' => Pages\ListClientPresences::route('/'),
            'create' => Pages\CreateClientPresence::route('/create'),
            'edit' => Pages\EditClientPresence::route('/{record}/edit'),
        ];
    }
}
