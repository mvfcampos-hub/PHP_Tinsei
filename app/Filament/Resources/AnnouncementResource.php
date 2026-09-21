<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Administração';

    protected static ?string $navigationLabel = 'Faixa de Aviso';

    protected static ?string $modelLabel = 'aviso';

    protected static ?string $pluralModelLabel = 'avisos';

    public const TYPES = [
        'info' => 'Informativo (azul)',
        'warning' => 'Atenção (laranja)',
        'urgent' => 'Urgente (vermelho)',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('message')
                    ->label('Mensagem')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('link_label')
                    ->label('Texto do link (opcional)')
                    ->maxLength(60),
                Forms\Components\TextInput::make('link_url')
                    ->label('URL do link (opcional)')
                    ->url(),
                Forms\Components\Select::make('type')
                    ->label('Estilo')
                    ->options(self::TYPES)
                    ->native(false)
                    ->default('info')
                    ->required(),
                Forms\Components\Toggle::make('dismissible')
                    ->label('Visitante pode fechar o aviso')
                    ->default(true),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Exibir a partir de')
                    ->native(false),
                Forms\Components\DateTimePicker::make('ends_at')
                    ->label('Exibir até')
                    ->native(false),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->helperText('Quando há mais de um aviso ativo ao mesmo tempo, o de menor número aparece.')
                    ->required()
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
                Tables\Columns\TextColumn::make('message')
                    ->label('Mensagem')
                    ->limit(60)
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Estilo')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => self::TYPES[$state] ?? $state),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('De')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->label('Até')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->numeric()
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
