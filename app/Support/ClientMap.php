<?php

namespace App\Support;

use App\Models\StateClientCount;

// Monta os dados do mapa de clientes por estado (home e "Onde estamos").
class ClientMap
{
    public static function build(): array
    {
        // toBase(): a coleção do Eloquent filtra por chave primária, não pela UF.
        $rows = StateClientCount::active()->get()->toBase()->keyBy('code');
        $states = $rows->except([StateClientCount::ABROAD]);
        $abroad = (int) ($rows->get(StateClientCount::ABROAD)?->client_count ?? 0);

        $mapTotal = (int) $rows->sum('client_count');
        $override = (int) preg_replace('/\D/', '', (string) setting('active_clients_override'));
        $max = max(1, (int) $states->max('client_count'));

        $regions = collect(StateClientCount::REGIONS)->map(fn ($codes, $name) => [
            'name' => $name,
            'count' => (int) $states->only($codes)->sum('client_count'),
        ])->sortByDesc('count')->values();

        return [
            'svg' => require resource_path('data/brazil-states.php'),
            'counts' => $states->mapWithKeys(fn ($row) => [$row->code => (int) $row->client_count])->all(),
            'names' => StateClientCount::STATES,
            'ranking' => $states->sortByDesc('client_count')->values(),
            'regions' => $regions,
            'abroad' => $abroad,
            'max' => $max,
            'total' => $override > 0 ? $override : $mapTotal,
            'states_served' => $states->where('client_count', '>', 0)->count(),
        ];
    }

    // Intensidade (0–1) usada para colorir cada estado — escala logarítmica
    // para que estados menores continuem visíveis ao lado de MG e SP.
    public static function intensity(int $count, int $max): float
    {
        if ($count <= 0) {
            return 0.0;
        }

        return round(0.18 + 0.82 * (log($count + 1) / log($max + 1)), 3);
    }
}
