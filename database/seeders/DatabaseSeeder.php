<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\EventItem;
use App\Models\Inspector;
use App\Models\JobListing;
use App\Models\Magazine;
use App\Models\MenuItem;
use App\Models\MunicipalityProfessionalCount;
use App\Models\News;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@crn9.org.br'],
            [
                'name' => 'Administrador CRN-9',
                'password' => 'password',
                'is_admin' => true,
            ]
        );

        $this->seedPages();
        $this->seedMenu();
        $this->seedNews($admin);
        $this->seedEvents();
        $this->seedBanners();
        $this->seedJobs();
        $this->seedMagazines();
        $this->seedInspectors();
        $this->seedMunicipalityCounts();
    }

    private function seedPages(): void
    {
        $pages = [
            ['title' => 'O CRN-9', 'slug' => 'o-crn-9', 'content' => '<p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) é o órgão responsável por orientar, disciplinar e fiscalizar o exercício da profissão de nutricionista em sua área de abrangência.</p>'],
            ['title' => 'Perguntas Frequentes', 'slug' => 'perguntas-frequentes', 'content' => '<p>Conteúdo institucional de perguntas frequentes (FAQ) a ser migrado do site atual.</p>'],
            ['title' => 'Identidade Visual do CRN-9', 'slug' => 'identidade-visual-do-crn-9', 'content' => '<p>Página reservada para o manual de marca do CRN-9 (cores, logotipo e tipografia). Conteúdo a ser recebido do cliente.</p>'],
            ['title' => 'Fale Conosco', 'slug' => 'fale-conosco', 'content' => '<p>Canais de atendimento e formulário de contato institucional.</p>'],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(['slug' => $page['slug']], $page);
        }
    }

    private function seedMenu(): void
    {
        $items = [
            ['label' => 'Início', 'url' => '/', 'sort_order' => 1],
            ['label' => 'O CRN-9', 'url' => '/paginas/o-crn-9', 'sort_order' => 2],
            ['label' => 'Notícias', 'url' => '/noticias', 'sort_order' => 3],
            ['label' => 'Agenda', 'url' => '/agenda', 'sort_order' => 4],
            ['label' => 'Banco de Oportunidades', 'url' => '/vagas', 'sort_order' => 5],
            ['label' => 'Revista CRN-9', 'url' => '/revistas', 'sort_order' => 6],
            ['label' => 'Fiscalização', 'url' => '/fiscalizacao', 'sort_order' => 7],
            ['label' => 'Profissionais por Município', 'url' => '/profissionais-por-municipio', 'sort_order' => 8],
            ['label' => 'Fale Conosco', 'url' => '/paginas/fale-conosco', 'sort_order' => 9],
        ];

        foreach ($items as $item) {
            MenuItem::firstOrCreate(['label' => $item['label']], $item);
        }
    }

    private function seedNews(User $admin): void
    {
        $items = [
            [
                'title' => 'Diretoria do CRN-9 é reeleita para o pleito 2025-2026',
                'category' => 'Institucional',
                'is_featured' => true,
                'excerpt' => 'Chapa única é eleita para conduzir o conselho no próximo biênio.',
            ],
            [
                'title' => 'Fiscalização do CRN-9 continua atuante em todo o estado',
                'category' => 'Fiscalização',
                'is_featured' => true,
                'excerpt' => 'Equipe de fiscais reforça ações de orientação e fiscalização presencial e remota.',
            ],
            [
                'title' => 'CRN-9 participa de fórum e reunião conjunta do CFN',
                'category' => 'Institucional',
                'is_featured' => false,
                'excerpt' => 'Representantes do conselho regional discutem pautas nacionais da profissão.',
            ],
            [
                'title' => 'Inscrições abertas para o Dia do Nutricionista 2026',
                'category' => 'Eventos',
                'is_featured' => false,
                'excerpt' => 'Evento reunirá profissionais para celebrar a data com palestras e homenagens.',
            ],
        ];

        foreach ($items as $item) {
            News::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'body' => '<p>Conteúdo completo da notícia a ser migrado do site atual (crn9.org.br).</p>',
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
        $items = [
            ['title' => 'Dia do Nutricionista 2026', 'location' => 'Belo Horizonte/MG', 'starts_at' => now()->addDays(45), 'is_featured' => true],
            ['title' => 'A Fiscalização do CRN-9 mais perto de você', 'location' => 'Regional Sul de Minas', 'starts_at' => now()->addDays(20), 'is_featured' => false],
            ['title' => 'Plantão de Orientação Ética On-line', 'location' => 'Transmissão on-line', 'starts_at' => now()->addDays(10), 'is_featured' => false],
        ];

        foreach ($items as $item) {
            EventItem::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'description' => '<p>Descrição do evento a ser detalhada pela equipe de comunicação do CRN-9.</p>',
                    'location' => $item['location'],
                    'starts_at' => $item['starts_at'],
                    'is_featured' => $item['is_featured'],
                ]
            );
        }
    }

    private function seedBanners(): void
    {
        if (! Storage::disk('public')->exists('banners/placeholder.svg')) {
            Storage::disk('public')->put(
                'banners/placeholder.svg',
                '<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="400" viewBox="0 0 1200 400">'
                .'<rect width="1200" height="400" fill="#0f766e"/>'
                .'<text x="50%" y="50%" font-family="sans-serif" font-size="42" fill="#ffffff" text-anchor="middle" dominant-baseline="middle">'
                .'CRN-9 &#183; Banner de campanha</text></svg>'
            );
        }

        $items = [
            ['title' => 'Campanha Dia do Nutricionista', 'placement' => 'home_hero', 'sort_order' => 1],
            ['title' => 'Renovação de inscrição 2026', 'placement' => 'home_hero', 'sort_order' => 2],
            ['title' => 'Denúncias e fiscalização', 'placement' => 'home_secondary', 'sort_order' => 1],
        ];

        foreach ($items as $item) {
            Banner::firstOrCreate(
                ['title' => $item['title']],
                [
                    'title' => $item['title'],
                    'image' => 'banners/placeholder.svg',
                    'placement' => $item['placement'],
                    'sort_order' => $item['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedJobs(): void
    {
        $items = [
            ['title' => 'Nutricionista Clínico - Hospital Regional', 'company' => 'Hospital Regional', 'location' => 'Belo Horizonte/MG', 'contract_type' => 'CLT'],
            ['title' => 'Nutricionista para Unidade Básica de Saúde', 'company' => 'Prefeitura Municipal', 'location' => 'Uberlândia/MG', 'contract_type' => 'Concurso Público'],
        ];

        foreach ($items as $item) {
            JobListing::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'company' => $item['company'],
                    'description' => 'Descrição completa da vaga a ser fornecida pelo contratante.',
                    'location' => $item['location'],
                    'contract_type' => $item['contract_type'],
                    'published_at' => now()->subDays(random_int(1, 10)),
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedMagazines(): void
    {
        for ($year = now()->year; $year >= now()->year - 2; $year--) {
            Magazine::firstOrCreate(
                ['title' => "Revista CRN-9 {$year}", 'year' => $year],
                [
                    'title' => "Revista CRN-9 {$year}",
                    'edition' => "Edição {$year}",
                    'year' => $year,
                    'published_at' => now()->setYear($year)->startOfYear(),
                ]
            );
        }
    }

    private function seedInspectors(): void
    {
        $items = [
            ['name' => 'Ana Paula Silveira', 'role' => 'Coordenadora de Fiscalização', 'region' => 'Regional Belo Horizonte'],
            ['name' => 'Carlos Eduardo Souza', 'role' => 'Fiscal', 'region' => 'Regional Sul de Minas'],
            ['name' => 'Fernanda Lima Costa', 'role' => 'Fiscal', 'region' => 'Regional Triângulo Mineiro'],
        ];

        foreach ($items as $index => $item) {
            Inspector::firstOrCreate(
                ['name' => $item['name']],
                [
                    'name' => $item['name'],
                    'role' => $item['role'],
                    'region' => $item['region'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedMunicipalityCounts(): void
    {
        $items = [
            ['municipality' => 'Belo Horizonte', 'category' => 'Nutricionista', 'professionals_count' => 3200],
            ['municipality' => 'Uberlândia', 'category' => 'Nutricionista', 'professionals_count' => 540],
            ['municipality' => 'Juiz de Fora', 'category' => 'Nutricionista', 'professionals_count' => 410],
            ['municipality' => 'Contagem', 'category' => 'Nutricionista', 'professionals_count' => 280],
        ];

        foreach ($items as $item) {
            MunicipalityProfessionalCount::firstOrCreate(
                ['municipality' => $item['municipality'], 'state' => 'MG', 'category' => $item['category']],
                [
                    'municipality' => $item['municipality'],
                    'state' => 'MG',
                    'category' => $item['category'],
                    'professionals_count' => $item['professionals_count'],
                    'reference_date' => now(),
                ]
            );
        }
    }
}
