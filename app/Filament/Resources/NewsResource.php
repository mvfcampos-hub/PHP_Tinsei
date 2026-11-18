<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Notícias';

    protected static ?string $modelLabel = 'notícia';

    protected static ?string $pluralModelLabel = 'notícias';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        Forms\Components\TextInput::make('slug')
                            ->label('Endereço (slug)')
                            ->prefix('/noticias/')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('excerpt')
                            ->label('Resumo')
                            ->rows(2)
                            ->maxLength(500),
                        Forms\Components\RichEditor::make('body')
                            ->label('Conteúdo')
                            ->fileAttachmentsDirectory('news/attachments'),
                    ]),
                ])->columnSpan(['lg' => 2]),
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Publicação')->schema([
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publicar em')
                            ->helperText('Deixe vazio para manter como rascunho.')
                            ->native(false)
                            ->default(now()),
                        Forms\Components\Select::make('category')
                            ->label('Categoria')
                            ->options(News::CATEGORIES)
                            ->native(false),
                        Forms\Components\Toggle::make('is_featured')->label('Destaque na home'),
                        Forms\Components\Select::make('author_id')
                            ->label('Autor')
                            ->relationship('author', 'name')
                            ->default(fn () => auth()->id())
                            ->preload(),
                    ]),
                    Forms\Components\Section::make('Mídia')->schema([
                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Imagem de capa')
                            ->image()
                            ->directory('news')
                            ->imageEditor(),
                        Forms\Components\TextInput::make('video_url')
                            ->label('Vídeo do YouTube (opcional)')
                            ->helperText('Sem capa, a miniatura do vídeo é usada.')
                            ->url(),
                    ]),
                    Forms\Components\Section::make('Fonte externa')->schema([
                        Forms\Components\TextInput::make('source_name')->label('Veículo / fonte')->placeholder('Revista PEGN'),
                        Forms\Components\TextInput::make('source_url')->label('Link da matéria original')->url(),
                    ])->collapsed(),
                ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('')->square()
                    ->getStateUsing(fn (News $record) => $record->coverUrl()),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->limit(60),
                Tables\Columns\TextColumn::make('category')->label('Categoria')->badge(),
                Tables\Columns\IconColumn::make('is_featured')->label('Destaque')->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicação')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Rascunho')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')->label('Categoria')->options(News::CATEGORIES),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Destaque'),
                Tables\Filters\TernaryFilter::make('published_at')->label('Publicada')->nullable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver no site')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (News $record) => route('news.show', $record->slug))
                    ->openUrlInNewTab()
                    ->visible(fn (News $record) => $record->published_at?->isPast()),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
