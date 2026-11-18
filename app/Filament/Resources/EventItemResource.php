<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventItemResource\Pages;
use App\Models\EventItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class EventItemResource extends Resource
{
    protected static ?string $model = EventItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Agenda';

    protected static ?string $modelLabel = 'evento';

    protected static ?string $pluralModelLabel = 'agenda';

    protected static ?int $navigationSort = 3;

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
                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options(EventItem::TYPES)
                    ->default('evento')
                    ->native(false)
                    ->required(),
                Forms\Components\DateTimePicker::make('starts_at')->label('Início')->native(false)->required(),
                Forms\Components\DateTimePicker::make('ends_at')->label('Término')->native(false)->after('starts_at'),
                Forms\Components\TextInput::make('location')
                    ->label('Local')
                    ->placeholder('Expo Center Norte, São Paulo/SP — ou On-line'),
                Forms\Components\TextInput::make('external_url')->label('Link (inscrição, site do evento, live)')->url(),
                Forms\Components\Textarea::make('description')->label('Descrição')->rows(4)->columnSpanFull(),
                Forms\Components\FileUpload::make('cover_image')->label('Imagem')->image()->directory('events')->imageEditor(),
                Forms\Components\Group::make([
                    Forms\Components\Toggle::make('is_published')->label('Publicado no site')->default(true),
                    Forms\Components\Toggle::make('is_featured')->label('Destaque na home'),
                ]),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('starts_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->limit(50),
                Tables\Columns\TextColumn::make('type')->label('Tipo')->badge()
                    ->formatStateUsing(fn (string $state) => EventItem::TYPES[$state] ?? $state),
                Tables\Columns\TextColumn::make('location')->label('Local')->limit(30)->toggleable(),
                Tables\Columns\ToggleColumn::make('is_published')->label('Publicado'),
                Tables\Columns\IconColumn::make('is_featured')->label('Destaque')->boolean(),
            ])
            ->defaultSort('starts_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')->label('Tipo')->options(EventItem::TYPES),
                Tables\Filters\Filter::make('upcoming')->label('Somente futuros')->default()
                    ->query(fn (Builder $query) => $query->where('starts_at', '>=', now()->startOfDay())),
            ])
            ->actions([
                Tables\Actions\ReplicateAction::make()->label('Duplicar')
                    ->beforeReplicaSaved(fn (EventItem $replica) => $replica->slug = $replica->slug.'-'.Str::lower(Str::random(4))),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
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
