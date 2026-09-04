<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPresence extends Model
{
    use HasFactory;

    public const TYPE_STATE = 'state';

    public const TYPE_REGION = 'region';

    public const TYPE_COUNTRY = 'country';

    // As 5 regiões oficiais do IBGE, usadas na área administrativa e no mapa
    // de presença da home (substituindo o antigo detalhamento por UF).
    // Códigos de região propositalmente distintos das UFs (ex.: "SD" em vez
    // de "SE") para nunca colidir com a sigla de um estado (Sergipe = SE).
    public const REGIONS = [
        'N' => 'Norte',
        'NE' => 'Nordeste',
        'CO' => 'Centro-Oeste',
        'SD' => 'Sudeste',
        'S' => 'Sul',
    ];

    // Mapeamento de UF (usado apenas para colorir o mapa SVG do Brasil, que é
    // desenhado por estado) para o código de região correspondente.
    public const STATE_REGIONS = [
        'AC' => 'N', 'AP' => 'N', 'AM' => 'N', 'PA' => 'N', 'RO' => 'N', 'RR' => 'N', 'TO' => 'N',
        'AL' => 'NE', 'BA' => 'NE', 'CE' => 'NE', 'MA' => 'NE', 'PB' => 'NE', 'PE' => 'NE', 'PI' => 'NE', 'RN' => 'NE', 'SE' => 'NE',
        'DF' => 'CO', 'GO' => 'CO', 'MS' => 'CO', 'MT' => 'CO',
        'ES' => 'SD', 'MG' => 'SD', 'RJ' => 'SD', 'SP' => 'SD',
        'PR' => 'S', 'RS' => 'S', 'SC' => 'S',
    ];

    protected $fillable = [
        'region_type',
        'code',
        'name',
        'device_count',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'device_count' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('region_type', $type);
    }
}
