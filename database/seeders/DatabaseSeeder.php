<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Client;
use App\Models\CloudPlan;
use App\Models\EventItem;
use App\Models\KnowledgeArticle;
use App\Models\MenuItem;
use App\Models\News;
use App\Models\Page;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@databit.com.br'],
            [
                'name' => 'Administrador Databit',
                'password' => 'password',
                'is_admin' => true,
            ]
        );

        $this->seedPages();
        $this->seedMenu();
        $this->seedProducts();
        $this->seedCloudPlans();
        $this->seedNews($admin);
        $this->seedEvents();
        $this->seedBanners();
        $this->seedTestimonials();
        $this->seedClients();
        $this->seedKnowledgeBase();
    }

    private function seedPages(): void
    {
        $pages = [
            ['title' => 'Grupo Databit', 'slug' => 'grupo-databit', 'content' => $this->grupoDatabitContent()],
            ['title' => 'Perguntas Frequentes', 'slug' => 'perguntas-frequentes', 'content' => '<p>Reunimos aqui as dúvidas mais comuns sobre a Databit, nossos sistemas, o DataCloud, o modelo de Serviços Gerenciados (MSP) e o nosso suporte. Não encontrou o que procurava? Fale com a gente.</p>'],
            ['title' => 'Identidade Visual da Databit', 'slug' => 'identidade-visual-da-databit', 'content' => '<p>Página reservada para o manual de marca da Databit (cores, logotipo e tipografia). Conteúdo a ser recebido do cliente.</p>'],
            ['title' => 'Fale Conosco', 'slug' => 'fale-conosco', 'content' => '<p><strong>Endereço:</strong> R. Mário Campos, 197 - Inconfidência, Belo Horizonte - MG, 30820-280</p>'
                .'<p><strong>Atendimento:</strong> <a href="mailto:atendimento@databit.com.br">atendimento@databit.com.br</a></p>'
                .'<p><strong>Comercial:</strong> <a href="mailto:comercial@databit.com.br">comercial@databit.com.br</a></p>'
                .'<p><strong>Telefones:</strong> (31) 3416-8225 · WhatsApp (31) 99727-8589 / (31) 99723-0427</p>'
                .'<p><strong>Ouvidoria:</strong> <a href="mailto:relacionamento@databit.com.br">relacionamento@databit.com.br</a></p>'
                .'<p><strong>Faça parte da equipe Databit:</strong> envie seu currículo para <a href="mailto:rh@databit.com.br">rh@databit.com.br</a></p>'],
            ['title' => 'Políticas de Privacidade', 'slug' => 'politicas-de-privacidade', 'content' => $this->privacyPolicyContent()],
            ['title' => 'Políticas de Cookies', 'slug' => 'politicas-de-cookies', 'content' => $this->cookiePolicyContent()],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(['slug' => $page['slug']], $page);
        }
    }

    private function grupoDatabitContent(): string
    {
        // Linha do tempo e liderança (com fotos reais) são renderizadas à parte
        // por PageController/pages/grupo-databit.blade.php; este texto cobre
        // apenas a introdução e missão/visão/valores.
        return '<p>Há mais de 30 anos no mercado, a Databit desenvolve tecnologia para simplificar a gestão de atacadistas, distribuidores, varejistas, locadoras e prestadores de serviço em todo o Brasil — com um ecossistema que integra ERP, Cloud, mobilidade, atendimento ao cliente e serviços de TI.</p>'
            .'<h3>Missão</h3><p>Entregar soluções de tecnologia de ponta a preços competitivos, com profissionais qualificados e serviços de alta qualidade, garantindo a completa satisfação dos clientes.</p>'
            .'<h3>Visão</h3><p>Ser referência nacional em consultoria de TI e sistemas de gestão.</p>'
            .'<h3>Valores</h3><p>Ética, comprometimento, integridade, respeito, profissionalismo, valorização das pessoas, criatividade, proatividade e inovação.</p>';
    }

    private function privacyPolicyContent(): string
    {
        // Política de Privacidade própria da Databit, redigida em conformidade
        // com a LGPD (Lei nº 13.709/2018), refletindo o que este site
        // efetivamente coleta (formulários de contato e navegação) — em vez
        // de copiar o texto genérico padrão do WordPress usado no site atual.
        return '<p>A Databit Tecnologia da Informação ("Databit", "nós") respeita a sua privacidade e trata dados pessoais em conformidade com a Lei Geral de Proteção de Dados Pessoais (Lei nº 13.709/2018 – LGPD). Esta política explica quais dados coletamos neste site, para que finalidades, com quem podem ser compartilhados e quais são os seus direitos como titular.</p>'
            .'<h3>1. Quem somos</h3><p>A Databit é a controladora dos dados pessoais tratados por meio deste site. Endereço: R. Mário Campos, 197 - Inconfidência, Belo Horizonte/MG, 30820-280. Contato: <a href="mailto:atendimento@databit.com.br">atendimento@databit.com.br</a>.</p>'
            .'<h3>2. Quais dados coletamos</h3><ul>'
            .'<li>Dados informados voluntariamente em formulários do site, como nome, e-mail, telefone, empresa e mensagem, ao solicitar contato com um especialista ou preencher o formulário de "Fale Conosco";</li>'
            .'<li>Dados de navegação (como páginas visitadas) necessários ao funcionamento do site, conforme descrito em nossa <a href="'.route('pages.show', 'politicas-de-cookies').'">Política de Cookies</a>;</li>'
            .'<li>Dados fornecidos ao entrar em contato por telefone, e-mail ou WhatsApp.</li>'
            .'</ul>'
            .'<h3>3. Para que usamos os seus dados</h3><ul>'
            .'<li><strong>Atendimento comercial e suporte</strong> — para responder solicitações de contato, orçamento e suporte técnico, com base na execução de procedimentos preliminares relacionados a um possível contrato e no legítimo interesse (art. 7º, IV e IX, da LGPD);</li>'
            .'<li><strong>Comunicação sobre produtos e novidades</strong> — quando você opta por receber contato comercial, com base no seu consentimento (art. 7º, I), que pode ser revogado a qualquer momento;</li>'
            .'<li><strong>Análise de audiência do site (Google Analytics)</strong> — apenas quando você aceita o aviso de cookies, com base no seu consentimento (art. 7º, I), para entender como as páginas são utilizadas e melhorar o conteúdo;</li>'
            .'<li><strong>Cumprimento de obrigação legal ou regulatória</strong>, quando aplicável (art. 7º, II).</li>'
            .'</ul>'
            .'<h3>4. Com quem compartilhamos os seus dados</h3><p>Não vendemos dados pessoais a terceiros. Podemos compartilhar dados com prestadores de serviço que atuam em nosso nome (por exemplo, hospedagem, e-mail e atendimento via WhatsApp Business), sempre limitados ao necessário para a prestação do serviço, e com autoridades públicas quando exigido por lei ou ordem judicial.</p>'
            .'<h3>5. Por quanto tempo mantemos os seus dados</h3><p>Mantemos os dados pessoais pelo tempo necessário para cumprir as finalidades descritas nesta política, observados eventuais prazos legais de guarda de documentos fiscais e contratuais, sendo eliminados ou anonimizados posteriormente, salvo obrigação legal de retenção.</p>'
            .'<h3>6. Seus direitos como titular de dados</h3><p>Nos termos do art. 18 da LGPD, você pode solicitar a qualquer momento, mediante contato com nossa Ouvidoria:</p><ul>'
            .'<li>Confirmação da existência de tratamento e acesso aos seus dados;</li>'
            .'<li>Correção de dados incompletos, inexatos ou desatualizados;</li>'
            .'<li>Anonimização, bloqueio ou eliminação de dados desnecessários ou tratados em desconformidade com a LGPD;</li>'
            .'<li>Portabilidade dos dados a outro fornecedor de serviço ou produto;</li>'
            .'<li>Eliminação dos dados pessoais tratados com base no seu consentimento;</li>'
            .'<li>Informação sobre as entidades públicas e privadas com as quais compartilhamos seus dados;</li>'
            .'<li>Revogação do consentimento, quando essa for a base legal do tratamento.</li>'
            .'</ul><p>Para exercer esses direitos, entre em contato com a nossa Ouvidoria pelo e-mail <a href="mailto:relacionamento@databit.com.br">relacionamento@databit.com.br</a>.</p>'
            .'<h3>7. Segurança da informação</h3><p>Adotamos medidas técnicas e administrativas razoáveis para proteger os dados pessoais contra acessos não autorizados e situações acidentais ou ilícitas de destruição, perda, alteração, comunicação ou difusão.</p>'
            .'<h3>8. Cookies</h3><p>Este site utiliza cookies e tecnologias semelhantes para funcionar corretamente e melhorar a sua experiência de navegação. Saiba mais na nossa <a href="'.route('pages.show', 'politicas-de-cookies').'">Política de Cookies</a>.</p>'
            .'<h3>9. Alterações desta política</h3><p>Esta Política de Privacidade pode ser atualizada periodicamente para refletir mudanças em nossas práticas ou na legislação aplicável.</p>'
            .'<p><em>Última atualização: setembro de 2026.</em></p>';
    }

    private function cookiePolicyContent(): string
    {
        // Política de Cookies honesta em relação ao que o site realmente faz:
        // cookie de sessão do Laravel/CSRF, localStorage para lembrar avisos
        // dispensados e, apenas mediante consentimento, Google Analytics —
        // que só é carregado depois que o visitante aceita o aviso de
        // cookies (ver componente <x-cookie-consent>), nunca antes.
        return '<p>Esta Política de Cookies explica o que são cookies, quais utilizamos neste site e como você pode gerenciá-los. Para saber como tratamos dados pessoais de forma geral, consulte a nossa <a href="'.route('pages.show', 'politicas-de-privacidade').'">Política de Privacidade</a>.</p>'
            .'<h3>1. O que são cookies</h3><p>Cookies são pequenos arquivos de texto armazenados no seu navegador quando você visita um site. Eles ajudam o site a funcionar corretamente, lembrar suas preferências e entender como você interage com o conteúdo.</p>'
            .'<h3>2. Cookies que utilizamos</h3><ul>'
            .'<li><strong>Cookies necessários</strong> — essenciais para o funcionamento do site, como manter sua sessão de navegação e proteger o envio de formulários contra fraude (CSRF). Não podem ser desativados, pois o site não funciona corretamente sem eles.</li>'
            .'<li><strong>Preferências salvas localmente</strong> — usamos o armazenamento local do navegador (localStorage) para lembrar, por exemplo, quando você dispensa um aviso exibido no topo do site ou a sua escolha sobre cookies, evitando exibi-los novamente.</li>'
            .'<li><strong>Cookies de análise de audiência (Google Analytics)</strong> — usados para entender quantas pessoas visitam o site, quais páginas são mais acessadas e de onde vem o tráfego, o que nos ajuda a melhorar o conteúdo. Esses cookies só são carregados depois que você clica em "Aceitar" no aviso de cookies exibido no site; se você clicar em "Recusar", eles não são carregados. O tratamento realizado pelo Google está descrito na <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">política de privacidade do Google</a>.</li>'
            .'</ul>'
            .'<p>Não utilizamos cookies de publicidade ou de retargeting neste site.</p>'
            .'<h3>3. Como gerenciar cookies</h3><p>Você pode alterar sua escolha sobre os cookies de análise de audiência a qualquer momento limpando os dados de navegação deste site nas configurações do seu navegador, o que faz o aviso de cookies ser exibido novamente. Também é possível gerenciar, bloquear ou remover qualquer cookie diretamente nas configurações do navegador. Note que bloquear cookies necessários pode impedir o funcionamento correto de algumas áreas do site.</p>'
            .'<h3>4. Mais informações</h3><p>Para dúvidas sobre esta política ou sobre o tratamento dos seus dados pessoais, entre em contato pelo e-mail <a href="mailto:relacionamento@databit.com.br">relacionamento@databit.com.br</a>.</p>'
            .'<p><em>Última atualização: setembro de 2026.</em></p>';
    }

    private function seedMenu(): void
    {
        $items = [
            ['label' => 'Sistemas', 'url' => '/sistemas', 'sort_order' => 1],
            ['label' => 'DataCloud', 'url' => '/datacloud', 'sort_order' => 2],
            ['label' => 'Serviços TI', 'url' => '/servicos-ti', 'sort_order' => 3],
            ['label' => 'Notícias', 'url' => '/novidades', 'sort_order' => 4],
            ['label' => 'Institucional', 'url' => '/paginas/grupo-databit', 'sort_order' => 5],
        ];

        foreach ($items as $item) {
            MenuItem::firstOrCreate(['label' => $item['label']], $item);
        }

        // Agenda entra como submenu de Notícias, e Grupo Databit / Perguntas
        // Frequentes / Fale Conosco entram sob Institucional — menu principal
        // enxuto (5 itens) com o restante distribuído em dropdowns.
        $novidades = MenuItem::where('label', 'Notícias')->first();
        MenuItem::firstOrCreate(
            ['label' => 'Agenda'],
            ['label' => 'Agenda', 'url' => '/agenda', 'parent_id' => $novidades?->id, 'sort_order' => 1]
        );

        $institucional = MenuItem::where('label', 'Institucional')->first();
        $institucionalChildren = [
            ['label' => 'Grupo Databit', 'url' => '/paginas/grupo-databit', 'sort_order' => 1],
            ['label' => 'Base de Conhecimento', 'url' => '/base-de-conhecimento', 'sort_order' => 2],
            ['label' => 'Perguntas Frequentes', 'url' => '/paginas/perguntas-frequentes', 'sort_order' => 3],
            ['label' => 'Fale Conosco', 'url' => '/paginas/fale-conosco', 'sort_order' => 4],
        ];
        foreach ($institucionalChildren as $child) {
            MenuItem::firstOrCreate(
                ['label' => $child['label'], 'parent_id' => $institucional?->id],
                [...$child, 'parent_id' => $institucional?->id]
            );
        }
    }

    private function seedProducts(): void
    {
        $dataClassicModules = [
            'Gestão de Cadastros' => 'Controle de clientes, fornecedores, vendedores, serviços e produtos, com histórico completo de dados.',
            'Gestão de Compras' => 'Sugestão de compras, fluxo de aprovação, avaliação de fornecedores e auditoria de estoque.',
            'Gestão de Estoque' => 'Mapeamento de estoque, controle de inventário, organização de dados e ferramentas de análise.',
            'Gestão de Contratos' => 'Cadastro de contratos, controle de materiais, retiradas de estoque e encerramento de contrato.',
            'Gestão de Orçamentos' => 'Precificação dinâmica, formatação fiscal interestadual, orçamentos de produtos/serviços e análise de rentabilidade.',
            'Gestão Fiscal e Integração Contábil' => 'Apuração de impostos, análise de documentos fiscais, Sintegra e Sped (PIS-COFINS, ICMS-IPI).',
            'Análise Gerencial' => 'Relatórios de vendas, compras, faturamento, financeiro, fluxo de caixa e análise de resultados.',
            'Gestão de Assistência Técnica' => 'Gestão de ordens de serviço (OS), da abertura ao fechamento detalhado.',
            'Gestão de Expedição' => 'Expedição de mercadorias, controle de saída e rastreamento de entregas.',
            'Logística Reversa' => 'Controle de devoluções de peças, insumos e itens substituídos.',
            'Gestão Financeira' => 'Contas a pagar/receber, emissão de boletos, controle de crédito, fluxo de caixa e previsões.',
            'Gestão de Faturamento' => 'Emissão de notas fiscais, consulta de IE de fornecedores e ambiente de contingência.',
        ];

        $dataClassicDescription = '<p>Sistema de gestão empresarial completo, modular e de fácil operação, para atacadistas, distribuidores, varejistas, locadoras e prestadores de serviço nos segmentos de comércio, locação, prestação de serviço e outsourcing.</p>'
            .'<h3>Módulos do DataClassic</h3><ul>'
            .collect($dataClassicModules)->map(fn ($desc, $name) => "<li><strong>{$name}:</strong> {$desc}</li>")->implode('')
            .'</ul>'
            .'<p>O DataClassic também conta com conferência de estoque, gestor de documentos fiscais, coletor de série/lote, integrações de outsourcing (Printwayy, Orbix, Doc Service, IBSTracker), APIs abertas (Tray Commerce, Pluggto), emissão de etiquetas, aplicativo de XML, disparo de e-mails de OS, NFS-e e integrações com transportadoras (Correios, Mercocamp, Leolog).</p>';

        $items = [
            [
                'name' => 'DataClassic',
                'category' => 'gestao',
                'tagline' => 'O sistema de gestão do seu negócio',
                'summary' => 'ERP completo para atacadistas, distribuidores, varejistas, locadoras e prestadores de serviço, com 12 módulos integrados — de cadastros e compras a fiscal, financeiro e faturamento.',
                'description' => $dataClassicDescription,
                'icon' => 'heroicon-o-building-storefront',
                'external_url' => null,
                'is_featured' => true,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => false,
            ],
            [
                'name' => 'DataCloud',
                'category' => 'cloud',
                'tagline' => 'Máquinas virtuais sob demanda',
                'summary' => 'VMs com Linux, Windows e SQL Server, dimensionadas de acordo com a necessidade do seu projeto. Escalabilidade sem migrações complexas e suporte especializado.',
                'icon' => 'heroicon-o-cloud',
                'external_url' => null,
                'is_featured' => true,
                'is_cloud_highlight' => true,
                'is_ecosystem_node' => false,
            ],
            [
                'name' => 'DataMobile',
                'category' => 'mobile',
                'tagline' => 'O aplicativo que sua equipe técnica sempre precisou',
                'summary' => 'App para gestão de técnicos de campo: ordens de serviço, rota inteligente, assinatura em lote, controle de ponto por geolocalização e modo offline.',
                'icon' => 'heroicon-o-device-phone-mobile',
                'external_url' => 'https://databit.com.br/mobile.html',
                'is_featured' => true,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
            [
                'name' => 'DataSAC',
                'category' => 'atendimento',
                'tagline' => 'Atendimento inteligente e centralizado',
                'summary' => 'Plataforma de atendimento com automações, IA e integrações que centraliza WhatsApp, e-mail e chat em uma única caixa de entrada, com relatórios em tempo real.',
                'icon' => 'heroicon-o-chat-bubble-left-right',
                'external_url' => 'https://datasac.com.br',
                'is_featured' => true,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
            [
                'name' => 'DataMDFe',
                'category' => 'fiscal',
                'tagline' => 'Manifesto Eletrônico de Documentos Fiscais',
                'summary' => 'Emissão, gestão e monitoramento do MDF-e, vinculando NF-e e CT-e a uma única unidade de carga e simplificando as obrigações acessórias do transporte.',
                'icon' => 'heroicon-o-document-check',
                'external_url' => 'https://datamdfe.com.br',
                'is_featured' => true,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => false,
            ],
            [
                'name' => 'DataClient CRM',
                'category' => 'crm',
                'tagline' => 'Transforme cada contato em uma oportunidade real',
                'summary' => 'CRM 100% web que centraliza o pipeline comercial, automatiza follow-ups e se integra ao DataSAC e ao DataClassic para um ecossistema completo de vendas.',
                'icon' => 'heroicon-o-users',
                'external_url' => 'https://databit.com.br/DataClient.html',
                'is_featured' => false,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
            [
                'name' => 'DataWhats',
                'category' => 'comunicacao',
                'tagline' => 'WhatsApp integrado, comunicação facilitada',
                'summary' => 'Integração oficial do WhatsApp aos sistemas Databit para comunicação com clientes direto do ERP e do atendimento.',
                'icon' => 'heroicon-o-chat-bubble-oval-left-ellipsis',
                'external_url' => null,
                'is_featured' => false,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
            [
                'name' => 'DataService',
                'category' => 'integracoes',
                'tagline' => 'O DataClassic no navegador, de qualquer lugar',
                'summary' => 'Ferramenta de gestão via navegador que leva o acesso ao DataClassic para fora do escritório, sem instalação local.',
                'icon' => 'heroicon-o-globe-alt',
                'external_url' => null,
                'is_featured' => false,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
            [
                'name' => 'DataCount',
                'category' => 'integracoes',
                'tagline' => 'Contagem de estoque sem parar a operação',
                'summary' => 'Ferramenta de contagem de inventário por coletor ou aplicativo, integrada ao estoque do DataClassic.',
                'icon' => 'heroicon-o-clipboard-document-check',
                'external_url' => null,
                'is_featured' => false,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
            [
                'name' => 'DataInvoice',
                'category' => 'integracoes',
                'tagline' => 'Gestão eletrônica de notas fiscais de entrada',
                'summary' => 'Captura, conferência e lançamento automatizado de notas fiscais de entrada, reduzindo o trabalho manual da equipe fiscal.',
                'icon' => 'heroicon-o-document-duplicate',
                'external_url' => null,
                'is_featured' => false,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
            [
                'name' => 'DataShipping',
                'category' => 'integracoes',
                'tagline' => 'Expedição e rastreio integrados às transportadoras',
                'summary' => 'Integração com transportadoras parceiras para cotação, etiquetagem e rastreamento de encomendas direto do DataClassic.',
                'icon' => 'heroicon-o-truck',
                'external_url' => null,
                'is_featured' => false,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
            [
                'name' => 'DataDashboard',
                'category' => 'integracoes',
                'tagline' => 'Indicadores do seu negócio em tempo real',
                'summary' => 'Painéis gerenciais com os principais indicadores de vendas, estoque e financeiro do DataClassic, atualizados em tempo real.',
                'icon' => 'heroicon-o-chart-bar',
                'external_url' => null,
                'is_featured' => false,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
        ];

        foreach ($items as $index => $item) {
            Product::firstOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'category' => $item['category'],
                    'tagline' => $item['tagline'],
                    'summary' => $item['summary'],
                    'description' => $item['description'] ?? '<p>'.$item['summary'].'</p><p>Conteúdo completo do produto a ser migrado do site atual (databit.com.br).</p>',
                    'icon' => $item['icon'],
                    'external_url' => $item['external_url'],
                    'is_featured' => $item['is_featured'],
                    'is_cloud_highlight' => $item['is_cloud_highlight'],
                    'is_ecosystem_node' => $item['is_ecosystem_node'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedCloudPlans(): void
    {
        $items = [
            ['name' => 'START', 'price_monthly' => 89, 'vcpu' => 2, 'ram_gb' => 4, 'disk_gb' => 80, 'is_popular' => false],
            ['name' => 'PLUS', 'price_monthly' => 179, 'vcpu' => 4, 'ram_gb' => 8, 'disk_gb' => 120, 'is_popular' => false],
            ['name' => 'PRO', 'price_monthly' => 329, 'vcpu' => 6, 'ram_gb' => 16, 'disk_gb' => 200, 'is_popular' => true],
            ['name' => 'BUSINESS', 'price_monthly' => 579, 'vcpu' => 8, 'ram_gb' => 32, 'disk_gb' => 300, 'is_popular' => false],
            ['name' => 'ENTERPRISE', 'price_monthly' => 989, 'vcpu' => 12, 'ram_gb' => 64, 'disk_gb' => 400, 'is_popular' => false],
        ];

        foreach ($items as $index => $item) {
            CloudPlan::firstOrCreate(
                ['name' => $item['name']],
                [
                    'name' => $item['name'],
                    'price_monthly' => $item['price_monthly'],
                    'vcpu' => $item['vcpu'],
                    'ram_gb' => $item['ram_gb'],
                    'disk_gb' => $item['disk_gb'],
                    'description' => 'SSD NVMe · Linux, Windows ou SQL Server',
                    'is_popular' => $item['is_popular'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedNews(User $admin): void
    {
        $items = [
            [
                'title' => 'DataMobile 2025 chega com assinatura em lote, rota inteligente e novo dashboard',
                'category' => 'Lançamento',
                'is_featured' => true,
                'excerpt' => 'Nova versão do app reforça a produtividade das equipes técnicas em campo com seis novos recursos.',
            ],
            [
                'title' => 'DataCloud lança plano ENTERPRISE para operações de grande porte',
                'category' => 'Lançamento',
                'is_featured' => true,
                'excerpt' => 'Novo plano oferece até 12 vCPU, 64 GB de RAM e 400 GB SSD com o mesmo suporte especializado da Databit.',
            ],
            [
                'title' => 'DataSAC chega para centralizar o atendimento multicanal da sua empresa',
                'category' => 'Lançamento',
                'is_featured' => true,
                'excerpt' => 'Plataforma unifica WhatsApp, e-mail e chat em uma única caixa de entrada, com automações e IA.',
            ],
            [
                'title' => 'Databit lança o DataClient CRM integrado ao ecossistema DataSAC e DataClassic',
                'category' => 'Lançamento',
                'is_featured' => false,
                'excerpt' => 'Novo CRM 100% web centraliza o pipeline comercial e automatiza follow-ups da equipe de vendas.',
            ],
            [
                'title' => 'Databit celebra mais de 30 anos de mercado',
                'category' => 'Institucional',
                'is_featured' => false,
                'excerpt' => 'Trajetória é marcada pela evolução constante do ecossistema de produtos para gestão empresarial.',
            ],
            [
                'title' => 'DataMDFe simplifica a emissão do Manifesto Eletrônico para transportadoras parceiras',
                'category' => 'Novidade',
                'is_featured' => false,
                'excerpt' => 'Solução vincula NF-e e CT-e em um único documento, reduzindo o trabalho manual das equipes fiscais.',
            ],
            [
                'title' => 'Reforma Tributária: o que muda para sua empresa e como preparar seus sistemas',
                'category' => 'Reforma Tributária',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
                'excerpt' => 'Entenda as principais mudanças da Reforma Tributária (EC 132/2023) e o cronograma de transição até 2033 — e por que a atualização dos seus sistemas não pode esperar.',
                'body' => '<p>A Reforma Tributária do consumo (Emenda Constitucional nº 132/2023, regulamentada pela Lei Complementar nº 214/2025) representa a maior mudança na tributação brasileira em décadas. Para empresas de todos os portes, entender o que muda — e quando — é essencial para não ser pego de surpresa.</p>'
                    .'<h3>O que muda</h3>'
                    .'<p>Cinco tributos sobre o consumo (PIS, Cofins, IPI, ICMS e ISS) serão substituídos por um modelo de IVA dual:</p>'
                    .'<ul>'
                    .'<li><strong>CBS (Contribuição sobre Bens e Serviços)</strong> — tributo federal, substitui PIS e Cofins;</li>'
                    .'<li><strong>IBS (Imposto sobre Bens e Serviços)</strong> — tributo estadual e municipal, substitui ICMS e ISS;</li>'
                    .'<li><strong>Imposto Seletivo</strong> — incide sobre produtos prejudiciais à saúde ou ao meio ambiente.</li>'
                    .'</ul>'
                    .'<h3>Cronograma de transição</h3>'
                    .'<ul>'
                    .'<li><strong>2026:</strong> ano de teste, com alíquotas simbólicas de CBS e IBS, sem aumento de carga tributária;</li>'
                    .'<li><strong>2027:</strong> CBS entra em vigor de forma plena, substituindo PIS/Cofins; IPI é reduzido a zero para a maioria dos produtos;</li>'
                    .'<li><strong>2029 a 2032:</strong> transição gradual entre ICMS/ISS e IBS, com redução progressiva dos tributos antigos e aumento progressivo do novo;</li>'
                    .'<li><strong>2033:</strong> extinção definitiva de ICMS e ISS — modelo totalmente migrado para CBS e IBS.</li>'
                    .'</ul>'
                    .'<h3>Por que isso afeta diretamente os seus sistemas</h3>'
                    .'<p>Notas fiscais, cálculo de tributos, regras de crédito e obrigações acessórias vão mudar ao longo de toda a transição — e, durante alguns anos, empresas vão precisar operar simultaneamente com o modelo antigo e o novo. Sistemas de gestão desatualizados são o maior risco de erro fiscal nesse período.</p>'
                    .'<p>O módulo fiscal do <strong>DataClassic</strong> vem sendo atualizado para acompanhar cada etapa da transição, com o suporte da equipe Databit para orientar sua empresa em cada mudança. Fale com a gente para saber se o seu ambiente está preparado.</p>',
            ],
            [
                'title' => 'Ataques de ransomware: por que nenhuma empresa está imune',
                'category' => 'Segurança da Informação',
                'is_featured' => true,
                'published_at' => now()->subDays(6),
                'excerpt' => 'Casos de ransomware amplamente noticiados nos últimos anos mostram que o alvo não é mais só a grande corporação — é qualquer empresa com proteção insuficiente.',
                'body' => '<p>Nos últimos anos, ataques de ransomware saíram das manchetes de tecnologia para o noticiário geral. Hospitais, redes varejistas, empresas de logística e órgãos públicos ao redor do mundo já tiveram sistemas paralisados por dias — às vezes semanas — depois de um ataque bem-sucedido.</p>'
                    .'<h3>Como o ataque acontece</h3>'
                    .'<p>Na maioria dos casos noticiados, o ransomware não explora uma falha sofisticada: ele entra por um e-mail de phishing, uma senha fraca ou reutilizada, ou um acesso remoto mal protegido. Uma vez dentro da rede, o software malicioso criptografa arquivos e sistemas inteiros, exigindo pagamento de resgate para a suposta liberação dos dados — sem garantia de que o pagamento realmente resolva o problema.</p>'
                    .'<h3>Por que empresas de médio porte também são alvo</h3>'
                    .'<p>Diferente do que muitos pensam, criminosos não miram apenas grandes corporações. Empresas de médio porte costumam ter dados valiosos e defesas mais fracas — uma combinação atrativa para esse tipo de ataque. A ausência de um plano de backup testado é, na prática, o que transforma um incidente de segurança em uma paralisação de dias ou semanas.</p>'
                    .'<h3>Como reduzir o risco</h3>'
                    .'<ul>'
                    .'<li>Backup automatizado, com cópias isoladas da rede principal (offline ou imutáveis);</li>'
                    .'<li>Testes periódicos de restauração — um backup que nunca foi testado é uma falsa sensação de segurança;</li>'
                    .'<li>Antivírus/EDR gerenciado em todas as estações e servidores;</li>'
                    .'<li>Autenticação multifator (MFA) em acessos críticos;</li>'
                    .'<li>Treinamento periódico da equipe para reconhecer tentativas de phishing.</li>'
                    .'</ul>'
                    .'<p>O pacote <strong>Databit MSP</strong> inclui antivírus gerenciado e hardening de estações no plano base, com camadas adicionais de proteção disponíveis nos add-ons <strong>Security+</strong> e <strong>Backup+</strong>. Fale com a gente para avaliar o nível de proteção do seu ambiente.</p>',
            ],
            [
                'title' => 'Backup e disponibilidade: o seguro que sua empresa não pode deixar de ter',
                'category' => 'Segurança da Informação',
                'is_featured' => true,
                'published_at' => now()->subDays(10),
                'excerpt' => 'Falhas de hardware, erro humano e ataques cibernéticos têm uma coisa em comum: só não viram desastre para quem tem backup testado e um plano de disponibilidade.',
                'body' => '<p>Toda empresa depende de dados para operar — cadastros de clientes, histórico financeiro, notas fiscais, planilhas de controle. E, mais cedo ou mais tarde, todo ambiente de TI enfrenta um imprevisto: uma falha de disco, um erro humano, uma atualização malsucedida ou um ataque. A diferença entre um susto e uma crise é ter, ou não ter, um backup confiável.</p>'
                    .'<h3>Backup não é só "ter uma cópia"</h3>'
                    .'<p>Um backup só é útil se puder ser restaurado quando for preciso. Isso exige mais do que copiar arquivos periodicamente:</p>'
                    .'<ul>'
                    .'<li><strong>Regra 3-2-1:</strong> pelo menos três cópias dos dados, em dois tipos de mídia diferentes, com uma cópia fora do ambiente principal;</li>'
                    .'<li><strong>Testes de restauração periódicos</strong>, documentados — backup que nunca foi restaurado em teste é uma incógnita, não uma garantia;</li>'
                    .'<li><strong>Retenção adequada</strong>, para conseguir voltar a um ponto anterior a um ataque que pode ter ficado semanas não detectado.</li>'
                    .'</ul>'
                    .'<h3>Disponibilidade: o outro lado da mesma moeda</h3>'
                    .'<p>Backup protege os dados; disponibilidade protege a operação. Ambientes bem projetados combinam backup com monitoramento 24/7, redundância de componentes críticos e um plano de recuperação de desastres (DR) documentado — para que uma falha vire minutos de indisponibilidade, não dias.</p>'
                    .'<h3>O custo de não ter um plano</h3>'
                    .'<p>O cálculo é simples: o custo de manter backup e monitoramento é previsível e recorrente; o custo de uma parada não planejada é, quase sempre, muito maior — em produtividade perdida, em reputação e, em casos de ataque, no próprio resgate exigido.</p>'
                    .'<p>O add-on <strong>Databit Backup+</strong> oferece backup diário automatizado, testes de restauração periódicos e plano de recuperação de desastres documentado. Conheça o modelo completo de gestão de TI no <a href="/servicos-ti/msp">Databit MSP</a>.</p>',
            ],
        ];

        foreach ($items as $item) {
            News::firstOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'body' => $item['body'] ?? '<p>'.$item['excerpt'].'</p><p>Conteúdo completo da novidade a ser migrado do site atual (databit.com.br).</p>',
                    'category' => $item['category'],
                    'is_featured' => $item['is_featured'],
                    'published_at' => $item['published_at'] ?? now()->subDays(random_int(1, 60)),
                    'author_id' => $admin->id,
                ]
            );
        }
    }

    private function seedEvents(): void
    {
        $dataMobile = Product::where('slug', 'datamobile')->first();
        $dataCloud = Product::where('slug', 'datacloud')->first();
        $dataSac = Product::where('slug', 'datasac')->first();

        $items = [
            [
                'title' => 'Lançamento oficial do DataMobile 2025',
                'type' => 'lancamento',
                'location' => 'Transmissão on-line',
                'starts_at' => now()->addDays(12),
                'is_featured' => true,
                'product_id' => $dataMobile?->id,
            ],
            [
                'title' => 'Webinar: como escalar sua operação com o DataCloud',
                'type' => 'webinar',
                'location' => 'Transmissão on-line',
                'starts_at' => now()->addDays(20),
                'is_featured' => true,
                'product_id' => $dataCloud?->id,
            ],
            [
                'title' => 'Databit no Encontro Nacional de Tecnologia para Distribuidores',
                'type' => 'evento',
                'location' => 'Belo Horizonte/MG',
                'starts_at' => now()->addDays(35),
                'is_featured' => false,
                'product_id' => null,
            ],
            [
                'title' => 'Treinamento DataClassic para novos usuários',
                'type' => 'treinamento',
                'location' => 'Transmissão on-line',
                'starts_at' => now()->addDays(8),
                'is_featured' => false,
                'product_id' => null,
            ],
            [
                'title' => 'Apresentação do DataSAC para equipes de atendimento',
                'type' => 'lancamento',
                'location' => 'Transmissão on-line',
                'starts_at' => now()->addDays(5),
                'is_featured' => false,
                'product_id' => $dataSac?->id,
            ],
        ];

        foreach ($items as $item) {
            EventItem::firstOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'type' => $item['type'],
                    'description' => '<p>Descrição do compromisso a ser detalhada pela equipe de marketing da Databit.</p>',
                    'location' => $item['location'],
                    'starts_at' => $item['starts_at'],
                    'product_id' => $item['product_id'],
                    'is_featured' => $item['is_featured'],
                ]
            );
        }
    }

    private function seedBanners(): void
    {
        $this->putSeedFile('banners/databit-minasparts-da-placa-a-peca.png', 'banners/databit-minasparts-da-placa-a-peca.png');
        $this->putPlaceholderSvg('banners/hero-datamobile.svg', 1200, 500, '#1b2c6e', 'Databit · Conheça o novo DataMobile 2025');
        $this->putPlaceholderSvg('banners/hero-datacloud.svg', 1200, 500, '#0e1836', 'Databit · DataCloud, infraestrutura sob demanda');
        $this->putPlaceholderSvg('banners/campaign-30-anos.svg', 800, 400, '#2347d6', 'Databit · +30 anos de mercado');
        $this->putPlaceholderSvg('banners/campaign-datasac.svg', 800, 400, '#0891b2', 'Databit · Conheça o DataSAC');

        $items = [
            ['title' => 'Da placa à peça: DataClassic integrado à Minas Parts', 'image' => 'banners/databit-minasparts-da-placa-a-peca.png', 'placement' => 'home_hero', 'sort_order' => 1, 'link_url' => route('products.show', 'dataclassic'), 'overlay_title' => false],
            ['title' => 'Conheça o novo DataMobile 2025', 'image' => 'banners/hero-datamobile.svg', 'placement' => 'home_hero', 'sort_order' => 2],
            ['title' => 'DataCloud: infraestrutura sob demanda para o seu negócio', 'image' => 'banners/hero-datacloud.svg', 'placement' => 'home_hero', 'sort_order' => 3],
            ['title' => 'Databit — mais de 30 anos simplificando a gestão empresarial', 'image' => 'banners/campaign-30-anos.svg', 'placement' => 'home_secondary', 'sort_order' => 1],
            ['title' => 'Centralize o atendimento da sua empresa com o DataSAC', 'image' => 'banners/campaign-datasac.svg', 'placement' => 'home_secondary', 'sort_order' => 2],
        ];

        foreach ($items as $item) {
            Banner::firstOrCreate(
                ['title' => $item['title']],
                [
                    'title' => $item['title'],
                    'image' => $item['image'],
                    'link_url' => $item['link_url'] ?? null,
                    'placement' => $item['placement'],
                    'sort_order' => $item['sort_order'],
                    'is_active' => true,
                    'overlay_title' => $item['overlay_title'] ?? true,
                ]
            );
        }

        Banner::firstOrCreate(
            ['title' => 'Atendimento em horário especial no feriado — confira os canais disponíveis'],
            [
                'image' => 'banners/campaign-30-anos.svg',
                'link_url' => route('pages.show', 'fale-conosco'),
                'placement' => 'home_notice',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );
    }

    private function seedTestimonials(): void
    {
        $items = [
            [
                'client_name' => 'Diretoria Mapel',
                'role' => 'Cliente Databit há 6 anos',
                'company' => 'Mapel Soluções em Tecnologia de Impressão',
                'quote' => 'A Databit está com a gente há 6 anos. O que mais valorizamos é o atendimento próximo e uma solução robusta o suficiente para acompanhar o crescimento da operação.',
                'rating' => 5,
            ],
            [
                'client_name' => 'Equipe de Operações',
                'role' => 'Cliente Databit',
                'company' => 'Distrivisa',
                'quote' => 'Depoimento oficial a ser inserido pela equipe Databit.',
                'rating' => 5,
            ],
            [
                'client_name' => 'Equipe de Operações',
                'role' => 'Cliente Databit',
                'company' => 'Tinsei',
                'quote' => 'Depoimento oficial a ser inserido pela equipe Databit.',
                'rating' => 5,
            ],
        ];

        foreach ($items as $index => $item) {
            Testimonial::firstOrCreate(
                ['client_name' => $item['client_name'], 'company' => $item['company']],
                [
                    'client_name' => $item['client_name'],
                    'role' => $item['role'],
                    'company' => $item['company'],
                    'quote' => $item['quote'],
                    'rating' => $item['rating'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedClients(): void
    {
        $clients = ['Apnet', 'Distrivisa', 'Grupo Positiva', 'Repro MAQ', 'Reprócopia', 'Tinsei', 'Working Plus'];
        $partners = ['Microsoft', 'Dell', 'Lenovo', 'Bitdefender', 'Algar', 'Century'];

        // Logomarcas reais extraídas de databit.com.br (ver database/seeders/assets).
        $clientFiles = [
            'Apnet' => 'apnet.png',
            'Distrivisa' => 'distrivisa.jpg',
            'Grupo Positiva' => 'grupo-positiva.jpg',
            'Repro MAQ' => 'repro-maq.jpg',
            'Reprócopia' => 'reprocopia.jpg',
            'Tinsei' => 'tinsei.jpg',
            'Working Plus' => 'working-plus.jpg',
        ];
        $partnerFiles = [
            'Microsoft' => 'microsoft.webp',
            'Dell' => 'dell.jpg',
            'Lenovo' => 'lenovo.png',
            'Bitdefender' => 'bitdefender.webp',
            'Algar' => 'algar.webp',
            'Century' => 'century.jpg',
        ];

        foreach ($clients as $index => $name) {
            $file = $clientFiles[$name];
            $path = 'clients/'.$file;
            $this->putSeedFile('clients/'.$file, $path);

            Client::firstOrCreate(
                ['name' => $name, 'type' => 'cliente'],
                [
                    'name' => $name,
                    'logo' => $path,
                    'type' => 'cliente',
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        foreach ($partners as $index => $name) {
            $file = $partnerFiles[$name];
            $path = 'clients/parceiro-'.$file;
            $this->putSeedFile('partners/'.$file, $path);

            Client::firstOrCreate(
                ['name' => $name, 'type' => 'parceiro'],
                [
                    'name' => $name,
                    'logo' => $path,
                    'type' => 'parceiro',
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedKnowledgeBase(): void
    {
        $productId = fn (string $name) => Product::where('name', $name)->value('id');

        $articles = [
            [
                'title' => 'Como acessar a Área do Cliente Databit',
                'solution_type' => 'geral',
                'product_id' => null,
                'excerpt' => 'Passo a passo para entrar na Área do Cliente e consultar chamados, contratos e boletos.',
                'content' => '<p>A Área do Cliente reúne, em um só lugar, os seus chamados de suporte, contratos e informações financeiras.</p>'
                    .'<ol><li>Acesse o botão <strong>Área do Cliente</strong> no topo do site.</li>'
                    .'<li>Informe o e-mail cadastrado e a senha de acesso.</li>'
                    .'<li>Caso seja o seu primeiro acesso, utilize a opção <strong>Esqueci minha senha</strong> para criar uma senha nova.</li></ol>'
                    .'<p>Se tiver qualquer dificuldade para acessar, fale com o nosso suporte pelo WhatsApp ou e-mail.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Como abrir um chamado de suporte',
                'solution_type' => 'geral',
                'product_id' => null,
                'excerpt' => 'Os canais oficiais para abrir chamados e o que informar para agilizar o atendimento.',
                'content' => '<p>Você pode abrir um chamado de suporte pelos seguintes canais:</p>'
                    .'<ul><li>WhatsApp: (31) 99727-8589</li><li>E-mail: atendimento@databit.com.br</li><li>Telefone: (31) 3416-8225</li></ul>'
                    .'<p>Para agilizar o atendimento, informe o nome da empresa, o sistema ou serviço envolvido e uma descrição do problema, incluindo prints de tela quando possível.</p>'
                    .'<p>Clientes do plano MSP contam com SLA formal por prioridade — consulte os prazos na página do <a href="/servicos-ti/msp">Databit MSP</a>.</p>',
                'sort_order' => 2,
            ],
            [
                'title' => 'Primeiros passos no DataClassic',
                'solution_type' => 'sistemas',
                'product_id' => $productId('DataClassic'),
                'excerpt' => 'Um guia rápido para se orientar no ERP DataClassic logo no primeiro acesso.',
                'content' => '<p>Ao acessar o DataClassic pela primeira vez, recomendamos seguir esta ordem:</p>'
                    .'<ol><li>Confirme os dados cadastrais da sua empresa em <strong>Cadastros &gt; Empresa</strong>.</li>'
                    .'<li>Revise o cadastro de usuários e permissões de acesso da sua equipe.</li>'
                    .'<li>Configure os parâmetros fiscais de acordo com o regime tributário da empresa.</li>'
                    .'<li>Importe ou cadastre o catálogo inicial de produtos/serviços.</li></ol>'
                    .'<p>Nossa equipe de implantação acompanha essa etapa junto com você — qualquer dúvida, abra um chamado de suporte.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Como instalar o DataMobile no seu smartphone',
                'solution_type' => 'sistemas',
                'product_id' => $productId('DataMobile'),
                'excerpt' => 'Onde baixar o aplicativo e como conectá-lo ao seu DataClassic.',
                'content' => '<p>O DataMobile está disponível para Android e iOS.</p>'
                    .'<ol><li>Baixe o aplicativo na loja do seu aparelho.</li>'
                    .'<li>Na tela inicial, informe o código de conexão fornecido pelo administrador do sistema.</li>'
                    .'<li>Faça login com o seu usuário e senha do DataClassic.</li></ol>'
                    .'<p>Após conectado, os dados são sincronizados automaticamente com o servidor da sua empresa.</p>',
                'sort_order' => 2,
            ],
            [
                'title' => 'Como configurar um novo atendente no DataSAC',
                'solution_type' => 'sistemas',
                'product_id' => $productId('DataSAC'),
                'excerpt' => 'Passo a passo para cadastrar atendentes e definir filas de atendimento.',
                'content' => '<p>Para adicionar um novo atendente ao DataSAC:</p>'
                    .'<ol><li>Acesse <strong>Configurações &gt; Atendentes</strong>.</li>'
                    .'<li>Clique em <strong>Novo Atendente</strong> e preencha nome, e-mail e permissões.</li>'
                    .'<li>Associe o atendente às filas de atendimento correspondentes.</li></ol>'
                    .'<p>O atendente receberá um convite por e-mail para definir sua senha de acesso.</p>',
                'sort_order' => 3,
            ],
            [
                'title' => 'Como acessar sua máquina virtual no DataCloud',
                'solution_type' => 'cloud',
                'product_id' => null,
                'excerpt' => 'Formas de conexão (RDP e SSH) às VMs do seu ambiente DataCloud.',
                'content' => '<p>O acesso à sua máquina virtual DataCloud pode ser feito de duas formas, conforme o sistema operacional:</p>'
                    .'<ul><li><strong>Windows:</strong> utilize o aplicativo de Área de Trabalho Remota (RDP) com o IP e as credenciais informadas na ativação do plano.</li>'
                    .'<li><strong>Linux:</strong> conecte via SSH utilizando o IP e a chave/senha fornecidos.</li></ul>'
                    .'<p>Por segurança, o acesso é liberado apenas para os IPs previamente cadastrados. Para liberar um novo IP, abra um chamado de suporte.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Como solicitar upgrade de plano no DataCloud',
                'solution_type' => 'cloud',
                'product_id' => null,
                'excerpt' => 'Como aumentar vCPU, RAM ou disco da sua VM sem perder dados.',
                'content' => '<p>Se o seu ambiente DataCloud precisa de mais capacidade, o upgrade é feito sem perda de dados:</p>'
                    .'<ol><li>Abra um chamado informando o novo plano desejado (vCPU, RAM e disco).</li>'
                    .'<li>Nossa equipe agenda uma janela de manutenção com você.</li>'
                    .'<li>O upgrade é aplicado e a VM é reiniciada apenas uma vez, na janela combinada.</li></ol>'
                    .'<p>Consulte os planos disponíveis na página do <a href="/datacloud">DataCloud</a>.</p>',
                'sort_order' => 2,
            ],
            [
                'title' => 'Como funciona o suporte do Databit MSP',
                'solution_type' => 'servicos-ti',
                'product_id' => null,
                'excerpt' => 'Canais de abertura de chamado, horário de cobertura e como funciona o SLA por prioridade.',
                'content' => '<p>Clientes do plano Databit MSP contam com service desk ilimitado em horário comercial (segunda a sexta, 8h às 17h).</p>'
                    .'<ul><li>Abertura de chamados via WhatsApp ou e-mail;</li>'
                    .'<li>Classificação automática por prioridade (crítica, alta, média ou baixa);</li>'
                    .'<li>Atendimento emergencial fora do horário, cobrado como hora extra.</li></ul>'
                    .'<p>Veja os tempos de resposta e resolução de cada prioridade na página do <a href="/servicos-ti/msp">Databit MSP</a>.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Como escolher o notebook ideal para a sua equipe',
                'solution_type' => 'hardware',
                'product_id' => null,
                'excerpt' => 'O que considerar antes de comprar notebooks para uso corporativo.',
                'content' => '<p>Antes de comprar notebooks para a sua empresa, considere:</p>'
                    .'<ul><li><strong>Perfil de uso:</strong> tarefas de escritório exigem menos do que uso com sistemas de gestão, planilhas pesadas ou design.</li>'
                    .'<li><strong>Memória RAM:</strong> recomendamos ao menos 8 GB para uso corporativo com múltiplos sistemas abertos.</li>'
                    .'<li><strong>Armazenamento:</strong> priorize SSD, que é significativamente mais rápido que HD tradicional.</li>'
                    .'<li><strong>Garantia e suporte:</strong> equipamentos corporativos com garantia on-site reduzem o tempo de parada.</li></ul>'
                    .'<p>Nossa equipe ajuda a dimensionar o equipamento certo para cada perfil — fale com um especialista na página de <a href="/produtos">Produtos de informática</a>.</p>',
                'sort_order' => 2,
            ],
        ];

        foreach ($articles as $article) {
            KnowledgeArticle::firstOrCreate(
                ['slug' => Str::slug($article['title'])],
                [...$article, 'slug' => Str::slug($article['title']), 'is_published' => true]
            );
        }
    }

    private function putSeedFile(string $assetPath, string $publicPath): void
    {
        if (Storage::disk('public')->exists($publicPath)) {
            return;
        }

        $source = __DIR__.'/assets/'.$assetPath;

        if (! is_file($source)) {
            return;
        }

        Storage::disk('public')->put($publicPath, file_get_contents($source));
    }

    private function putPlaceholderSvg(string $path, int $width, int $height, string $background, string $label, string $textColor = '#ffffff', ?int $fontSize = null): void
    {
        if (Storage::disk('public')->exists($path)) {
            return;
        }

        $fontSize ??= (int) max(12, min($height * 0.34, ($width * 1.7) / max(mb_strlen($label), 4)));

        Storage::disk('public')->put(
            $path,
            "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"{$width}\" height=\"{$height}\" viewBox=\"0 0 {$width} {$height}\">"
            ."<rect width=\"{$width}\" height=\"{$height}\" fill=\"{$background}\"/>"
            ."<text x=\"50%\" y=\"50%\" font-family=\"sans-serif\" font-weight=\"700\" font-size=\"{$fontSize}\" fill=\"{$textColor}\" text-anchor=\"middle\" dominant-baseline=\"middle\">"
            .htmlspecialchars($label, ENT_QUOTES, 'UTF-8').'</text></svg>'
        );
    }
}
