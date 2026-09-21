<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplianceSubmissionResource\Pages;
use App\Filament\Resources\ComplianceSubmissionResource\RelationManagers\FilesRelationManager;
use App\Models\ComplianceSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ComplianceSubmissionResource extends Resource
{
    protected static ?string $model = ComplianceSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'Fiscalização';

    protected static ?string $navigationLabel = 'Portal de Adequação';

    protected static ?string $modelLabel = 'envio';

    protected static ?string $pluralModelLabel = 'envios do Portal de Adequação';

    public static function getNavigationBadge(): ?string
    {
        $pending = static::getModel()::where('status', 'pending')->count();

        return $pending > 0 ? (string) $pending : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('protocol')
                    ->label('Protocolo')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('nutritionist_name')
                    ->label('Nome do profissional')
                    ->required(),
                Forms\Components\TextInput::make('crn_number')
                    ->label('Número CRN-9')
                    ->required(),
                Forms\Components\TextInput::make('inspection_reference')
                    ->label('Referência da fiscalização'),
                Forms\Components\Textarea::make('notes')
                    ->label('Observações do profissional')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Aguardando análise',
                        'reviewed' => 'Analisado',
                    ])
                    ->live()
                    ->afterStateUpdated(fn (string $state, Forms\Set $set) => $set('reviewed_at', $state === 'reviewed' ? now() : null))
                    ->required(),
                Forms\Components\DateTimePicker::make('reviewed_at')
                    ->label('Analisado em')
                    ->native(false),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('protocol')
                    ->label('Protocolo')
                    ->searchable()
                    ->fontFamily('mono'),
                Tables\Columns\TextColumn::make('nutritionist_name')
                    ->label('Profissional')
                    ->searchable(),
                Tables\Columns\TextColumn::make('crn_number')
                    ->label('CRN-9 nº')
                    ->searchable(),
                Tables\Columns\TextColumn::make('inspection_reference')
                    ->label('Referência'),
                Tables\Columns\TextColumn::make('files_count')
                    ->label('Arquivos')
                    ->counts('files'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'reviewed' ? 'Analisado' : 'Aguardando análise')
                    ->color(fn (string $state) => $state === 'reviewed' ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enviado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Aguardando análise',
                        'reviewed' => 'Analisado',
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
            FilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComplianceSubmissions::route('/'),
            'create' => Pages\CreateComplianceSubmission::route('/create'),
            'edit' => Pages\EditComplianceSubmission::route('/{record}/edit'),
        ];
    }
}
