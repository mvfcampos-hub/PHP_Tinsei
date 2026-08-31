<?php

namespace App\Filament\Resources\LibraryDocumentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    protected static ?string $title = 'Arquivos';

    protected static ?string $modelLabel = 'arquivo';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->label('Nome do arquivo')
                    ->placeholder('Cartilha, Folder, Relatório...')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file')
                    ->label('Arquivo (upload)')
                    ->directory('biblioteca')
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'image/jpeg',
                        'image/png',
                    ])
                    ->helperText('Envie um arquivo novo aqui, ou preencha o link externo abaixo para um documento já publicado em outro endereço.')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('external_url')
                    ->label('Link externo (se não houver upload)')
                    ->url()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->numeric()
                    ->default(0),
            ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Arquivo')
                    ->searchable(),
                Tables\Columns\IconColumn::make('file')
                    ->label('Upload')
                    ->boolean()
                    ->getStateUsing(fn ($record) => filled($record->file)),
                Tables\Columns\TextColumn::make('external_url')
                    ->label('Link externo')
                    ->limit(40),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
