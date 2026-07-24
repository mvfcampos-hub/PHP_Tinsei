<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MagazineResource\Pages;
use App\Filament\Resources\MagazineResource\RelationManagers;
use App\Models\Magazine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MagazineResource extends Resource
{
    protected static ?string $model = Magazine::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Serviços';

    protected static ?string $navigationLabel = 'Revistas Periódicas';

    protected static ?string $modelLabel = 'revista';

    protected static ?string $pluralModelLabel = 'revistas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('edition')
                    ->label('Edição')
                    ->placeholder('Ex.: Edição 12'),
                Forms\Components\TextInput::make('year')
                    ->label('Ano')
                    ->required()
                    ->numeric()
                    ->default(now()->year),
                Forms\Components\DatePicker::make('published_at')
                    ->label('Publicada em')
                    ->native(false),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Capa')
                    ->image()
                    ->directory('magazines/covers')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('pdf_file')
                    ->label('Arquivo PDF')
                    ->directory('magazines/pdf')
                    ->acceptedFileTypes(['application/pdf']),
                Forms\Components\TextInput::make('external_url')
                    ->label('Link externo (ex.: microsite da edição)')
                    ->url()
                    ->columnSpanFull(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label(''),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('edition')
                    ->label('Edição')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Ano')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicada em')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('year', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('year')
                    ->label('Ano')
                    ->options(fn () => \App\Models\Magazine::query()->distinct()->orderByDesc('year')->pluck('year', 'year')->all()),
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
            'index' => Pages\ListMagazines::route('/'),
            'create' => Pages\CreateMagazine::route('/create'),
            'edit' => Pages\EditMagazine::route('/{record}/edit'),
        ];
    }
}
