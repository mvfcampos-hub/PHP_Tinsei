<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PodeNaoPodeQuestionResource\Pages;
use App\Models\PodeNaoPodeQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PodeNaoPodeQuestionResource extends Resource
{
    protected static ?string $model = PodeNaoPodeQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationGroup = 'Pode ou Não Pode?';

    protected static ?string $navigationLabel = 'Pode ou Não Pode?';

    protected static ?string $modelLabel = 'pergunta';

    protected static ?string $pluralModelLabel = 'perguntas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('category')
                    ->label('Categoria')
                    ->helperText('Agrupa as perguntas na página pública. Ex.: Fitoterapia e PICS, Prescrição e Suplementos.')
                    ->datalist([
                        'Fitoterapia e PICS',
                        'Prescrição e Suplementos',
                        'Exames e Prontuário',
                        'Responsabilidade Técnica',
                    ])
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('question')
                    ->label('Pergunta')
                    ->placeholder('Ex.: Nutricionista sem pós-graduação pode prescrever fitoterápico?')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('answer')
                    ->label('Resposta direta')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('resolution_reference')
                    ->label('Base normativa')
                    ->placeholder('Ex.: Resolução CFN nº 680/2021')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('template_label')
                    ->label('Rótulo do botão de cópia')
                    ->placeholder('Ex.: Copiar modelo do carimbo')
                    ->helperText('Só aparece se houver um modelo abaixo.'),
                Forms\Components\Textarea::make('template_text')
                    ->label('Modelo copiável (opcional)')
                    ->helperText('Texto pronto que o profissional pode copiar com 1 clique, ex.: modelo de carimbo.')
                    ->rows(3),
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
                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('question')
                    ->label('Pergunta')
                    ->searchable()
                    ->wrap()
                    ->limit(80),
                Tables\Columns\TextColumn::make('resolution_reference')
                    ->label('Base normativa'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
            ])
            ->defaultSort('category')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoria')
                    ->options(fn () => PodeNaoPodeQuestion::query()->distinct()->pluck('category', 'category')->toArray()),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPodeNaoPodeQuestions::route('/'),
            'create' => Pages\CreatePodeNaoPodeQuestion::route('/create'),
            'edit' => Pages\EditPodeNaoPodeQuestion::route('/{record}/edit'),
        ];
    }
}
