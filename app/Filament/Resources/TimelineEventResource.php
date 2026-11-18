<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimelineEventResource\Pages;
use App\Models\TimelineEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TimelineEventResource extends Resource
{
    protected static ?string $model = TimelineEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Institucional';

    protected static ?string $navigationLabel = 'Linha do Tempo';

    protected static ?string $modelLabel = 'marco da história';

    protected static ?string $pluralModelLabel = 'linha do tempo';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('year_label')
                    ->label('Ano / período')
                    ->placeholder('2011, 2013, Hoje...')
                    ->required()
                    ->maxLength(40),
                Forms\Components\TextInput::make('title')->label('Título')->required(),
                Forms\Components\Textarea::make('description')->label('Descrição')->rows(4)->columnSpanFull(),
                Forms\Components\TextInput::make('highlight')
                    ->label('Número em destaque (opcional)')
                    ->placeholder('3.230 clientes ativos'),
                Forms\Components\FileUpload::make('image')->label('Imagem (opcional)')->image()->directory('timeline')->imageEditor(),
                Forms\Components\TextInput::make('sort_order')->label('Ordem')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->label('Exibir no site')->default(true),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('year_label')->label('Ano')->badge(),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable(),
                Tables\Columns\TextColumn::make('description')->label('Descrição')->limit(70)->toggleable(),
                Tables\Columns\ToggleColumn::make('is_active')->label('Exibir'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
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
            'index' => Pages\ListTimelineEvents::route('/'),
            'create' => Pages\CreateTimelineEvent::route('/create'),
            'edit' => Pages\EditTimelineEvent::route('/{record}/edit'),
        ];
    }
}
