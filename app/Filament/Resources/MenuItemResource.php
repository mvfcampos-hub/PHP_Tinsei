<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Filament\Resources\MenuItemResource\RelationManagers;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Menu de Navegação';

    protected static ?string $modelLabel = 'item de menu';

    protected static ?string $pluralModelLabel = 'menu de navegação';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->label('Rótulo (texto do menu)')
                    ->required(),
                Forms\Components\Select::make('page_id')
                    ->label('Página interna vinculada')
                    ->relationship('page', 'title')
                    ->searchable()
                    ->preload()
                    ->helperText('Se selecionada, o link aponta para esta página. Caso contrário, use o campo URL abaixo.'),
                Forms\Components\TextInput::make('url')
                    ->label('URL (interna ou externa)')
                    ->helperText('Ignorado se uma página interna estiver selecionada acima.'),
                Forms\Components\Select::make('parent_id')
                    ->label('Item pai (para submenu)')
                    ->relationship('parent', 'label')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_external')
                    ->label('Link externo'),
                Forms\Components\Toggle::make('opens_new_tab')
                    ->label('Abrir em nova aba'),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Rótulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.label')
                    ->label('Item pai'),
                Tables\Columns\TextColumn::make('page.title')
                    ->label('Página vinculada'),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_external')
                    ->label('Externo')
                    ->boolean(),
                Tables\Columns\IconColumn::make('opens_new_tab')
                    ->label('Nova aba')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                //
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
