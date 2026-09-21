<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventItemResource\Pages;
use App\Filament\Resources\EventItemResource\RelationManagers;
use App\Models\EventItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class EventItemResource extends Resource
{
    protected static ?string $model = EventItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Agenda de Eventos';

    protected static ?string $modelLabel = 'evento';

    protected static ?string $pluralModelLabel = 'eventos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('location')
                    ->label('Local'),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Início')
                    ->native(false)
                    ->required(),
                Forms\Components\DateTimePicker::make('ends_at')
                    ->label('Término')
                    ->native(false),
                Forms\Components\Textarea::make('description')
                    ->label('Descrição')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Imagem')
                    ->image()
                    ->directory('events')
                    ->imageEditor(),
                Forms\Components\TextInput::make('external_url')
                    ->label('Link externo (ex.: Sympla)')
                    ->url(),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Destaque na home'),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Local')
                    ->searchable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Início')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->label('Término')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destaque')
                    ->boolean(),
                Tables\Columns\TextColumn::make('source')
                    ->label('Origem')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'cfn_sync' ? 'Calendário CFN' : 'Manual')
                    ->color(fn (string $state) => $state === 'cfn_sync' ? 'info' : 'gray'),
            ])
            ->defaultSort('starts_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Destaque'),
                Tables\Filters\Filter::make('upcoming')
                    ->label('Somente futuros')
                    ->query(fn (Builder $query) => $query->where('starts_at', '>=', now())),
                Tables\Filters\SelectFilter::make('source')
                    ->label('Origem')
                    ->options([
                        'manual' => 'Manual',
                        'cfn_sync' => 'Calendário CFN',
                    ]),
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
            'index' => Pages\ListEventItems::route('/'),
            'create' => Pages\CreateEventItem::route('/create'),
            'edit' => Pages\EditEventItem::route('/{record}/edit'),
        ];
    }
}
