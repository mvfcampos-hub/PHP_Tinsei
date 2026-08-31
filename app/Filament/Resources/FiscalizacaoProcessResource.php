<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiscalizacaoProcessResource\Pages;
use App\Models\FiscalizacaoProcess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Throwable;

class FiscalizacaoProcessResource extends Resource
{
    protected static ?string $model = FiscalizacaoProcess::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Fiscalização em Números';

    protected static ?string $navigationLabel = 'Processos em Andamento';

    protected static ?string $modelLabel = 'processo';

    protected static ?string $pluralModelLabel = 'processos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('category')
                    ->label('Categoria')
                    ->placeholder('Ex.: Ética: conduta inadequada')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('code')
                    ->label('Código')
                    ->placeholder('Ex.: A12')
                    ->required(),
                Forms\Components\TextInput::make('subject')
                    ->label('Assunto')
                    ->placeholder('Ex.: ILPI'),
                Forms\Components\DatePicker::make('started_at')
                    ->label('Início do processo')
                    ->native(false),
                Forms\Components\TextInput::make('status')
                    ->label('Situação atual')
                    ->placeholder('Ex.: No jurídico'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem de exibição')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Publicado no painel de transparência')
                    ->default(true)
                    ->required(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->wrap(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Assunto'),
                Tables\Columns\TextColumn::make('started_at')
                    ->label('Início')
                    ->date('Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Situação'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Publicado')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Publicado'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('import')
                    ->label('Importar planilha (Excel/CSV)')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->label('Planilha')
                            ->helperText('Colunas esperadas: Categoria, Código, Assunto, Início do Processo, Situação Atual.')
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-excel',
                                'text/csv',
                            ])
                            ->required()
                            ->storeFiles(false),
                    ])
                    ->action(function (array $data): void {
                        /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file */
                        $file = $data['file'];

                        try {
                            $spreadsheet = IOFactory::load($file->getRealPath());
                            $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
                        } catch (Throwable $e) {
                            Notification::make()
                                ->title('Não foi possível ler a planilha')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();

                            return;
                        }

                        if (count($rows) < 2) {
                            Notification::make()->title('Planilha vazia ou sem linhas de dados.')->warning()->send();

                            return;
                        }

                        $header = array_map(fn ($value) => \Illuminate\Support\Str::of((string) $value)->lower()->ascii()->squish()->toString(), $rows[0]);

                        $columnIndex = fn (array $candidates) => collect($candidates)
                            ->map(fn ($candidate) => array_search($candidate, $header, true))
                            ->first(fn ($index) => $index !== false);

                        $categoryIdx = $columnIndex(['categoria']);
                        $codeIdx = $columnIndex(['codigo', 'código']);
                        $subjectIdx = $columnIndex(['assunto']);
                        $startedIdx = $columnIndex(['inicio do processo', 'início do processo', 'inicio', 'início']);
                        $statusIdx = $columnIndex(['situacao atual', 'situação atual', 'situacao', 'situação']);

                        if ($categoryIdx === false || $codeIdx === false) {
                            Notification::make()
                                ->title('Colunas obrigatórias não encontradas')
                                ->body('A planilha precisa ter, no mínimo, as colunas "Categoria" e "Código".')
                                ->danger()
                                ->send();

                            return;
                        }

                        $created = 0;
                        $updated = 0;

                        foreach (array_slice($rows, 1) as $row) {
                            $code = trim((string) ($row[$codeIdx] ?? ''));

                            if ($code === '') {
                                continue;
                            }

                            $startedRaw = $startedIdx !== false ? trim((string) ($row[$startedIdx] ?? '')) : null;
                            $startedAt = null;

                            if (filled($startedRaw)) {
                                $startedAt = is_numeric($startedRaw) && strlen($startedRaw) === 4
                                    ? Carbon::createFromDate((int) $startedRaw, 1, 1)
                                    : (Carbon::createFromFormat('d/m/Y', $startedRaw) ?: Carbon::parse($startedRaw));
                            }

                            $process = FiscalizacaoProcess::updateOrCreate(
                                ['code' => $code],
                                [
                                    'category' => trim((string) ($row[$categoryIdx] ?? '')),
                                    'subject' => $subjectIdx !== false ? trim((string) ($row[$subjectIdx] ?? '')) : null,
                                    'started_at' => $startedAt,
                                    'status' => $statusIdx !== false ? trim((string) ($row[$statusIdx] ?? '')) : null,
                                    'is_active' => true,
                                ]
                            );

                            $process->wasRecentlyCreated ? $created++ : $updated++;
                        }

                        Notification::make()
                            ->title('Importação concluída')
                            ->body("{$created} processo(s) criado(s), {$updated} atualizado(s).")
                            ->success()
                            ->send();
                    }),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiscalizacaoProcesses::route('/'),
            'create' => Pages\CreateFiscalizacaoProcess::route('/create'),
            'edit' => Pages\EditFiscalizacaoProcess::route('/{record}/edit'),
        ];
    }
}
