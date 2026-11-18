<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\EventItem;
use App\Models\MenuItem;
use App\Models\News;
use App\Models\Page;
use App\Models\Partner;
use App\Models\PortfolioCategory;
use App\Models\SiteSetting;
use App\Models\StateClientCount;
use App\Models\Testimonial;
use App\Models\TimelineEvent;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Conteúdo inicial do site da Tinsei, levantado no site atual
 * (tinsei.com.br), na loja B2B (loja.tinsei.com.br), no canal do YouTube,
 * em perfis públicos e nos dados enviados pela Tinsei. Tudo é editável no
 * painel (/admin). Itens marcados "A CONFIRMAR" dependem de validação da Tinsei.
 *
 * Idempotente: pode ser rodado de novo sem duplicar registros.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@tinsei.com.br')],
            ['name' => 'Administrador Tinsei', 'password' => env('ADMIN_PASSWORD', 'troque-esta-senha'), 'is_admin' => true]
        );

        SiteSetting::current();

        $this->seedPages();
        $this->seedMenu();
        $this->seedStateClients();
        $this->seedPortfolio();
        $this->seedBrands();
        $this->seedTimeline();
        $this->seedPartners();
        $this->seedNews($admin);
        $this->seedEvents();
        $this->seedTestimonials();
        $this->seedBanners();
    }

    /**
     * Copia uma imagem de public/images/site para o disco "public" (uploads do
     * painel), para que possa ser trocada normalmente pelo Filament.
     */
    private function media(string $file, string $directory): string
    {
        $target = $directory.'/'.$file;

        if (! Storage::disk('public')->exists($target)) {
            Storage::disk('public')->put($target, file_get_contents(public_path('images/site/'.$file)));
        }

        return $target;
    }

    private function seedStateClients(): void
    {
        // Clientes ativos por UF informados pela Tinsei (EX = exterior).
        $counts = [
            'PE' => 79, 'PB' => 19, 'PA' => 26, 'RS' => 157, 'AC' => 3, 'BA' => 88, 'SP' => 563,
            'SC' => 95, 'SE' => 25, 'MA' => 28, 'TO' => 42, 'RO' => 9, 'DF' => 87, 'MT' => 22,
            'EX' => 11, 'PR' => 141, 'CE' => 88, 'AL' => 17, 'RR' => 2, 'MG' => 1254, 'MS' => 8,
            'GO' => 64, 'RN' => 28, 'AP' => 7, 'RJ' => 220, 'ES' => 118, 'PI' => 18, 'AM' => 10,
        ];

        foreach ($counts as $code => $count) {
            StateClientCount::updateOrCreate(
                ['code' => $code],
                ['name' => StateClientCount::options()[$code], 'client_count' => $count, 'is_active' => true]
            );
        }
    }

    private function seedPortfolio(): void
    {
        $store = SiteSetting::DEFAULTS['store_url'];

        $categories = [
            [
                'name' => 'Equipamentos Novos', 'slug' => 'equipamentos-novos', 'icon' => 'printer',
                'image' => $this->media('atuacao-1.png', 'portfolio'),
                'tagline' => 'Multifuncionais e impressoras de produção, com garantia e procedência.',
                'description' => 'Equipamentos novos para escritório e produção gráfica, com a curadoria de quem conhece o mercado de impressão. Linhas como a Xerox AltaLink C8130 chegam com kit inicial de suprimentos e suporte da equipe técnica Tinsei para a sua revenda.',
                'highlights' => ['Multifuncionais A3 e A4, cor e monocromáticas', 'Kit inicial de suprimentos para o primeiro uso', 'Equipamentos de escritório e de produção', 'Suporte comercial e técnico à revenda'],
            ],
            [
                'name' => 'Equipamentos Recon', 'slug' => 'equipamentos-recon', 'icon' => 'recycle',
                'image' => $this->media('atuacao-3.png', 'portfolio'),
                'tagline' => 'Recondicionados com padrão de fábrica — inclusive Xerox, com aval do fabricante.',
                'description' => 'A Tinsei é a maior importadora e distribuidora de equipamentos A3 a laser do Brasil. Cada equipamento recondicionado passa por revisão técnica, troca de componentes e testes antes de voltar ao mercado — mais desempenho por real investido e menos lixo eletrônico.',
                'highlights' => ['Equipamentos A3 a laser de médio e grande porte', 'Recondicionamento autorizado Xerox (Brasil e México)', 'Ex.: Xerox C70 recondicionada com aval do fabricante', 'Excelente custo por página para locação e outsourcing'],
            ],
            [
                'name' => 'Suprimentos', 'slug' => 'suprimentos', 'icon' => 'droplet',
                'image' => $this->media('produto-04255.jpg', 'portfolio'),
                'tagline' => 'Toners, cartuchos e suprimentos para as principais marcas.',
                'description' => 'Suprimentos originais e de alto rendimento para Xerox, Ricoh, Konica Minolta, Canon, Samsung e outras marcas — além da linha produzida pela indústria montadora da Tinsei, desenvolvida para ambientes exigentes como exames médicos de imagem, materiais publicitários e indústria gráfica.',
                'highlights' => ['Toners originais e de alto rendimento', 'Indústria montadora própria de suprimentos', 'Busca por código, referência ou modelo do equipamento', 'Estoque para pronta entrega'],
            ],
            [
                'name' => 'Peças', 'slug' => 'pecas', 'icon' => 'cog',
                'image' => $this->media('atuacao-2.png', 'portfolio'),
                'tagline' => 'Peças de reposição para manter o parque de máquinas rodando.',
                'description' => 'Peças e componentes para manutenção de equipamentos de impressão de médio e grande porte, com a experiência técnica de quem recondiciona equipamentos todos os dias.',
                'highlights' => ['Peças para equipamentos de médio e grande porte', 'Filtro por fabricante e modelo na loja', 'Apoio técnico na identificação da peça', 'Envio para todo o Brasil'],
            ],
        ];

        foreach ($categories as $i => $category) {
            PortfolioCategory::updateOrCreate(['slug' => $category['slug']], $category + [
                'store_url' => $store.'filter',
                'is_active' => true,
                'sort_order' => $i,
            ]);
        }
    }

    private function seedBrands(): void
    {
        // Marcas presentes no portfólio da loja (nomes em texto; logotipos
        // só devem ser enviados no painel com autorização de uso).
        $brands = [
            ['Xerox', 'Recondicionamento autorizado'],
            ['Ricoh', null],
            ['Konica Minolta', null],
            ['Canon', null],
            ['Samsung', null],
        ];

        foreach ($brands as $i => [$name, $note]) {
            Brand::updateOrCreate(['name' => $name], ['note' => $note, 'is_active' => true, 'sort_order' => $i]);
        }
    }

    private function seedTimeline(): void
    {
        $items = [
            ['2011', 'Nasce a Tinsei, em Belo Horizonte', 'Bernard Martins Braga funda a Tinsei com foco na importação direta e na comercialização de copiadoras, multifuncionais e impressoras para empresas de todo o Brasil.', null],
            ['2013', 'Rafael Couto Guimarães chega à sociedade', 'Advogado e especialista em finanças corporativas, Rafael se torna sócio-administrador e reforça a gestão, a governança e a estratégia de crescimento da empresa.', null],
            ['Expansão', 'Liderança nacional em A3 a laser', 'A Tinsei se torna a maior importadora e distribuidora de equipamentos A3 a laser do Brasil, à frente dos fabricantes tradicionais do segmento.', 'Nº 1 em A3 a laser no Brasil'],
            ['Indústria', 'Indústria montadora de suprimentos', 'Início da montagem de cartuchos, suprimentos e peças de alta qualidade para aplicações exigentes: exames médicos de imagem, materiais publicitários e indústria gráfica.', null],
            ['ESG', 'Recondicionamento autorizado Xerox', 'Apoiada em padrões ESG, a Xerox elege a Tinsei como indústria de recondicionamento dos seus equipamentos no Brasil e no México.', 'Brasil e México'],
            ['2024', 'A Tinsei no YouTube', 'Lançamento do vídeo institucional e de uma série técnica sobre a Xerox C70 e a AltaLink C8130, para apoiar as revendas na venda consultiva.', null],
            ['2025', 'Destaque na Revista PEGN', 'A trajetória do fundador e o crescimento da maior importadora de equipamentos de impressão usados do Brasil ganham reportagem na Pequenas Empresas & Grandes Negócios.', null],
            ['Hoje', 'Presente em todo o Brasil', 'Clientes ativos em todas as unidades da federação e no exterior, mais de 1.800 itens no portfólio, e-commerce B2B para revendas e mais de 1.800.000 kg de lixo eletrônico recuperados.', '3.230 clientes ativos'],
        ];

        foreach ($items as $i => [$year, $title, $description, $highlight]) {
            TimelineEvent::updateOrCreate(['title' => $title], [
                'year_label' => $year, 'description' => $description, 'highlight' => $highlight,
                'is_active' => true, 'sort_order' => $i,
            ]);
        }
    }

    private function seedPartners(): void
    {
        Partner::updateOrCreate(['name' => 'Bernard Martins Braga'], [
            'role' => 'Fundador e Sócio-Administrador',
            'since_label' => '2011',
            'summary' => 'Fundou a Tinsei em 2011 e conduziu a empresa à liderança nacional na importação e distribuição de equipamentos A3 a laser. O espírito competitivo que marca sua trajetória — tema de reportagem da Revista PEGN em 2025 — é um dos motores do crescimento da Tinsei.',
            'bio' => '<p>Empreendedor à frente da Tinsei desde a fundação, Bernard construiu uma operação de importação, recondicionamento e distribuição que atende revendas em todo o Brasil e se tornou parceira da Xerox no recondicionamento de equipamentos no Brasil e no México.</p><p>Sua visão combina competitividade, eficiência e sustentabilidade: dar uma nova vida útil a equipamentos de alto padrão, com qualidade de fábrica e preço competitivo para o revendedor.</p>',
            'highlights' => ['Fundador da Tinsei (2011)', 'Liderança nacional em equipamentos A3 a laser', 'Parceria de recondicionamento com a Xerox', 'Destaque na Revista PEGN (2025)'],
            'is_active' => true,
            'sort_order' => 0,
        ]);

        Partner::updateOrCreate(['name' => 'Rafael Couto Guimarães'], [
            'role' => 'Sócio-Administrador',
            'since_label' => '2013',
            'summary' => 'Advogado e especialista em finanças corporativas, foi CEO da Hortigil Hortifruti e Diretor-Presidente da Trop Frutas do Brasil, empresa adquirida pelo grupo Coca-Cola. Liderou diversas operações de M&A e uma sociedade de investimentos em private equity e venture capital.',
            'bio' => '<p>Formado em Direito pela UFMG, com mestrado em Direito Empresarial pela Université de Paris I – Panthéon-Sorbonne e MBA em Finanças pelo Ibmec, Rafael atuou por anos em escritórios de advocacia de Minas Gerais, com foco em Direito Societário e contratos, e lecionou Direito Societário, Direito Falimentar e inglês.</p><p>Na Tinsei, soma experiência em gestão, governança e estruturação de negócios ao crescimento da empresa.</p>',
            'highlights' => ['Direito — UFMG', 'Mestrado em Direito Empresarial — Paris I Panthéon-Sorbonne', 'MBA em Finanças — Ibmec', 'Ex-CEO da Hortigil Hortifruti', 'Ex-Diretor-Presidente da Trop Frutas do Brasil', 'M&A, private equity e venture capital'],
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }

    private function seedNews(User $admin): void
    {
        $items = [
            [
                'title' => 'Tinsei alcança 3.230 clientes ativos em todas as regiões do Brasil',
                'slug' => 'tinsei-alcanca-3230-clientes-ativos',
                'cover_image' => $this->media('sede-tinsei.jpg', 'news'),
                'category' => 'Institucional', 'is_featured' => true,
                'published_at' => '2026-11-17 09:00:00',
                'excerpt' => 'De Belo Horizonte para todos os estados e o Distrito Federal — e também para o exterior: a base de clientes ativos da Tinsei mostra a força da distribuição nacional.',
                'body' => '<p>A Tinsei chegou a <strong>3.230 clientes ativos</strong>, com presença em todas as unidades da federação e também fora do país. Minas Gerais, berço da empresa, concentra a maior base, seguida por São Paulo, Rio de Janeiro, Rio Grande do Sul e Paraná.</p><p>O resultado reflete a combinação que guia a Tinsei desde a fundação: <strong>qualidade, confiança e preço competitivo</strong>, com uma operação logística preparada para atender revendas, locadoras e empresas de outsourcing de impressão de norte a sul.</p><p>Veja o mapa completo na página <a href="/onde-estamos">Onde estamos</a>.</p>',
            ],
            [
                'title' => 'E-Commerce Tinsei ES®: o portfólio completo on-line para a sua revenda',
                'slug' => 'e-commerce-tinsei-es-portfolio-online',
                'cover_image' => $this->media('produto-03767.jpg', 'news'),
                'category' => 'Lançamentos', 'is_featured' => true,
                'published_at' => '2026-11-12 09:00:00',
                'excerpt' => 'Mais de 1.800 itens com busca por código, referência, nome, fabricante e modelo do equipamento. Revendas cadastradas acessam preços e montam o pedido on-line.',
                'body' => '<p>A loja B2B da Tinsei reúne <strong>equipamentos novos, equipamentos recondicionados, suprimentos e peças</strong> em um só lugar. A busca funciona do jeito que o revendedor trabalha: por código, referência ou nome do produto, ou filtrando por fabricante, modelo, categoria e subcategoria.</p><ul><li>Mais de 1.800 itens no portfólio;</li><li>Preços exclusivos para revendas cadastradas;</li><li>Pedido on-line, com atendimento da equipe comercial.</li></ul><p><a href="https://loja.tinsei.com.br/">Acesse a loja</a> ou <a href="https://loja.tinsei.com.br/revendedor">cadastre a sua revenda</a>.</p>',
            ],
            [
                'title' => 'Mais de 1.800.000 kg de lixo eletrônico recuperados',
                'slug' => 'mais-de-1800000-kg-de-lixo-eletronico-recuperados',
                'cover_image' => $this->media('atuacao-1.png', 'news'),
                'category' => 'Sustentabilidade',
                'published_at' => '2026-11-05 09:00:00',
                'excerpt' => 'O recondicionamento de equipamentos de impressão de alto padrão é o centro do compromisso da Tinsei com a economia circular.',
                'body' => '<p>Cada equipamento recondicionado pela Tinsei volta ao mercado com desempenho e segurança — e deixa de virar descarte. Somadas, essas operações já representam <strong>mais de 1.800.000 quilos de lixo eletrônico recuperados</strong>.</p><p>Para a revenda, o recondicionamento significa um equipamento de alto padrão com excelente custo-benefício. Para o planeta, significa menos extração de matéria-prima, menos energia na fabricação e menos resíduos. Saiba mais em <a href="/sustentabilidade">Sustentabilidade</a>.</p>',
            ],
            [
                'title' => 'Tinsei é a indústria de recondicionamento da Xerox no Brasil e no México',
                'slug' => 'tinsei-recondicionamento-xerox-brasil-mexico',
                'cover_image' => $this->media('atuacao-3.png', 'news'),
                'category' => 'Institucional',
                'published_at' => '2026-10-28 09:00:00',
                'excerpt' => 'Apoiada nos padrões de sustentabilidade do sistema ESG, a Xerox escolheu a Tinsei para recondicionar seus equipamentos em dois países.',
                'body' => '<p>Em busca de levar ao mercado equipamentos de alta qualidade, apoiados nos padrões de sustentabilidade estabelecidos pelo sistema ESG, a <strong>Xerox elegeu a Tinsei como indústria de recondicionamento de seus equipamentos no Brasil e no México</strong>.</p><p>Na prática, isso significa equipamentos recondicionados com aval do fabricante — como a Xerox C70 — disponíveis para revendas de todo o país, com a confiança de uma marca global e o atendimento próximo da Tinsei.</p>',
            ],
            [
                'title' => 'Na mídia: a trajetória da Tinsei na Revista PEGN',
                'slug' => 'tinsei-na-revista-pegn',
                'category' => 'Na Mídia', 'is_featured' => true,
                'published_at' => '2025-05-20 09:00:00',
                'video_url' => 'https://www.youtube.com/shorts/oglzsMGgK8M',
                'source_name' => 'Revista Pequenas Empresas & Grandes Negócios',
                'source_url' => 'https://revistapegn.globo.com/conteudo-de-marca/historias-que-inspiram/noticia/2025/05/espirito-competitivo-do-dono-deu-impulso-a-maior-importadora-de-equipamentos-de-impressao-usados-no-brasil.ghtml',
                'excerpt' => 'Reportagem da série "Histórias que inspiram" mostra como o espírito competitivo do fundador impulsionou a maior importadora de equipamentos de impressão usados do Brasil.',
                'body' => '<p>Em maio de 2025, a Revista Pequenas Empresas & Grandes Negócios contou a história da Tinsei e de seu fundador, Bernard Martins Braga, na série "Histórias que inspiram". A reportagem relaciona o espírito competitivo do empresário ao crescimento da empresa, hoje a maior importadora de equipamentos de impressão usados do país.</p><p>Leia a matéria completa no site da revista pelo link abaixo.</p>',
            ],
            [
                'title' => 'Xerox C70 x AltaLink C8130: qual equipamento atende melhor o seu cliente?',
                'slug' => 'comparativo-xerox-c70-altalink-c8130',
                'category' => 'Equipamentos',
                'published_at' => '2024-12-16 09:00:00',
                'video_url' => 'https://www.youtube.com/watch?v=bAtPAjnjuec',
                'excerpt' => 'Comparativo técnico em vídeo, posicionamento de mercado e o kit inicial de suprimentos de cada modelo.',
                'body' => '<p>Os dois equipamentos são excelentes — mas atendem perfis diferentes. Na série de vídeos do canal da Tinsei, a equipe técnica compara a <strong>Xerox C70</strong> e a <strong>Xerox AltaLink C8130</strong> para ajudar a revenda a indicar o modelo certo para cada cliente.</p><ul><li><a href="https://www.youtube.com/watch?v=WPzema9Vie8" target="_blank" rel="noopener">Posicionamento de mercado da Xerox C70 e da AltaLink C8130</a></li><li><a href="https://www.youtube.com/watch?v=YxFbkm_7H1c" target="_blank" rel="noopener">Kit inicial de suprimentos da AltaLink C8130 (máquina nova, primeiro uso)</a></li><li><a href="https://www.youtube.com/watch?v=SgJPUePtL3A" target="_blank" rel="noopener">Kit inicial extra para a C70 recondicionada, com aval do fabricante</a></li></ul>',
            ],
            [
                'title' => 'Xerox C70: série em vídeo com aplicações, recursos e oportunidades de negócio',
                'slug' => 'xerox-c70-serie-em-video',
                'category' => 'Vídeos',
                'published_at' => '2024-10-21 09:00:00',
                'video_url' => 'https://www.youtube.com/watch?v=MxtFtp8boO0',
                'excerpt' => 'Visão geral, capacidade de papel, ajuste automático de cores, espectrofotômetro e troca de consumíveis pelo cliente final.',
                'body' => '<p>A Xerox C70 é uma aliada para gráficas rápidas e revendas que querem oferecer aplicações de alto valor agregado, como embalagens personalizadas e materiais promocionais. Confira os vídeos da série no canal da Tinsei:</p><ul><li><a href="https://www.youtube.com/watch?v=MxtFtp8boO0" target="_blank" rel="noopener">Overview do produto</a></li><li><a href="https://www.youtube.com/watch?v=IsB-D04UCXY" target="_blank" rel="noopener">Oportunidades de negócio e aplicações</a></li><li><a href="https://www.youtube.com/watch?v=90GGUD_tXPk" target="_blank" rel="noopener">Capacidade de papel</a></li><li><a href="https://www.youtube.com/watch?v=g4Yt9Vb40gE" target="_blank" rel="noopener">Ajuste automático de cores e registro (SIQA)</a></li><li><a href="https://www.youtube.com/watch?v=Zpy9uUrgL88" target="_blank" rel="noopener">Espectrofotômetro opcional</a></li><li><a href="https://www.youtube.com/watch?v=vkxYKuMDykY" target="_blank" rel="noopener">Interação simples e rápida pelo painel</a></li><li><a href="https://www.youtube.com/watch?v=jVUmr9ewGV0" target="_blank" rel="noopener">Troca de consumíveis pelo próprio cliente final (CRU)</a></li></ul>',
            ],
            [
                'title' => 'Conheça a Tinsei: líder em recondicionamento de equipamentos de impressão',
                'slug' => 'conheca-a-tinsei-video-institucional',
                'category' => 'Vídeos',
                'published_at' => '2024-05-24 09:00:00',
                'video_url' => 'https://www.youtube.com/watch?v=YFCMNfKTSME',
                'excerpt' => 'O vídeo institucional apresenta a estrutura e a operação da Tinsei — também disponível em inglês.',
                'body' => '<p>Assista ao vídeo institucional e conheça a operação que importa, recondiciona e distribui equipamentos de impressão para todo o Brasil.</p><p>Versão em inglês: <a href="https://www.youtube.com/watch?v=oEg7iqe3LC0" target="_blank" rel="noopener">Discover Tinsei — A Brazilian leader in reconditioning printing equipment</a>.</p>',
            ],
            [
                'title' => 'Visita à Tinsei: por dentro do maior importador de equipamentos de impressão do Brasil',
                'slug' => 'visita-a-tinsei-maior-importador',
                'category' => 'Na Mídia',
                'published_at' => '2022-09-01 09:00:00',
                'video_url' => 'https://www.youtube.com/watch?v=8yGs8Sxbd3o',
                'excerpt' => 'Um produtor de conteúdo do setor visitou a Tinsei e registrou a estrutura da empresa em vídeo.',
                'body' => '<p>Em uma visita autorizada, um canal do segmento de impressão registrou em vídeo um pouco da estrutura da Tinsei, apresentada como o maior importador de equipamentos de impressão do Brasil. Assista acima.</p>',
            ],
        ];

        foreach ($items as $item) {
            News::updateOrCreate(['slug' => $item['slug']], $item + ['author_id' => $admin->id]);
        }
    }

    private function seedEvents(): void
    {
        // Exemplo não publicado, apenas para mostrar o formato no painel.
        EventItem::updateOrCreate(['slug' => 'exemplo-treinamento-xerox-c70-para-revendas'], [
            'title' => 'EXEMPLO — Treinamento Xerox C70 para revendas',
            'type' => 'treinamento',
            'description' => 'Exemplo de evento (não publicado). Edite ou exclua e cadastre as datas reais de feiras, treinamentos e lançamentos.',
            'location' => 'On-line',
            'starts_at' => now()->addMonth()->setTime(14, 0),
            'ends_at' => now()->addMonth()->setTime(16, 0),
            'is_published' => false,
        ]);
    }

    private function seedTestimonials(): void
    {
        // Exemplo não publicado: publique somente depoimentos reais e autorizados.
        Testimonial::updateOrCreate(['client_name' => 'EXEMPLO — Nome do cliente'], [
            'role' => 'Diretor', 'company' => 'Revenda Exemplo', 'city' => 'Belo Horizonte', 'state' => 'MG',
            'quote' => 'Exemplo de depoimento. Substitua por um depoimento real, autorizado pelo cliente, e marque "Publicado".',
            'rating' => 5, 'is_active' => false, 'sort_order' => 0,
        ]);
    }

    private function seedBanners(): void
    {
        Banner::updateOrCreate(['title' => 'Conheça o E-Commerce Tinsei ES®'], [
            'subtitle' => 'Mais de 1.800 itens com preços exclusivos para revendas.',
            'link_url' => 'https://loja.tinsei.com.br/',
            'link_label' => 'Acessar a loja',
            'placement' => 'home_notice',
            'is_active' => true,
            'sort_order' => 0,
        ]);
    }

    private function seedMenu(): void
    {
        if (MenuItem::exists()) {
            return;
        }

        $about = MenuItem::create(['label' => 'A Tinsei', 'url' => '/sobre', 'sort_order' => 1]);
        foreach ([['Quem somos', '/sobre'], ['Nossa história', '/sobre#historia'], ['Sócios', '/sobre#socios'], ['Sustentabilidade', '/sustentabilidade'], ['Onde estamos', '/onde-estamos'], ['Trabalhe conosco', '/trabalhe-conosco']] as $i => [$label, $url]) {
            MenuItem::create(['label' => $label, 'url' => $url, 'parent_id' => $about->id, 'sort_order' => $i]);
        }

        foreach ([['Portfólio', '/portfolio'], ['Notícias', '/noticias'], ['Agenda', '/agenda'], ['Depoimentos', '/depoimentos'], ['Contato', '/contato']] as $i => [$label, $url]) {
            MenuItem::create(['label' => $label, 'url' => $url, 'sort_order' => $i + 2]);
        }
    }

    private function seedPages(): void
    {
        Page::updateOrCreate(['slug' => 'politica-de-privacidade'], [
            'title' => 'Política de Privacidade',
            'excerpt' => 'Como a Tinsei trata os dados pessoais coletados neste site, conforme a LGPD.',
            'content' => $this->privacyPolicy(),
            'is_published' => true,
        ]);

        Page::updateOrCreate(['slug' => 'termos-de-uso'], [
            'title' => 'Termos de Uso',
            'excerpt' => 'Condições de uso do site institucional da Tinsei.',
            'content' => '<p>Ao acessar este site, você concorda com estes Termos de Uso. O conteúdo tem caráter institucional e informativo; preços, disponibilidade e condições comerciais de produtos são os informados na loja B2B da Tinsei (loja.tinsei.com.br) ou pela equipe comercial.</p>'
                .'<h3>Propriedade intelectual</h3><p>Textos, imagens, marcas e demais conteúdos deste site pertencem à Tinsei ou a seus respectivos titulares e não podem ser reproduzidos sem autorização. Marcas de fabricantes citadas pertencem aos seus proprietários e são usadas apenas para identificar a compatibilidade e a origem dos produtos.</p>'
                .'<h3>Links externos</h3><p>Este site pode conter links para sites de terceiros, pelos quais a Tinsei não se responsabiliza.</p>'
                .'<h3>Contato</h3><p>Dúvidas sobre estes termos: <a href="mailto:atendimento@tinsei.com.br">atendimento@tinsei.com.br</a>.</p>'
                .'<p><em>Texto-base sujeito à revisão jurídica da Tinsei.</em></p>',
            'is_published' => true,
        ]);
    }

    private function privacyPolicy(): string
    {
        return '<p>A Tinsei Comércio Importação e Distribuição Ltda ("Tinsei"), CNPJ 13.839.772/0001-63, respeita a sua privacidade e trata dados pessoais conforme a Lei Geral de Proteção de Dados Pessoais (Lei nº 13.709/2018 – LGPD).</p>'
            .'<h3>1. Dados que coletamos</h3><ul><li>Dados informados nos formulários do site (nome, empresa, e-mail, telefone, cidade/UF e mensagem; no "Trabalhe conosco", também o currículo);</li><li>Dados técnicos de navegação necessários ao funcionamento do site (como cookies de sessão e segurança);</li><li>Dados de audiência (Google Analytics), somente se você aceitar o aviso de cookies.</li></ul>'
            .'<h3>2. Para que usamos</h3><ul><li>Responder contatos, solicitações comerciais e de suporte (art. 7º, V e IX, da LGPD);</li><li>Avaliar candidaturas a vagas (art. 7º, V);</li><li>Entender o uso do site e melhorar o conteúdo, mediante consentimento (art. 7º, I);</li><li>Cumprir obrigações legais (art. 7º, II).</li></ul>'
            .'<h3>3. Compartilhamento</h3><p>Não vendemos dados pessoais. Podemos compartilhá-los com fornecedores que nos apoiam (hospedagem, e-mail, atendimento) no limite do necessário, e com autoridades quando exigido por lei.</p>'
            .'<h3>4. Armazenamento e segurança</h3><p>Mantemos os dados pelo tempo necessário às finalidades acima ou pelo prazo legal, com medidas técnicas e administrativas de proteção.</p>'
            .'<h3>5. Seus direitos</h3><p>Você pode solicitar confirmação, acesso, correção, anonimização, portabilidade, eliminação e informações sobre compartilhamento, além de revogar o consentimento, pelo e-mail <a href="mailto:atendimento@tinsei.com.br">atendimento@tinsei.com.br</a>. A loja B2B também disponibiliza o <a href="https://loja.tinsei.com.br/canal-dpo">Canal DPO</a>.</p>'
            .'<h3>6. Cookies</h3><p>Usamos cookies necessários ao funcionamento do site e, com o seu consentimento, cookies de análise de audiência. Você pode recusá-los no aviso exibido na primeira visita.</p>'
            .'<p><em>Última atualização: novembro de 2026. Texto-base sujeito à revisão jurídica da Tinsei.</em></p>';
    }
}
