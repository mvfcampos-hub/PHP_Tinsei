<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InspectorResource\Pages;
use App\Filament\Resources\InspectorResource\RelationManagers;
use App\Models\Inspector;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InspectorResource extends Resource
{
    protected static ?string $model = Inspector::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Fiscalização';

    protected static ?string $navigationLabel = 'Equipe de Fiscalização';

    protected static ?string $modelLabel = 'fiscal';

    protected static ?string $pluralModelLabel = 'equipe de fiscalização';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->directory('inspectors')
                    ->imageEditor()
                    ->avatar()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                Forms\Components\TextInput::make('role')
                    ->label('Cargo/Função')
                    ->placeholder('Fiscal, Coordenador de Fiscalização...'),
                Forms\Components\TextInput::make('region')
                    ->label('Região de atuação'),
                Forms\Components\TextInput::make('registration_number')
                    ->label('Nº de registro profissional'),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email(),
                Forms\Components\TextInput::make('phone')
                    ->label('Telefone')
                    ->tel(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->required()
                    ->numeric()
                    ->default(0),
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
                Tables\Columns\ImageColumn::make('photo')
                    ->label('')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Cargo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->label('Região')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_number')
                    ->label('Registro'),
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
            'index' => Pages\ListInspectors::route('/'),
            'create' => Pages\CreateInspector::route('/create'),
            'edit' => Pages\EditInspector::route('/{record}/edit'),
        ];
    }
}
