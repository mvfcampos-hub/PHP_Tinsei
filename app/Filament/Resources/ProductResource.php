<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Produtos & Serviços';

    protected static ?string $navigationLabel = 'Produtos';

    protected static ?string $modelLabel = 'produto';

    protected static ?string $pluralModelLabel = 'produtos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome do produto')
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
                    ->options(Product::CATEGORIES)
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('tagline')
                    ->label('Chamada curta (tagline)')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('summary')
                    ->label('Resumo (usado nos cards)')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('description')
                    ->label('Descrição completa (página do produto)')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('icon')
                    ->label('Ícone (nome heroicon, ex.: heroicon-o-cloud)')
                    ->helperText('Consulte a lista de ícones em blade-ui-kit.com/blade-icons'),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Imagem de capa')
                    ->image()
                    ->directory('products')
                    ->imageEditor(),
                Forms\Components\TextInput::make('external_url')
                    ->label('Site próprio do produto (opcional)')
                    ->url()
                    ->placeholder('https://datasac.com.br'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Destaque na home'),
                Forms\Components\Toggle::make('is_cloud_highlight')
                    ->label('Destaque especial de Cloud')
                    ->helperText('Marque para exibir na seção especial de DataCloud da home.'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Ativo')
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Product::CATEGORIES[$state] ?? $state),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destaque')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_cloud_highlight')
                    ->label('Cloud')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoria')
                    ->options(Product::CATEGORIES),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Destaque'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
