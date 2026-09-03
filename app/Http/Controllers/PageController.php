<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    // Linha do tempo e liderança da Databit (databit.com.br/grupo-databit/),
    // com fotos reais da equipe — conteúdo estruturado à parte do texto livre
    // da página, no mesmo padrão usado para Cloud, Serviços de TI e Produtos.
    public const TIMELINE = [
        ['year' => '1986', 'text' => 'Fundação da Databit por Roger Martins e Andreia Formaggini, com foco em manutenção de equipamentos de informática.'],
        ['year' => '1998', 'text' => 'Expansão para a venda de equipamentos de informática e periféricos.'],
        ['year' => '2001', 'text' => 'Marcos Campos assume a direção e amplia a atuação para consultoria de TI e suporte a projetos.'],
        ['year' => '2005', 'text' => 'Sidney Sanches se junta à liderança e inicia o desenvolvimento do ERP próprio da Databit.'],
        ['year' => '2006', 'text' => 'Lançamento da Dinâmica Computer, para produtos de tecnologia e projetos de infraestrutura.'],
        ['year' => '2008', 'text' => 'Lançamento do ERP DataClassic.'],
        ['year' => '2010', 'text' => 'Lançamento do DataService, ferramenta de gestão via navegador.'],
        ['year' => '2014', 'text' => 'Lançamento do DataMobile.'],
        ['year' => '2018', 'text' => 'Bruno Espindola se junta à liderança como diretor especialista em TI.'],
        ['year' => '2022', 'text' => 'Lançamento do DataWhats.'],
        ['year' => '2023', 'text' => 'Lançamento do DataShipping e do DataInvoice.'],
        ['year' => '2024', 'text' => 'Lançamento do DataClient CRM.'],
    ];

    public const LEADERSHIP = [
        ['name' => 'Roger Martins', 'role' => 'CEO', 'photo' => 'roger-martins.jpg'],
        ['name' => 'Marcos Campos', 'role' => 'COO', 'photo' => 'marcos-campos.jpg'],
        ['name' => 'Sidney Sanches', 'role' => 'CTO', 'photo' => 'sidney-sanches.png'],
        ['name' => 'Andreia Formaggini', 'role' => 'Diretora Financeira', 'photo' => 'andreia-formaggini.jpg'],
        ['name' => 'Fabiano Oliveira', 'role' => 'Gerente de Sistemas', 'photo' => 'fabiano-oliveira.jpg'],
        ['name' => 'Fabricio Alcantara', 'role' => 'Gerente de Soluções Integradas', 'photo' => 'fabricio-alcantara.jpg'],
        ['name' => 'Gisele Fernandes', 'role' => 'Relacionamento com o Cliente', 'photo' => 'gisele-fernandes.jpg'],
        ['name' => 'Bruno Espindola', 'role' => 'Diretor Especialista em TI', 'photo' => null],
    ];

    public function show(Page $page)
    {
        abort_unless($page->is_published, 404);

        if ($page->slug === 'grupo-databit') {
            return view('pages.grupo-databit', [
                'page' => $page,
                'timeline' => self::TIMELINE,
                'leadership' => self::LEADERSHIP,
            ]);
        }

        return view('pages.show', compact('page'));
    }
}
