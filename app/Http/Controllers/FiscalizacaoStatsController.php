<?php

namespace App\Http\Controllers;

use App\Models\FiscalizacaoRegionStat;
use App\Models\FiscalizacaoStat;

class FiscalizacaoStatsController extends Controller
{
    public function show()
    {
        $stats = FiscalizacaoStat::active()
            ->orderBy('sort_order')
            ->get();

        $regionStats = FiscalizacaoRegionStat::active()
            ->orderBy('sort_order')
            ->get();

        $maxRegionVisits = max($regionStats->max('visits_count'), 1);

        return view('fiscalizacao.em-numeros', compact('stats', 'regionStats', 'maxRegionVisits'));
    }
}
