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
    ];

    // Perguntas frequentes reais sobre os modelos de contratação e produtos
    // da Databit, estruturadas em grupos — conteúdo estruturado à parte do
    // texto livre da página, no mesmo padrão de TIMELINE/LEADERSHIP acima.
    // Alimenta tanto a página quanto o schema.org FAQPage (rich results).
    public const FAQ_GROUPS = [
        [
            'title' => 'Sobre a Databit',
            'items' => [
                ['q' => 'Quanto tempo a Databit está no mercado?', 'a' => 'A Databit atua desde 1986, com mais de 30 anos de experiência em sistemas de gestão, serviços de TI e produtos de informática para empresas de todos os portes.'],
                ['q' => 'A Databit atende empresas de qualquer porte?', 'a' => 'Sim. Atendemos desde pequenas empresas até operações de grande porte, com planos de sistemas, DataCloud e o modelo MSP dimensionados conforme o tamanho do seu ambiente.'],
                ['q' => 'A Databit atende apenas em Belo Horizonte?', 'a' => 'Nossa sede fica em Belo Horizonte/MG, mas atendemos clientes em todo o Brasil — o suporte remoto, o DataCloud e a maior parte dos serviços são prestados independentemente da localização da sua empresa.'],
            ],
        ],
        [
            'title' => 'Sistemas e implantação',
            'items' => [
                ['q' => 'O que é o DataClassic?', 'a' => 'É o ERP completo da Databit, com módulos integrados de gestão empresarial (estoque, financeiro, fiscal, compras, vendas e mais), usado por atacadistas, distribuidores, varejistas, locadoras e prestadores de serviço.'],
                ['q' => 'É possível migrar de outro sistema para o DataClassic?', 'a' => 'Sim. Nossa equipe de implantação acompanha a migração de dados e a parametrização inicial do sistema junto com a sua empresa.'],
                ['q' => 'Os módulos como DataMobile, DataSAC e DataClient CRM funcionam separados do DataClassic?', 'a' => 'Eles são vendidos como módulos independentes, mas se integram nativamente ao DataClassic — por isso o ecossistema funciona de forma conectada, sem retrabalho de digitação entre sistemas.'],
            ],
        ],
        [
            'title' => 'DataCloud',
            'items' => [
                ['q' => 'O que é o DataCloud?', 'a' => 'É o serviço de máquinas virtuais sob demanda da Databit, com Linux, Windows e SQL Server, dimensionado conforme a necessidade do seu projeto — com previsibilidade de custo em reais e suporte especializado.'],
                ['q' => 'Posso aumentar os recursos (vCPU, RAM, disco) depois de contratar?', 'a' => 'Sim. O upgrade é feito sem perda de dados, em uma janela de manutenção agendada com você — veja como funciona na Base de Conhecimento.'],
            ],
        ],
        [
            'title' => 'Databit MSP (Serviços Gerenciados)',
            'items' => [
                ['q' => 'O que está incluído no plano Databit MSP?', 'a' => 'Service desk com suporte ilimitado, monitoramento 24/7, antivírus gerenciado, gestão de rede, atualizações e patches, inventário, onboarding/offboarding, documentação, consultoria estratégica trimestral (vCIO) e relatório mensal — tudo detalhado na página do Databit MSP.'],
                ['q' => 'Qual o valor mínimo do contrato MSP?', 'a' => 'O contrato mínimo é de R$ 1.390,00/mês, equivalente a 10 workstations, e já garante o pacote completo, incluindo gestão de rede e firewall.'],
                ['q' => 'O MSP cobre atendimento fora do horário comercial?', 'a' => 'O horário de cobertura padrão é de segunda a sexta, das 8h às 17h. Atendimento emergencial fora desse horário está disponível, cobrado como hora extra.'],
            ],
        ],
        [
            'title' => 'Suporte',
            'items' => [
                ['q' => 'Como abro um chamado de suporte?', 'a' => 'Você pode abrir um chamado pelo WhatsApp (31) 99727-8589, por e-mail (atendimento@databit.com.br) ou pela Área do Cliente. Veja o passo a passo completo na Base de Conhecimento.'],
                ['q' => 'A Databit tem uma Base de Conhecimento com tutoriais?', 'a' => 'Sim — reunimos artigos, tutoriais e vídeos de apoio organizados por tipo de solução e módulo, incluindo uma IA que responde dúvidas com base nesse conteúdo.'],
            ],
        ],
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

        if ($page->slug === 'perguntas-frequentes') {
            return view('pages.faq', [
                'page' => $page,
                'faqGroups' => self::FAQ_GROUPS,
            ]);
        }

        return view('pages.show', compact('page'));
    }
}
