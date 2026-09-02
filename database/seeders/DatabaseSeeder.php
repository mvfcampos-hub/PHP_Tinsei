<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Client;
use App\Models\CloudPlan;
use App\Models\EventItem;
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
    }

    private function seedPages(): void
    {
        $pages = [
            ['title' => 'Grupo Databit', 'slug' => 'grupo-databit', 'content' => '<p>Há mais de 30 anos no mercado, a Databit desenvolve tecnologia para simplificar a gestão de atacadistas, distribuidores, varejistas, locadoras e prestadores de serviço em todo o Brasil — com um ecossistema que integra ERP, Cloud, mobilidade, atendimento ao cliente e serviços de TI.</p>'],
            ['title' => 'Perguntas Frequentes', 'slug' => 'perguntas-frequentes', 'content' => '<p>Conteúdo institucional de perguntas frequentes (FAQ) a ser migrado do site atual (databit.com.br).</p>'],
            ['title' => 'Identidade Visual da Databit', 'slug' => 'identidade-visual-da-databit', 'content' => '<p>Página reservada para o manual de marca da Databit (cores, logotipo e tipografia). Conteúdo a ser recebido do cliente.</p>'],
            ['title' => 'Fale Conosco', 'slug' => 'fale-conosco', 'content' => '<p>Atendimento: <a href="mailto:atendimento@databit.com.br">atendimento@databit.com.br</a> · WhatsApp: (31) 99727-8589 · Belo Horizonte/MG.</p>'],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(['slug' => $page['slug']], $page);
        }
    }

    private function seedMenu(): void
    {
        $items = [
            ['label' => 'Início', 'url' => '/', 'sort_order' => 1],
            ['label' => 'Produtos', 'url' => '/produtos', 'sort_order' => 2],
            ['label' => 'DataCloud', 'url' => '/datacloud', 'sort_order' => 3],
            ['label' => 'Novidades', 'url' => '/novidades', 'sort_order' => 4],
            ['label' => 'Agenda', 'url' => '/agenda', 'sort_order' => 5],
            ['label' => 'Grupo Databit', 'url' => '/paginas/grupo-databit', 'sort_order' => 6],
            ['label' => 'Fale Conosco', 'url' => '/paginas/fale-conosco', 'sort_order' => 7],
        ];

        foreach ($items as $item) {
            MenuItem::firstOrCreate(['label' => $item['label']], $item);
        }
    }

    private function seedProducts(): void
    {
        $items = [
            [
                'name' => 'DataClassic',
                'category' => 'gestao',
                'tagline' => 'O sistema de gestão do seu negócio',
                'summary' => 'ERP completo para atacadistas, distribuidores, varejistas, locadoras e prestadores de serviço, com módulos para comércio, locação, prestação de serviço e outsourcing.',
                'icon' => 'heroicon-o-building-storefront',
                'external_url' => null,
                'is_featured' => true,
                'is_cloud_highlight' => false,
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
            ],
            [
                'name' => 'Serviços de TI',
                'category' => 'ti',
                'tagline' => 'Infraestrutura e suporte para a sua operação',
                'summary' => 'Consultoria, suporte técnico, equipamentos e projetos de infraestrutura de TI para manter a operação da sua empresa sempre no ar.',
                'icon' => 'heroicon-o-wrench-screwdriver',
                'external_url' => null,
                'is_featured' => false,
                'is_cloud_highlight' => false,
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
                    'description' => '<p>'.$item['summary'].'</p><p>Conteúdo completo do produto a ser migrado do site atual (databit.com.br).</p>',
                    'icon' => $item['icon'],
                    'external_url' => $item['external_url'],
                    'is_featured' => $item['is_featured'],
                    'is_cloud_highlight' => $item['is_cloud_highlight'],
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
        ];

        foreach ($items as $item) {
            News::firstOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'body' => '<p>'.$item['excerpt'].'</p><p>Conteúdo completo da novidade a ser migrado do site atual (databit.com.br).</p>',
                    'category' => $item['category'],
                    'is_featured' => $item['is_featured'],
                    'published_at' => now()->subDays(random_int(1, 60)),
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
        $this->putPlaceholderSvg('banners/hero-datamobile.svg', 1200, 500, '#1b2c6e', 'Databit · Conheça o novo DataMobile 2025');
        $this->putPlaceholderSvg('banners/hero-datacloud.svg', 1200, 500, '#0e1836', 'Databit · DataCloud, infraestrutura sob demanda');
        $this->putPlaceholderSvg('banners/campaign-30-anos.svg', 800, 400, '#2347d6', 'Databit · +30 anos de mercado');
        $this->putPlaceholderSvg('banners/campaign-datasac.svg', 800, 400, '#0891b2', 'Databit · Conheça o DataSAC');

        $items = [
            ['title' => 'Conheça o novo DataMobile 2025', 'image' => 'banners/hero-datamobile.svg', 'placement' => 'home_hero', 'sort_order' => 1],
            ['title' => 'DataCloud: infraestrutura sob demanda para o seu negócio', 'image' => 'banners/hero-datacloud.svg', 'placement' => 'home_hero', 'sort_order' => 2],
            ['title' => 'Databit — mais de 30 anos simplificando a gestão empresarial', 'image' => 'banners/campaign-30-anos.svg', 'placement' => 'home_secondary', 'sort_order' => 1],
            ['title' => 'Centralize o atendimento da sua empresa com o DataSAC', 'image' => 'banners/campaign-datasac.svg', 'placement' => 'home_secondary', 'sort_order' => 2],
        ];

        foreach ($items as $item) {
            Banner::firstOrCreate(
                ['title' => $item['title']],
                [
                    'title' => $item['title'],
                    'image' => $item['image'],
                    'placement' => $item['placement'],
                    'sort_order' => $item['sort_order'],
                    'is_active' => true,
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
                'company' => 'Mapel',
                'quote' => 'A Databit está com a gente há 6 anos. O que mais valorizamos é o atendimento próximo e uma solução robusta o suficiente para acompanhar o crescimento da operação.',
                'rating' => 5,
            ],
            [
                'client_name' => 'Equipe de Operações',
                'role' => 'Gerente de TI',
                'company' => 'Distribuidora parceira',
                'quote' => 'Migramos para o DataCloud e ganhamos previsibilidade de custo e escalabilidade sem dor de cabeça com migração de servidores.',
                'rating' => 5,
            ],
            [
                'client_name' => 'Coordenação Comercial',
                'role' => 'Coordenadora Comercial',
                'company' => 'Locadora parceira',
                'quote' => 'O DataMobile mudou a forma como nossa equipe de campo trabalha: menos retrabalho, mais visibilidade das ordens de serviço em tempo real.',
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
        $clients = ['Apnet', 'Distrivisa', 'Grupo Positiva', 'Repro MAQ', 'Reprócopia', 'Working Plus'];
        $partners = ['Microsoft', 'Dell', 'Lenovo', 'Bitdefender', 'Algar'];

        foreach ($clients as $index => $name) {
            $path = 'clients/'.Str::slug($name).'.svg';
            $this->putPlaceholderSvg($path, 240, 100, '#eef4ff', $name, '#1d38ab');

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
            $path = 'clients/'.Str::slug($name).'-parceiro.svg';
            $this->putPlaceholderSvg($path, 240, 100, '#eef4ff', $name, '#0891b2');

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
