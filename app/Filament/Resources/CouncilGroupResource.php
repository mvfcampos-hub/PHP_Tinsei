<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouncilGroupResource\Pages;
use App\Filament\Resources\CouncilGroupResource\RelationManagers\MembersRelationManager;
use App\Models\CouncilGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouncilGroupResource extends Resource
{
    protected static ?string $model = CouncilGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Conselho';

    protected static ?string $navigationLabel = 'Plenário';

    protected static ?string $modelLabel = 'grupo do plenário';

    protected static ?string $pluralModelLabel = 'grupos do plenário';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome do grupo')
                    ->placeholder('Diretoria, I – Comissão de Tomada de Contas...')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('kind')
                    ->label('Tipo')
                    ->options([
                        'diretoria' => 'Diretoria',
                        'comissao' => 'Comissão',
                        'camara' => 'Câmara Técnica',
                        'historico' => 'Arquivo histórico',
                    ])
                    ->required()
                    ->default('comissao'),
                Forms\Components\TextInput::make('contact_email')
                    ->label('E-mail de contato do grupo')
                    ->email(),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kind')
                    ->label('Tipo')
                    ->badge(),
                Tables\Columns\TextColumn::make('members_count')
                    ->label('Membros')
                    ->counts('members'),
                Tables\Columns\TextColumn::make('contact_email')
                    ->label('Contato'),
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
                Tables\Filters\SelectFilter::make('kind')
                    ->label('Tipo')
                    ->options([
                        'diretoria' => 'Diretoria',
                        'comissao' => 'Comissão',
                        'camara' => 'Câmara Técnica',
                        'historico' => 'Arquivo histórico',
                    ]),
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
            MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCouncilGroups::route('/'),
            'create' => Pages\CreateCouncilGroup::route('/create'),
            'edit' => Pages\EditCouncilGroup::route('/{record}/edit'),
        ];
    }
}
