<?php

namespace App\Http\Controllers;

use App\Models\FiscalizacaoStat;

class FiscalizacaoStatsController extends Controller
{
    public function show()
    {
        $stats = FiscalizacaoStat::active()
            ->orderBy('sort_order')
            ->get();

        return view('fiscalizacao.em-numeros', compact('stats'));
    }
}
