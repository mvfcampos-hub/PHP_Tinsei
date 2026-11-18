<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioCategoryResource\Pages;
use App\Models\PortfolioCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PortfolioCategoryResource extends Resource
{
    protected static ?string $model = PortfolioCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Comercial';

    protected static ?string $navigationLabel = 'Linhas do Portfólio';

    protected static ?string $modelLabel = 'linha do portfólio';

    protected static ?string $pluralModelLabel = 'linhas do portfólio';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nome')->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('tagline')->label('Chamada curta')->columnSpanFull(),
                Forms\Components\Textarea::make('description')->label('Descrição')->rows(3)->columnSpanFull(),
                Forms\Components\TagsInput::make('highlights')->label('Destaques (tópicos)')->columnSpanFull(),
                Forms\Components\Select::make('icon')->label('Ícone')->options(PortfolioCategory::ICONS)->native(false),
                Forms\Components\TextInput::make('item_count_label')->label('Quantidade (opcional)')->placeholder('+600 itens'),
                Forms\Components\FileUpload::make('image')->label('Imagem')->image()->directory('portfolio')->imageEditor(),
                Forms\Components\TextInput::make('store_url')->label('Link na loja')->url()
                    ->helperText('Vazio = página inicial da loja (Configurações do site).'),
                Forms\Components\TextInput::make('sort_order')->label('Ordem')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->label('Exibir no site')->default(true),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('')->square(),
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable(),
                Tables\Columns\TextColumn::make('item_count_label')->label('Quantidade'),
                Tables\Columns\TextColumn::make('store_url')->label('Link na loja')->limit(40)->toggleable(),
                Tables\Columns\ToggleColumn::make('is_active')->label('Exibir'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolioCategories::route('/'),
            'create' => Pages\CreatePortfolioCategory::route('/create'),
            'edit' => Pages\EditPortfolioCategory::route('/{record}/edit'),
        ];
    }
}
