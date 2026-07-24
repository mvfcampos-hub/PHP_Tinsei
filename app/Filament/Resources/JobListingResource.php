<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Filament\Resources\JobListingResource\RelationManagers;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Serviços';

    protected static ?string $navigationLabel = 'Banco de Oportunidades';

    protected static ?string $modelLabel = 'vaga';

    protected static ?string $pluralModelLabel = 'vagas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título da vaga')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('company')
                    ->label('Empresa/Instituição'),
                Forms\Components\TextInput::make('location')
                    ->label('Município/Local'),
                Forms\Components\TextInput::make('contract_type')
                    ->label('Tipo de contrato')
                    ->placeholder('CLT, PJ, Estágio...'),
                Forms\Components\Textarea::make('description')
                    ->label('Descrição da vaga')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('contact_email')
                    ->label('E-mail de contato')
                    ->email(),
                Forms\Components\TextInput::make('contact_phone')
                    ->label('Telefone de contato')
                    ->tel(),
                Forms\Components\TextInput::make('external_url')
                    ->label('Link externo (candidatura)')
                    ->url(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Publicar em')
                    ->native(false)
                    ->default(now()),
                Forms\Components\DateTimePicker::make('expires_at')
                    ->label('Expira em')
                    ->native(false),
                Forms\Components\Toggle::make('is_active')
                    ->label('Ativa')
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('company')
                    ->label('Empresa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Local')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contract_type')
                    ->label('Contrato'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicada em')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expira em')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativa')
                    ->boolean(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Ativa'),
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
            'index' => Pages\ListJobListings::route('/'),
            'create' => Pages\CreateJobListing::route('/create'),
            'edit' => Pages\EditJobListing::route('/{record}/edit'),
        ];
    }
}
