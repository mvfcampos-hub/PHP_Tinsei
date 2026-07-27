<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Serviços';

    protected static ?string $navigationLabel = 'Banco de Oportunidades';

    protected static ?string $modelLabel = 'vaga';

    protected static ?string $pluralModelLabel = 'vagas';

    public static function getNavigationBadge(): ?string
    {
        $count = JobListing::pending()->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

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
                Forms\Components\Select::make('status')
                    ->label('Situação')
                    ->options([
                        'pending' => 'Aguardando aprovação',
                        'approved' => 'Aprovada',
                        'rejected' => 'Recusada',
                    ])
                    ->default('approved')
                    ->required(),
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
                Forms\Components\Section::make('Dados de quem cadastrou a vaga')
                    ->description('Preenchido automaticamente quando a vaga é enviada pelo formulário público. Não aparece no site.')
                    ->schema([
                        Forms\Components\TextInput::make('submitter_name')
                            ->label('Nome')
                            ->disabled(),
                        Forms\Components\TextInput::make('submitter_email')
                            ->label('E-mail')
                            ->disabled(),
                        Forms\Components\TextInput::make('submitter_phone')
                            ->label('Telefone')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('removal_requested_at')
                            ->label('Remoção solicitada em')
                            ->disabled(),
                    ])
                    ->columns(2)
                    ->collapsed()
                    ->visible(fn (?JobListing $record) => filled($record?->submitter_email)),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Situação')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending' => 'Aguardando aprovação',
                        'approved' => 'Aprovada',
                        'rejected' => 'Recusada',
                        default => $state,
                    })
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('company')
                    ->label('Empresa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('submitter_name')
                    ->label('Cadastrada por')
                    ->description(fn (?JobListing $record) => $record?->submitter_email)
                    ->placeholder('Admin'),
                Tables\Columns\TextColumn::make('location')
                    ->label('Local')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicada em')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativa')
                    ->boolean(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Situação')
                    ->options([
                        'pending' => 'Aguardando aprovação',
                        'approved' => 'Aprovada',
                        'rejected' => 'Recusada',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Ativa'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Aprovar')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (JobListing $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(fn (JobListing $record) => $record->update([
                        'status' => 'approved',
                        'is_active' => true,
                        'published_at' => $record->published_at ?? now(),
                    ])),
                Tables\Actions\Action::make('reject')
                    ->label('Recusar')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (JobListing $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(fn (JobListing $record) => $record->update([
                        'status' => 'rejected',
                        'is_active' => false,
                    ])),
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
