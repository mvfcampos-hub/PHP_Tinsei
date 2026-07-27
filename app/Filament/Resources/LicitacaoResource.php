<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LicitacaoResource\Pages;
use App\Filament\Resources\LicitacaoResource\RelationManagers\DocumentsRelationManager;
use App\Models\Licitacao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LicitacaoResource extends Resource
{
    protected static ?string $model = Licitacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static ?string $navigationGroup = 'Conselho';

    protected static ?string $navigationLabel = 'Licitações';

    protected static ?string $modelLabel = 'licitação';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->placeholder('Pregão Eletrônico nº 1/2026')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $state, Forms\Set $set) => $set('slug', Str::slug($state)))
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                Forms\Components\Select::make('modality')
                    ->label('Modalidade')
                    ->options([
                        'Pregão Eletrônico' => 'Pregão Eletrônico',
                        'Tomada de Preços' => 'Tomada de Preços',
                        'Chamamento Público' => 'Chamamento Público',
                        'Edital' => 'Edital',
                        'Dispensa' => 'Dispensa',
                        'Outro' => 'Outro',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('number')
                    ->label('Número')
                    ->placeholder('1/2026'),
                Forms\Components\TextInput::make('year')
                    ->label('Ano')
                    ->numeric()
                    ->default(now()->year),
                Forms\Components\Select::make('status')
                    ->label('Situação')
                    ->options([
                        'aberta' => 'Aberta',
                        'encerrada' => 'Encerrada',
                        'homologada' => 'Homologada',
                        'revogada' => 'Revogada',
                    ])
                    ->default('aberta')
                    ->required(),
                Forms\Components\DatePicker::make('published_at')
                    ->label('Publicado em')
                    ->native(false)
                    ->default(now()),
                Forms\Components\Textarea::make('description')
                    ->label('Objeto / Descrição')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('modality')
                    ->label('Modalidade')
                    ->badge(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Ano')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Situação')
                    ->badge(),
                Tables\Columns\TextColumn::make('documents_count')
                    ->label('Documentos')
                    ->counts('documents'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicado em')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('modality')
                    ->label('Modalidade')
                    ->options(fn () => Licitacao::query()->distinct()->pluck('modality', 'modality')->all()),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Situação')
                    ->options([
                        'aberta' => 'Aberta',
                        'encerrada' => 'Encerrada',
                        'homologada' => 'Homologada',
                        'revogada' => 'Revogada',
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
            DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLicitacoes::route('/'),
            'create' => Pages\CreateLicitacao::route('/create'),
            'edit' => Pages\EditLicitacao::route('/{record}/edit'),
        ];
    }
}
