<?php

namespace App\Http\Controllers;

use App\Models\Licitacao;
use Illuminate\Http\Request;

class LicitacaoController extends Controller
{
    public function index(Request $request)
    {
        $licitacoes = Licitacao::active()
            ->withCount('documents')
            ->when($request->filled('modalidade'), fn ($query) => $query->where('modality', $request->string('modalidade')))
            ->when($request->filled('ano'), fn ($query) => $query->where('year', $request->integer('ano')))
            ->orderByDesc('published_at')
            ->orderByDesc('year')
            ->paginate(12)
            ->withQueryString();

        $modalities = Licitacao::active()->distinct()->orderBy('modality')->pluck('modality');
        $years = Licitacao::active()->whereNotNull('year')->distinct()->orderByDesc('year')->pluck('year');

        return view('licitacoes.index', compact('licitacoes', 'modalities', 'years'));
    }

    public function show(Licitacao $licitacao)
    {
        $licitacao->load('documents');

        return view('licitacoes.show', compact('licitacao'));
    }
}
