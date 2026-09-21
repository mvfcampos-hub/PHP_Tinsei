<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    /**
     * Páginas de índice de serviços cujos itens relacionados são exibidos
     * como uma grade de caixas clicáveis (em vez de uma lista de texto),
     * na ordem em que devem aparecer.
     */
    private const SERVICE_GROUPS = [
        'servicos-nutricionistas' => [
            'servico-anuidade-2026-nutricionista',
            'servico-inscricao-provisoria-pf-nutri',
            'servico-inscricao-de-provisoria-para-definitiva-nutri',
            'servico-inscricao-definitiva-pf-nutri',
            'servico-transferencia-pf-nutri',
            'servico-inscricao-secundaria-pf-nutri',
            'servico-prorrogacao-de-inscricao-provisoria',
            'servico-baixa-temporaria',
            'servico-cancelamento-de-inscricao',
            'servico-reativacao-de-inscricao',
            'servico-solicitacao-certidao-regularidade-nutri',
            'servico-solicitacao-de-segunda-via-de-carteira-profissional',
        ],
        'servicos-tnd' => [
            'servico-solicitacao-de-segunda-via-de-carteira-profissional-2',
            'servico-anuidade-2026-tnd',
            'servico-inscricao-provisoria-pf-tnd',
            'servico-inscricao-de-provisoria-para-definitiva-tnd',
            'servico-inscricao-definitiva-pf-tnd',
            'servico-transferencia-pf-tnd',
            'servico-inscricao-secundaria-pf-tnd',
            'servico-prorrogacao-de-inscricao-provisoria-2',
            'servico-baixa-temporaria-2',
            'servico-cancelamento-de-inscricao-2',
            'servico-reativacao-de-inscricao-2',
            'servico-prorrogacao-de-baixa-temporaria-tnd',
            'servico-solicitacao-certidao-regularidade-tnd',
        ],
        'servicos-pessoa-juridica' => [
            'servico-anuidade-2026-pj',
            'servico-anuidade-2023-pj',
            'servico-atualizacao-de-dados',
            'servico-certidao-de-registro-de-atestado-de-capacidade-tecnica-de-pessoa-juridica',
            'servico-registro-de-documentacao-fitoterapia-pics',
            'servico-especialidades',
            'servico-responsabilidade-tecnica',
            'servico-cadastro-da-atuacao-como-autonomo',
            'servico-documentos-para-atuacao-no-pnae',
            'servico-https-crn9-org-br-servico-comunicado-de-afastamento',
            'servico-inscricao-no-crn-9-registro-e-cadastro',
            'servico-solicitacao-de-certidao',
            'servico-emissao-de-atestado-de-responsabilidade-tecnica-e-acervo-tecnico',
            'servico-cancelamento-baixa-temporaria-de-inscricao',
            'servico-prorrogacao-de-baixa-temporaria',
        ],
    ];

    public function show(Page $page)
    {
        abort_unless($page->is_published, 404);

        if (array_key_exists($page->slug, self::SERVICE_GROUPS)) {
            $slugs = self::SERVICE_GROUPS[$page->slug];
            $order = array_flip($slugs);

            $relatedPages = Page::published()
                ->whereIn('slug', $slugs)
                ->get()
                ->sortBy(fn (Page $related) => $order[$related->slug] ?? PHP_INT_MAX)
                ->values();

            return view('pages.service-index', compact('page', 'relatedPages'));
        }

        return view('pages.show', compact('page'));
    }
}
