<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Novidades';

    protected static ?string $modelLabel = 'novidade';

    protected static ?string $pluralModelLabel = 'novidades';

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
                Forms\Components\Select::make('category')
                    ->label('Categoria')
                    ->options([
                        'Lançamento' => 'Lançamento de produto',
                        'Novidade' => 'Novidade',
                        'Institucional' => 'Institucional',
                        'Cloud' => 'Cloud',
                        'Mobile' => 'Mobile',
                        'Parcerias' => 'Parcerias',
                    ])
                    ->native(false),
                Forms\Components\Textarea::make('excerpt')
                    ->label('Resumo')
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('body')
                    ->label('Conteúdo')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Imagem de capa')
                    ->image()
                    ->directory('news')
                    ->imageEditor(),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Destaque na home'),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Publicar em')
                    ->native(false)
                    ->default(now()),
                Forms\Components\Select::make('author_id')
                    ->label('Autor')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload(),
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
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destaque')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Autor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Destaque'),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoria')
                    ->options([
                        'Lançamento' => 'Lançamento de produto',
                        'Novidade' => 'Novidade',
                        'Institucional' => 'Institucional',
                        'Cloud' => 'Cloud',
                        'Mobile' => 'Mobile',
                        'Parcerias' => 'Parcerias',
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
