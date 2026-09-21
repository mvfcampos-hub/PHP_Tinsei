<?php

namespace App\Http\Controllers;

use App\Models\FiscalizacaoProcess;

class FiscalizacaoProcessController extends Controller
{
    public function index()
    {
        $processes = FiscalizacaoProcess::active()
            ->orderBy('sort_order')
            ->orderByDesc('started_at')
            ->get();

        return view('fiscalizacao.processos', compact('processes'));
    }
}
