<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Banners e Avisos';

    protected static ?string $modelLabel = 'banner';

    protected static ?string $pluralModelLabel = 'banners';

    public const PLACEMENTS = [
        'home_hero' => 'Destaque principal (topo da home)',
        'home_notice' => 'Aviso geral (faixa de avisos da home)',
        'home_secondary' => 'Home - seção secundária',
        'campaign' => 'Campanha / data especial',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->label('Imagem')
                    ->image()
                    ->directory('banners')
                    ->imageEditor()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('link_url')
                    ->label('Link de destino')
                    ->url(),
                Forms\Components\Select::make('placement')
                    ->label('Posição')
                    ->options(self::PLACEMENTS)
                    ->native(false)
                    ->required(),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Exibir a partir de')
                    ->native(false),
                Forms\Components\DateTimePicker::make('ends_at')
                    ->label('Exibir até')
                    ->native(false),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Ativo')
                    ->default(true)
                    ->required(),
                Forms\Components\Toggle::make('overlay_title')
                    ->label('Sobrepor título e gradiente na imagem')
                    ->helperText('Desative quando a imagem já for uma peça pronta (com texto e logomarca), para exibi-la sem sobreposição.')
                    ->default(true)
                    ->required(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(''),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('placement')
                    ->label('Posição')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => self::PLACEMENTS[$state] ?? $state),
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
                Tables\Columns\IconColumn::make('overlay_title')
                    ->label('Título sobreposto')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('placement')
                    ->label('Posição')
                    ->options(self::PLACEMENTS),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
