<?php

namespace App\Filament\Resources\EducationInstitutionResource\Pages;

use App\Filament\Resources\EducationInstitutionResource;
use App\Services\EducationInstitutionImporter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Storage;

class ImportEducationInstitutions extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = EducationInstitutionResource::class;

    protected static string $view = 'filament.resources.education-institution-resource.pages.import-education-institutions';

    protected static ?string $title = 'Importar planilha de Instituições de Ensino';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file')
                    ->label('Planilha (.ods, .xlsx ou .csv)')
                    ->required()
                    ->acceptedFileTypes([
                        'application/vnd.oasis.opendocument.spreadsheet',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.ms-excel',
                        'text/csv',
                    ])
                    ->directory('imports/education-institutions')
                    ->helperText('A planilha deve seguir o layout com as colunas: Nome da Instituição, Endereço, Cidade, Telefone, E-mail (a linha de cabeçalho é localizada automaticamente).')
                    ->storeFileNamesIn('file_name'),
                Radio::make('mode')
                    ->label('Modo de importação')
                    ->options([
                        'merge' => 'Adicionar/atualizar — registros existentes com o mesmo nome são atualizados, sem duplicar',
                        'replace' => 'Excluir todas e importar — apaga toda a base atual e recria a partir da planilha',
                    ])
                    ->default('merge')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function import(): void
    {
        $state = $this->form->getState();

        $absolutePath = Storage::disk('public')->path($state['file']);

        try {
            $importer = new EducationInstitutionImporter();
            $records = $importer->parseFile($absolutePath);

            if (empty($records)) {
                Notification::make()
                    ->title('Nenhum registro encontrado na planilha')
                    ->warning()
                    ->send();

                return;
            }

            $result = $importer->import($records, replaceAll: $state['mode'] === 'replace');

            $message = "{$result['created']} criado(s), {$result['updated']} atualizado(s)";
            if ($result['deleted'] > 0) {
                $message .= ", {$result['deleted']} removido(s) antes da importação";
            }

            Notification::make()
                ->title('Importação concluída')
                ->body($message)
                ->success()
                ->send();

            $this->form->fill();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Erro ao importar a planilha')
                ->body($e->getMessage())
                ->danger()
                ->send();
        } finally {
            Storage::disk('public')->delete($state['file'] ?? '');
        }
    }
}
