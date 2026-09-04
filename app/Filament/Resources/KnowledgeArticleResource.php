<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeArticleResource\Pages;
use App\Filament\Resources\KnowledgeArticleResource\RelationManagers;
use App\Models\KnowledgeArticle;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class KnowledgeArticleResource extends Resource
{
    protected static ?string $model = KnowledgeArticle::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Base de Conhecimento';

    protected static ?string $modelLabel = 'artigo';

    protected static ?string $pluralModelLabel = 'artigos';

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
                Forms\Components\Select::make('solution_type')
                    ->label('Tipo de solução')
                    ->options(KnowledgeArticle::SOLUTION_TYPES)
                    ->native(false)
                    ->live()
                    ->required(),
                Forms\Components\Select::make('product_id')
                    ->label('Módulo (produto)')
                    ->relationship('product', 'name', function (Builder $query, Forms\Get $get) {
                        return match ($get('solution_type')) {
                            'sistemas' => $query->systems(),
                            'cloud' => $query->category('cloud'),
                            default => $query->whereRaw('0 = 1'),
                        };
                    })
                    ->searchable()
                    ->preload()
                    ->helperText('Disponível apenas para os tipos Sistemas e DataCloud.')
                    ->visible(fn (Forms\Get $get) => in_array($get('solution_type'), ['sistemas', 'cloud'], true)),
                Forms\Components\Textarea::make('excerpt')
                    ->label('Resumo (usado nas listagens e na busca)')
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->label('Conteúdo do artigo')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('video_url')
                    ->label('Vídeo (YouTube ou Vimeo, opcional)')
                    ->url()
                    ->placeholder('https://www.youtube.com/watch?v=...'),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Imagem de capa')
                    ->image()
                    ->directory('knowledge')
                    ->imageEditor(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_published')
                    ->label('Publicado')
                    ->default(true)
                    ->required(),
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
                Tables\Columns\TextColumn::make('solution_type')
                    ->label('Tipo de solução')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => KnowledgeArticle::SOLUTION_TYPES[$state] ?? $state),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Módulo')
                    ->placeholder('—'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publicado')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('solution_type')
                    ->label('Tipo de solução')
                    ->options(KnowledgeArticle::SOLUTION_TYPES),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Publicado'),
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
            'index' => Pages\ListKnowledgeArticles::route('/'),
            'create' => Pages\CreateKnowledgeArticle::route('/create'),
            'edit' => Pages\EditKnowledgeArticle::route('/{record}/edit'),
        ];
    }
}
