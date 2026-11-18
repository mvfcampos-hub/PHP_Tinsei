<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

// Quantidade de clientes ativos por UF — editável no painel e exibida no
// mapa do Brasil. O código "EX" agrupa os clientes no exterior.
class StateClientCount extends Model
{
    public const ABROAD = 'EX';

    public const STATES = [
        'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia',
        'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás',
        'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais',
        'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo',
        'SE' => 'Sergipe', 'TO' => 'Tocantins',
    ];

    public const REGIONS = [
        'Norte' => ['AC', 'AP', 'AM', 'PA', 'RO', 'RR', 'TO'],
        'Nordeste' => ['AL', 'BA', 'CE', 'MA', 'PB', 'PE', 'PI', 'RN', 'SE'],
        'Centro-Oeste' => ['DF', 'GO', 'MS', 'MT'],
        'Sudeste' => ['ES', 'MG', 'RJ', 'SP'],
        'Sul' => ['PR', 'RS', 'SC'],
    ];

    protected $fillable = ['code', 'name', 'client_count', 'is_active'];

    protected $casts = [
        'client_count' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function options(): array
    {
        return self::STATES + [self::ABROAD => 'Exterior'];
    }

    public static function regionOf(string $code): ?string
    {
        foreach (self::REGIONS as $region => $codes) {
            if (in_array($code, $codes, true)) {
                return $region;
            }
        }

        return null;
    }
}
