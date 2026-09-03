<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MspSetting extends Model
{
    protected $fillable = [
        'server_price',
        'minimum_contract',
    ];

    protected $casts = [
        'server_price' => 'decimal:2',
        'minimum_contract' => 'decimal:2',
    ];

    // Configuração única do MSP (mensalidade do servidor e contrato
    // mínimo) — sempre o registro de id 1, criado com os valores padrão
    // se ainda não existir.
    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'server_price' => 250,
            'minimum_contract' => 1390,
        ]);
    }
}
