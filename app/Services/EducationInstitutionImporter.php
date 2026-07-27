<?php

namespace App\Services;

use App\Models\EducationInstitution;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EducationInstitutionImporter
{
    private const COLUMN_ALIASES = [
        'name' => ['NOME DA INSTITUIÇÃO', 'NOME DA INSTITUICAO', 'NOME', 'INSTITUIÇÃO', 'INSTITUICAO'],
        'address' => ['ENDEREÇO', 'ENDERECO'],
        'city' => ['CIDADE', 'MUNICÍPIO', 'MUNICIPIO'],
        'phone' => ['TELEFONE', 'TEL', 'CONTATO'],
        'email' => ['E-MAIL', 'EMAIL'],
    ];

    /**
     * Lê a planilha (.ods, .xlsx, .xls ou .csv) e devolve as linhas já
     * mapeadas para os campos do modelo, localizando a linha de cabeçalho
     * automaticamente (mesmo que existam linhas de título antes dela).
     *
     * @return array<int, array{name: string, address: ?string, city: ?string, phone: ?string, email: ?string}>
     */
    public function parseFile(string $path): array
    {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $grid = $sheet->toArray(null, true, true, false);

        $headerRowIndex = null;
        $columnMap = [];

        foreach ($grid as $rowIndex => $row) {
            $found = $this->mapHeaderRow($row);
            if ($found !== null) {
                $headerRowIndex = $rowIndex;
                $columnMap = $found;
                break;
            }
        }

        if ($headerRowIndex === null) {
            throw new \RuntimeException('Não foi possível localizar a linha de cabeçalho (com a coluna "Nome da Instituição") na planilha.');
        }

        $records = [];
        foreach (array_slice($grid, $headerRowIndex + 1) as $row) {
            $name = trim((string) ($row[$columnMap['name']] ?? ''));
            if ($name === '') {
                continue;
            }

            $records[] = [
                'name' => $name,
                'address' => $this->cell($row, $columnMap, 'address'),
                'city' => $this->cell($row, $columnMap, 'city'),
                'phone' => $this->cell($row, $columnMap, 'phone'),
                'email' => $this->cell($row, $columnMap, 'email'),
            ];
        }

        return $records;
    }

    /**
     * Importa os registros no banco. Em ambos os modos, um registro já
     * existente com o mesmo nome (normalizado) é atualizado em vez de
     * duplicado.
     *
     * @param array<int, array{name: string, address: ?string, city: ?string, phone: ?string, email: ?string}> $records
     * @return array{created: int, updated: int, deleted: int}
     */
    public function import(array $records, bool $replaceAll = false): array
    {
        $deleted = 0;

        if ($replaceAll) {
            $deleted = EducationInstitution::query()->count();
            EducationInstitution::query()->delete();
        }

        $created = 0;
        $updated = 0;

        foreach ($records as $index => $record) {
            $key = EducationInstitution::normalizeKey($record['name']);

            $institution = EducationInstitution::where('name_key', $key)->first();

            $attributes = [
                'name' => $record['name'],
                'address' => $record['address'] ?: null,
                'city' => $record['city'] ?: null,
                'phone' => $record['phone'] ?: null,
                'email' => $record['email'] ?: null,
                'sort_order' => $index + 1,
                'is_active' => true,
            ];

            if ($institution) {
                $institution->update($attributes);
                $updated++;
            } else {
                EducationInstitution::create($attributes);
                $created++;
            }
        }

        return ['created' => $created, 'updated' => $updated, 'deleted' => $deleted];
    }

    private function cell(array $row, array $columnMap, string $field): ?string
    {
        if (! isset($columnMap[$field])) {
            return null;
        }

        $value = trim((string) ($row[$columnMap[$field]] ?? ''));

        return $value !== '' ? $value : null;
    }

    /**
     * @return array<string, int>|null Mapa campo => índice de coluna, ou null se a linha não for um cabeçalho válido.
     */
    private function mapHeaderRow(array $row): ?array
    {
        $normalized = array_map(
            fn ($value) => Str::of((string) $value)->squish()->upper()->toString(),
            $row
        );

        $map = [];
        foreach (self::COLUMN_ALIASES as $field => $aliases) {
            foreach ($normalized as $colIndex => $value) {
                if (in_array($value, $aliases, true)) {
                    $map[$field] = $colIndex;
                    break;
                }
            }
        }

        return isset($map['name']) ? $map : null;
    }
}
