<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Banners e Avisos';

    protected static ?string $modelLabel = 'banner';

    protected static ?string $pluralModelLabel = 'banners';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Conteúdo')->schema([
                    Forms\Components\TextInput::make('eyebrow')
                        ->label('Chamada curta (acima do título)')
                        ->placeholder('Ex.: Lançamento, Sustentabilidade...'),
                    Forms\Components\TextInput::make('title')
                        ->label('Título')
                        ->required(),
                    Forms\Components\Textarea::make('subtitle')
                        ->label('Texto de apoio')
                        ->rows(2)
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('image')
                        ->label('Imagem de fundo')
                        ->helperText('Recomendado 1920×900 px. Na faixa de aviso a imagem é ignorada.')
                        ->image()
                        ->directory('banners')
                        ->imageEditor()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('link_url')
                        ->label('Link do botão')
                        ->placeholder('https://loja.tinsei.com.br/ ou /contato'),
                    Forms\Components\TextInput::make('link_label')
                        ->label('Texto do botão')
                        ->placeholder('Ver portfólio'),
                ])->columns(2),
                Forms\Components\Section::make('Exibição')->schema([
                    Forms\Components\Select::make('placement')
                        ->label('Posição')
                        ->options(Banner::PLACEMENTS)
                        ->default('home_hero')
                        ->native(false)
                        ->required(),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('Ordem')
                        ->numeric()
                        ->default(0)
                        ->required(),
                    Forms\Components\DateTimePicker::make('starts_at')
                        ->label('Exibir a partir de')
                        ->native(false),
                    Forms\Components\DateTimePicker::make('ends_at')
                        ->label('Exibir até')
                        ->native(false),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Ativo')
                        ->default(true),
                    Forms\Components\Toggle::make('overlay_title')
                        ->label('Sobrepor título e degradê na imagem')
                        ->helperText('Desative quando a imagem já for uma arte pronta, com texto.')
                        ->default(true),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label(''),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->limit(50),
                Tables\Columns\TextColumn::make('placement')
                    ->label('Posição')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Banner::PLACEMENTS[$state] ?? $state),
                Tables\Columns\TextColumn::make('starts_at')->label('De')->dateTime('d/m/Y H:i')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('ends_at')->label('Até')->dateTime('d/m/Y H:i')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('sort_order')->label('Ordem')->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')->label('Ativo'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('placement')->label('Posição')->options(Banner::PLACEMENTS),
                Tables\Filters\TernaryFilter::make('is_active')->label('Ativo'),
            ])
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
