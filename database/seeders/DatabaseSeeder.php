<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BackupPlan;
use App\Models\Client;
use App\Models\ClientPresence;
use App\Models\CloudPlan;
use App\Models\EventItem;
use App\Models\KnowledgeArticle;
use App\Models\MenuItem;
use App\Models\News;
use App\Models\Page;
use App\Models\Product;
use App\Models\SuccessStory;
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
        $this->seedBackupPlans();
        $this->seedNews($admin);
        $this->seedEvents();
        $this->seedBanners();
        $this->seedTestimonials();
        $this->seedSuccessStories();
        $this->seedClientPresences();
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
                .'<p><strong>Telefone / WhatsApp:</strong> (31) 3416-8225</p>'
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
        // Linha do tempo, liderança e missão/visão/valores (com fotos reais)
        // são renderizadas à parte por PageController/pages/grupo-databit.blade.php,
        // em blocos estruturados mais modernos que uma lista de <h3>; este
        // texto cobre apenas a introdução em prosa.
        return '<p>Há mais de 30 anos no mercado, a Databit desenvolve tecnologia para simplificar a gestão de atacadistas, distribuidores, varejistas, locadoras e prestadores de serviço em todo o Brasil — com um ecossistema que integra ERP, Cloud, mobilidade, atendimento ao cliente e serviços de TI.</p>';
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
            ['label' => 'Institucional', 'url' => '/paginas/grupo-databit', 'sort_order' => 4],
        ];

        foreach ($items as $item) {
            MenuItem::firstOrCreate(['label' => $item['label']], $item);
        }

        // Notícias e Agenda entram como submenus de Institucional, junto com
        // Grupo Databit / Casos de Sucesso / Perguntas Frequentes / Fale
        // Conosco — menu principal enxuto (4 itens), tudo gerenciável pelo
        // painel administrativo.
        $institucional = MenuItem::where('label', 'Institucional')->first();
        $institucionalChildren = [
            ['label' => 'Grupo Databit', 'url' => '/paginas/grupo-databit', 'sort_order' => 1],
            ['label' => 'Casos de Sucesso', 'url' => '/casos-de-sucesso', 'sort_order' => 2],
            ['label' => 'Notícias', 'url' => '/novidades', 'sort_order' => 3],
            ['label' => 'Agenda', 'url' => '/agenda', 'sort_order' => 4],
            ['label' => 'Base de Conhecimento', 'url' => '/base-de-conhecimento', 'sort_order' => 5],
            ['label' => 'Perguntas Frequentes', 'url' => '/paginas/perguntas-frequentes', 'sort_order' => 6],
            ['label' => 'Fale Conosco', 'url' => '/paginas/fale-conosco', 'sort_order' => 7],
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
        foreach (['dataservice', 'datawhats', 'datacount', 'datainvoice', 'datashipping', 'datadashboard'] as $slug) {
            $this->putSeedFile("products/{$slug}.png", "products/{$slug}.png");
        }

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

        $dataClassicDescription = '<p>Sistema de gestão empresarial completo, modular e de fácil operação, para atacadistas, distribuidores, varejistas, locadoras e prestadores de serviço nos segmentos de comércio, locação, prestação de serviço e outsourcing. Confira os módulos que já são integrados.</p>'
            .'<p>O DataClassic também conta com conferência de estoque, gestor de documentos fiscais, coletor de série/lote, integrações de outsourcing (Printwayy, Orbix, Doc Service, IBSTracker), APIs abertas (Tray Commerce, Pluggto), emissão de etiquetas, aplicativo de XML, disparo de e-mails de OS, NFS-e e integrações com transportadoras (Correios, Mercocamp, Leolog).</p>';

        $dataClassicHighlights = [
            ['icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z', 'title' => 'Gestão de Cadastros', 'desc' => $dataClassicModules['Gestão de Cadastros']],
            ['icon' => 'M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z', 'title' => 'Gestão de Compras', 'desc' => $dataClassicModules['Gestão de Compras']],
            ['icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z', 'title' => 'Gestão de Estoque', 'desc' => $dataClassicModules['Gestão de Estoque']],
            ['icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'title' => 'Gestão de Contratos', 'desc' => $dataClassicModules['Gestão de Contratos']],
            ['icon' => 'M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322-1.834.212-3.34 1.717-3.34 3.552v13.5A2.25 2.25 0 004.5 21.75h15a2.25 2.25 0 002.25-2.25V6.125c0-1.836-1.505-3.34-3.34-3.553A48.554 48.554 0 0012 2.25z', 'title' => 'Gestão de Orçamentos', 'desc' => $dataClassicModules['Gestão de Orçamentos']],
            ['icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'title' => 'Gestão Fiscal e Integração Contábil', 'desc' => $dataClassicModules['Gestão Fiscal e Integração Contábil']],
            ['icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z', 'title' => 'Análise Gerencial', 'desc' => $dataClassicModules['Análise Gerencial']],
            ['icon' => 'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085', 'title' => 'Gestão de Assistência Técnica', 'desc' => $dataClassicModules['Gestão de Assistência Técnica']],
            ['icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.25h5.379c.621 0 1.129.504 1.09 1.124a17.902 17.902 0 01-3.213 9.193 2.056 2.056 0 01-1.58.86H14.25M9 3v11.25M6 6.75H3.75m5.25 0h5.25M6 15h5.25', 'title' => 'Gestão de Expedição', 'desc' => $dataClassicModules['Gestão de Expedição']],
            ['icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99', 'title' => 'Logística Reversa', 'desc' => $dataClassicModules['Logística Reversa']],
            ['icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z', 'title' => 'Gestão Financeira', 'desc' => $dataClassicModules['Gestão Financeira']],
            ['icon' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z', 'title' => 'Gestão de Faturamento', 'desc' => $dataClassicModules['Gestão de Faturamento']],
        ];

        $dataMobileDescription = '<p>O aplicativo que a sua equipe técnica sempre precisou — reescrito do zero, com interface moderna, sincronização em tempo real com o DataClassic e uma nova geração de recursos para quem trabalha em campo. Disponível oficialmente na Google Play Store, com atualizações 100% automáticas.</p>'
            .'<h3>Gestão de campo completa</h3><ul>'
            .'<li><strong>Ordens de serviço:</strong> receba, visualize e execute OS diretamente no app, com check-in e check-out por geolocalização, laudo técnico completo e histórico de equipamentos.</li>'
            .'<li><strong>Monitoramento em tempo real:</strong> gestores acompanham a equipe técnica em campo via geolocalização, integrado ao DataService Web.</li>'
            .'<li><strong>Controle de entregas:</strong> gestão de entrega de peças e suprimentos, com check-out total ou parcial, assinatura do cliente e envio automático do protocolo por e-mail.</li>'
            .'<li><strong>Controle de ponto:</strong> registro de início, intervalo e fim de expediente com geolocalização, com relatório completo de banco de horas.</li>'
            .'<li><strong>Modo offline:</strong> OS previamente sincronizadas ficam disponíveis sem conexão, com envio automático dos dados assim que a rede voltar.</li>'
            .'<li><strong>Login com biometria:</strong> acesso rápido e seguro por leitor de digitais, habilitado automaticamente após o primeiro login.</li>'
            .'</ul>'
            .'<h3>Novidades da versão atual</h3><ul>'
            .'<li><strong>Assinatura de OS em lote:</strong> o cliente valida múltiplos atendimentos com uma única assinatura, acelerando o fechamento de chamados.</li>'
            .'<li><strong>Registro de despesas:</strong> o técnico registra gastos do dia e consulta adiantamentos direto no app, sem planilhas extras.</li>'
            .'<li><strong>Meu Kit — estoque em campo:</strong> visibilidade total sobre as peças e insumos sob responsabilidade do técnico.</li>'
            .'<li><strong>Rota inteligente:</strong> integração nativa com o Google Maps, com planejamento de até 9 paradas simultâneas e filtro por proximidade.</li>'
            .'<li><strong>Base de conhecimento:</strong> a experiência acumulada da empresa disponível para o técnico em campo, editável pelo DataClassic.</li>'
            .'<li><strong>Dashboard do dia:</strong> nova tela inicial com cards interativos de OS, despesas e entregas, com filtros rápidos por tipo de atendimento.</li>'
            .'</ul>'
            .'<h3>Performance e segurança</h3>'
            .'<p>O DATAMOBILE foi reescrito com foco em velocidade e proteção de dados: ganho de até 60% no desempenho de sincronização e carregamento, comunicação totalmente criptografada (SSL) entre app e servidores Databit, e uma interface renovada com hierarquia visual mais clara para reduzir o esforço em uso contínuo no campo.</p>'
            .'<h3>Como funciona na prática</h3><ol>'
            .'<li>O cliente ou gestor abre a OS no DataService Web ou no DataClassic.</li>'
            .'<li>O gestor define o técnico no DataClassic — a OS aparece no app instantaneamente.</li>'
            .'<li>O técnico executa, registra e encerra a OS com assinatura no DATAMOBILE.</li>'
            .'<li>O DataClassic é atualizado em tempo real — o gestor acompanha o SLA e emite relatórios.</li>'
            .'</ol>';

        $dataClientDescription = '<p>O DataClient é o CRM 100% web da Databit, integrado nativamente ao DataSAC e ao DataClassic. Centralize o pipeline comercial, automatize follow-ups e feche mais negócios — sem deixar nenhum lead esfriar.</p>'
            .'<h3>O problema que o DataClient resolve</h3><ul>'
            .'<li><strong>Planilhas desatualizadas</strong> que ninguém mantém e ninguém confia, levando a decisões erradas e oportunidades perdidas.</li>'
            .'<li><strong>Follow-ups esquecidos</strong> por falta de alertas e de visibilidade sobre onde cada negociação está no funil.</li>'
            .'<li><strong>Atendimento fragmentado</strong> em vários canais sem histórico centralizado, gerando retrabalho e má experiência para o cliente.</li>'
            .'</ul>'
            .'<h3>Um ecossistema comercial integrado</h3>'
            .'<p>O DataClient não é um CRM isolado: é o elo comercial do ecossistema Databit. O <strong>DataSAC</strong> recebe contatos por WhatsApp, Telegram, Instagram, Facebook Messenger, e-mail e webchat e os transforma em leads direto no DataClient; negócios fechados disparam automaticamente pedidos e faturamento no <strong>DataClassic</strong>, sem retrabalho.</p>'
            .'<h3>Fluxo de vendas, do primeiro contato ao contrato assinado</h3><ol>'
            .'<li><strong>Contato:</strong> chega pelo DataSAC, por qualquer canal omnichannel.</li>'
            .'<li><strong>Lead:</strong> convertido para o DataClient com histórico completo.</li>'
            .'<li><strong>Oportunidade:</strong> gerenciada em múltiplos funis, com visão Kanban e lista.</li>'
            .'<li><strong>Proposta:</strong> elaborada e enviada de forma personalizada pelo sistema.</li>'
            .'<li><strong>Fechamento:</strong> integração automática com o DataClassic para faturamento.</li>'
            .'</ol>'
            .'<h3>Funcionalidades</h3><ul>'
            .'<li><strong>Gestão de usuários e permissões:</strong> controle de acesso granular para vendedores, gerentes e administradores.</li>'
            .'<li><strong>Dashboards e métricas:</strong> funil de vendas, taxa de conversão, ranking de vendedores e metas em tempo real.</li>'
            .'<li><strong>Múltiplos funis de venda:</strong> etapas, critérios e responsáveis específicos por produto ou segmento.</li>'
            .'<li><strong>Agenda integrada:</strong> reuniões, ligações e atividades da equipe comercial em um só lugar.</li>'
            .'<li><strong>Campanhas de marketing:</strong> disparos por e-mail e WhatsApp para nutrição de leads e reativação de clientes.</li>'
            .'<li><strong>Propostas personalizadas:</strong> elaboração e envio direto do sistema, com controle de versões e aprovação.</li>'
            .'<li><strong>Pós-venda integrado:</strong> fluxo parametrizável de aprovação, geração de contrato e acompanhamento até a entrega.</li>'
            .'<li><strong>Integração com o DataClassic:</strong> pré-contratos viram pedidos automaticamente no ERP.</li>'
            .'<li><strong>Gestão de documentos e motivos de perda:</strong> histórico completo, rastreabilidade e análise de padrões para melhorar a abordagem comercial.</li>'
            .'</ul>';

        $dataServiceDescription = '<p>O DataService é a ferramenta web para gestão de ordens de serviço e requisições de suprimentos de forma fácil e eficiente. Com módulos de consulta em tempo real e integração direta ao DataClassic, automatizamos a comunicação com o cliente, garantindo agilidade e precisão no processo. Os técnicos têm acesso fácil aos chamados e podem realizar atendimentos diretamente no local, enquanto os gestores acompanham as atividades em tempo real através do monitor de SLA no DataClassic, proporcionando uma gestão mais eficiente e assertiva. Confira algumas das facilidades que sua empresa terá.</p>';

        $dataServiceHighlights = [
            ['icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6 21v-3.375c0-.621.504-1.125 1.125-1.125h1.5c.621 0 1.125.504 1.125 1.125V21', 'title' => 'Portal de Serviços', 'desc' => 'Oferece soluções completas para a gestão de equipamentos locados. Desde a solicitação de suprimentos até a assistência técnica, nossa plataforma simplifica todo o processo. Com facilidade, você pode solicitar suprimentos, abrir chamados técnicos, obter informações contratuais, relatórios de atendimentos e suporte financeiro.'],
            ['icon' => 'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085', 'title' => 'Portal do Técnico', 'desc' => 'Na nossa plataforma, o técnico abre um chamado na web, que é imediatamente registrado no DataClassic, notificando o gestor. Este define o técnico, identifica o defeito e encaminha a solicitação. Assim que o gestor envia o chamado para o técnico pelo DataClassic, começa a funcionalidade web do técnico, permitindo uma intervenção rápida e integrada. Essa abordagem garante uma resposta eficiente às necessidades do cliente.'],
            ['icon' => 'M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Portal do Cliente', 'desc' => 'Tenha uma central de controle completa para gerenciamento de serviços técnicos e suprimentos. Os clientes podem abrir chamados técnicos, gerar QR codes para solicitar suprimentos, requisitar suprimentos diretamente, visualizar detalhes do contrato e equipamentos, acessar informações financeiras (incluindo reimpressão de boletos) e analisar o histórico de compras, inclusive reimprimir notas fiscais. Também fornecemos gráficos para uma análise visual de chamados, requisições e compras.'],
        ];

        $dataWhatsDescription = '<p>O DataWhats é a ferramenta de comunicação da Databit integrada ao WhatsApp, que cria diversos canais de comunicação entre os usuários do DataClassic e seus clientes. Confira algumas facilidades na comunicação que sua empresa terá.</p>';

        $dataWhatsHighlights = [
            ['icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75e-3V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0', 'title' => 'Notificações', 'desc' => 'Envio automático de mensagens por mudança de status no sistema: NF-e/XML/boleto em determinado status do processo, fatura de locação e demonstrativo logo após o faturamento, e pesquisa de satisfação na finalização da OS pelo técnico.'],
            ['icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z', 'title' => 'Alertas', 'desc' => 'Procedimentos automatizados a partir de consultas configuráveis no banco de dados: cobranças, informações estratégicas para gestores, OS/requisições no limite do SLA, processos parados e produtos com saldo abaixo do mínimo.'],
            ['icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z', 'title' => 'Atendimento eletrônico (Chatbot)', 'desc' => 'WhatsApp Business com menu de atendimento configurável para abertura e acompanhamento de chamados, segunda via de documentos fiscais e boletos, e divulgação de produtos em promoção.'],
            ['icon' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z', 'title' => 'Atendimento humano (DataTalk)', 'desc' => 'Substitua a central telefônica por um canal digital personalizado: crie equipes por setor, deixe o cliente escolher o setor de contato e mantenha o log completo de todos os atendimentos.'],
        ];

        $dataCountDescription = '<p>O DataCount realiza a contagem de conferência dos itens que chegam e que saem do estoque em um determinado centro de logística, com base nos movimentos de compras e vendas registrados no DataClassic.</p>';

        $dataCountHighlights = [
            ['icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'title' => 'Contagem sem parar o estoque', 'desc' => 'Contagem por coletor de dados ou aplicativo, sem parar a operação do estoque.'],
            ['icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99', 'title' => 'Conferência automática', 'desc' => 'Conferência automática contra os movimentos de compra e venda já lançados no ERP.'],
            ['icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z', 'title' => 'Divergências à vista', 'desc' => 'Identificação imediata de divergências entre o contado e o esperado.'],
            ['icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'title' => 'Integração 100% nativa', 'desc' => 'Integração nativa com o módulo de estoque do DataClassic — sem digitação manual.'],
        ];

        $dataInvoiceDescription = '<p>O DataInvoice simplifica as operações de emissão de NF-e, automatizando o envio de notas fiscais e boletos com apenas um clique — economizando tempo e reduzindo erros manuais da equipe fiscal.</p>';

        $dataInvoiceHighlights = [
            ['icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'title' => 'Captura e conferência', 'desc' => 'Notas fiscais de entrada capturadas e conferidas, com lançamento automatizado no DataClassic.'],
            ['icon' => 'M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5', 'title' => 'Envio automático', 'desc' => 'Envio automático de NF-e, XML e boletos ao cliente logo após o faturamento.'],
            ['icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Menos trabalho manual', 'desc' => 'Redução do trabalho manual da equipe fiscal e menor risco de erro de digitação.'],
            ['icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'title' => 'Integração nativa', 'desc' => 'Integração nativa com o módulo fiscal do DataClassic, sem retrabalho entre sistemas.'],
        ];

        $dataShippingDescription = '<p>O DataShipping automatiza a cotação online de frete com diversas transportadoras parceiras, direto do ERP — impulsionando a eficiência e a produtividade da expedição.</p>';

        $dataShippingHighlights = [
            ['icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.25h5.379c.621 0 1.129.504 1.09 1.124a17.902 17.902 0 01-3.213 9.193 2.056 2.056 0 01-1.58.86H14.25M9 3v11.25M6 6.75H3.75m5.25 0h5.25M6 15h5.25', 'title' => 'Cotação simultânea', 'desc' => 'Cotação online simultânea com múltiplas transportadoras integradas (Correios, Mercocamp, Leolog e outras).'],
            ['icon' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z', 'title' => 'Etiquetas automáticas', 'desc' => 'Emissão de etiquetas e envio de dados do pedido direto do DataClassic.'],
            ['icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z', 'title' => 'Rastreamento integrado', 'desc' => 'Rastreamento de encomendas integrado à gestão de expedição do ERP.'],
            ['icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'title' => 'Menos erro manual', 'desc' => 'Redução de erros manuais na escolha de transportadora e cálculo de frete.'],
        ];

        $dataDashboardDescription = '<p>Painéis estratégicos de gestão, totalmente integrados ao DataClassic e configurados de acordo com o perfil do seu negócio — pensados originalmente para operações de locação e outsourcing de impressão.</p>';

        $dataDashboardHighlights = [
            ['icon' => 'M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z', 'title' => 'Análise de Contratos', 'desc' => 'Rentabilidade de cada contrato em uma única tela: receitas, impostos, quantidade de equipamentos, custos de suprimentos e peças, custo com chamados técnicos, comissão e rentabilidade final.'],
            ['icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z', 'title' => 'Parque de Equipamentos', 'desc' => 'Controle de todos os equipamentos em contrato e em estoque, com status por equipamento (revisado, a revisar, novo, canibalizado).'],
            ['icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z', 'title' => 'Acompanhamento de Faturamento', 'desc' => 'Contratos faturados e pendentes de faturamento, com quantidade, valor e destaque para contratos com faturamento atrasado.'],
            ['icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z', 'title' => 'Produção x Vida Útil de Suprimentos', 'desc' => 'Análise da produção de cada contrato em relação à quantidade de suprimentos enviados e à vida útil de cada um, identificando desvios em relação ao que deveria ser impresso.'],
            ['icon' => 'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085', 'title' => 'Assistência Técnica', 'desc' => 'Ranking de produtividade da equipe técnica: quantidade de OS por técnico, média mensal, tempo de deslocamento, rechamados e tempo médio de solução — por cliente, defeito, cidade e técnico.'],
            ['icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99', 'title' => 'Fluxo de Caixa', 'desc' => 'Tela dinâmica para visão completa do fluxo de caixa, com detalhamento de inadimplência e dos dias.'],
            ['icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z', 'title' => 'Resumo Financeiro', 'desc' => 'Analise resultados (contas a receber versus contas a pagar) por centro e subcentro de custos, com visão de caixa e competência.'],
            ['icon' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z', 'title' => 'DRE Personalizada', 'desc' => 'Construímos sua DRE com personalização do seu demonstrativo de resultados de acordo com a sua forma de análise e rateios.'],
        ];

        $items = [
            [
                'name' => 'DataClassic',
                'category' => 'gestao',
                'tagline' => 'O sistema de gestão do seu negócio',
                'summary' => 'ERP completo para atacadistas, distribuidores, varejistas, locadoras e prestadores de serviço, com 12 módulos integrados — de cadastros e compras a fiscal, financeiro e faturamento.',
                'description' => $dataClassicDescription,
                'highlights' => $dataClassicHighlights,
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
                'description' => $dataMobileDescription,
                'icon' => 'heroicon-o-device-phone-mobile',
                'external_url' => null,
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
                'opens_externally' => true,
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
                'opens_externally' => true,
                'is_featured' => false,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
            [
                'name' => 'DataClient CRM',
                'category' => 'crm',
                'tagline' => 'Transforme cada contato em uma oportunidade real',
                'summary' => 'CRM 100% web que centraliza o pipeline comercial, automatiza follow-ups e se integra ao DataSAC e ao DataClassic para um ecossistema completo de vendas.',
                'description' => $dataClientDescription,
                'icon' => 'heroicon-o-users',
                'external_url' => null,
                'is_featured' => true,
                'is_cloud_highlight' => false,
                'is_ecosystem_node' => true,
            ],
            [
                'name' => 'DataWhats',
                'category' => 'comunicacao',
                'tagline' => 'WhatsApp integrado, comunicação facilitada',
                'summary' => 'Integração oficial do WhatsApp aos sistemas Databit para comunicação com clientes direto do ERP e do atendimento.',
                'description' => $dataWhatsDescription,
                'highlights' => $dataWhatsHighlights,
                'video_url' => 'https://youtu.be/JV-BMY0sJ9k',
                'logo_image' => 'products/datawhats.png',
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
                'description' => $dataServiceDescription,
                'highlights' => $dataServiceHighlights,
                'video_url' => 'https://youtu.be/S26jpSToYBM',
                'logo_image' => 'products/dataservice.png',
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
                'description' => $dataCountDescription,
                'highlights' => $dataCountHighlights,
                'video_url' => 'https://www.youtube.com/watch?v=i4bKn9Fmlqk',
                'logo_image' => 'products/datacount.png',
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
                'description' => $dataInvoiceDescription,
                'highlights' => $dataInvoiceHighlights,
                'video_url' => 'https://www.youtube.com/watch?v=1GWx8Rp2iOk',
                'logo_image' => 'products/datainvoice.png',
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
                'description' => $dataShippingDescription,
                'highlights' => $dataShippingHighlights,
                'video_url' => 'https://www.youtube.com/watch?v=VQ0nBgdQIIQ',
                'logo_image' => 'products/datashipping.png',
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
                'description' => $dataDashboardDescription,
                'highlights' => $dataDashboardHighlights,
                'video_url' => 'https://www.youtube.com/watch?v=Y6wCeV8Rxh0',
                'logo_image' => 'products/datadashboard.png',
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
                    'highlights' => $item['highlights'] ?? null,
                    'video_url' => $item['video_url'] ?? null,
                    'logo_image' => $item['logo_image'] ?? null,
                    'icon' => $item['icon'],
                    'external_url' => $item['external_url'],
                    'opens_externally' => $item['opens_externally'] ?? false,
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

    // Planos do DataBackup+, no mesmo padrão de degrau de preço/capacidade
    // do DataCloud (START/PLUS/PRO/BUSINESS/ENTERPRISE), com preços
    // competitivos para o mercado brasileiro de backup em nuvem.
    private function seedBackupPlans(): void
    {
        $items = [
            ['name' => 'START', 'price_monthly' => 89, 'storage_gb' => 50, 'device_limit' => 3, 'retention_days' => 15, 'is_popular' => false],
            ['name' => 'PLUS', 'price_monthly' => 249, 'storage_gb' => 200, 'device_limit' => 8, 'retention_days' => 30, 'is_popular' => false],
            ['name' => 'PRO', 'price_monthly' => 449, 'storage_gb' => 500, 'device_limit' => 15, 'retention_days' => 30, 'is_popular' => true],
            ['name' => 'BUSINESS', 'price_monthly' => 749, 'storage_gb' => 1024, 'device_limit' => 30, 'retention_days' => 45, 'is_popular' => false],
            ['name' => 'ENTERPRISE', 'price_monthly' => 1290, 'storage_gb' => 2048, 'device_limit' => null, 'retention_days' => 60, 'is_popular' => false],
        ];

        foreach ($items as $index => $item) {
            BackupPlan::firstOrCreate(
                ['name' => $item['name']],
                [
                    'name' => $item['name'],
                    'price_monthly' => $item['price_monthly'],
                    'storage_gb' => $item['storage_gb'],
                    'device_limit' => $item['device_limit'],
                    'retention_days' => $item['retention_days'],
                    'description' => 'Criptografado · VMs, bancos de dados, M365, servidores e mais',
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
                'title' => 'Databit confirma presença na Feira Minas Parts 2026',
                'category' => 'Feiras e Eventos',
                'is_featured' => true,
                'published_at' => now(),
                'cover_image' => 'news/databit-confirma-presenca-na-feira-minas-parts-2026.svg',
                'excerpt' => 'A Databit vai marcar presença na maior feira de autopeças de Minas Gerais, reforçando a entrada forte no segmento de distribuidores, atacadistas e varejistas de peças automotivas.',
                'body' => '<p>A Databit confirma presença na <strong>Feira Minas Parts 2026</strong>, o principal encontro do setor de autopeças de Minas Gerais, que reúne fabricantes, distribuidores, atacadistas e varejistas de todo o país. O evento é uma nova frente da Databit para reforçar sua entrada no segmento de autopeças — um mercado que já conhece bem através de clientes como a MR Copiadoras e outros distribuidores atendidos pelo ecossistema DataClassic.</p>'
                    .'<h3>Por que a Databit está de olho no setor de autopeças</h3>'
                    .'<p>Distribuidores e varejistas de peças automotivas têm desafios muito específicos: catálogos gigantes de itens, aplicação por veículo, giro de estoque acelerado, múltiplos canais de venda (balcão, atacado, e-commerce) e uma operação fiscal complexa. O <strong>DataClassic</strong> — nosso ERP com mais de 30 anos de mercado — já nasceu resolvendo esse tipo de dor para distribuidores e locadoras, e vem sendo cada vez mais adequado às particularidades de quem vive "da placa à peça": do cadastro técnico do item ao faturamento da venda.</p>'
                    .'<h3>O que esperar do nosso estande</h3>'
                    .'<p>Durante a feira, a equipe Databit vai apresentar como o DataClassic e o restante do nosso ecossistema — DataCloud, DataSAC e DataClient CRM — se aplicam diretamente à rotina de atacadistas e varejistas de autopeças: gestão de estoque de alta rotatividade, precificação dinâmica, integração fiscal e atendimento multicanal ao cliente final e a lojistas.</p>'
                    .'<p>Se a sua empresa atua no setor de autopeças e quer conhecer de perto uma gestão pensada para a realidade do setor, venha nos visitar na Feira Minas Parts 2026 ou fale com a nossa equipe para agendar uma demonstração.</p>'
                    .'<p>Mais informações sobre o evento em <a href="https://feiraminasparts.com.br/visitantes/" target="_blank" rel="noopener">feiraminasparts.com.br</a>.</p>',
            ],
            [
                'title' => 'Tendência mundial: por que as empresas estão levando tudo para a nuvem',
                'category' => 'Cloud',
                'is_featured' => true,
                'published_at' => now()->subDay(),
                'cover_image' => 'news/tendencia-mundial-por-que-as-empresas-estao-levando-tudo-para-a-nuvem.svg',
                'excerpt' => 'Servidor de arquivos, e-mail corporativo, ERP: com o custo da nuvem caindo, cada vez mais empresas de todos os portes deixam de depender de qualquer coisa dentro de casa.',
                'body' => '<p>Uma mudança silenciosa vem acontecendo na forma como empresas de todos os tamanhos organizam a própria infraestrutura de tecnologia: a tendência mundial é levar tudo para a nuvem e parar de depender de qualquer coisa dentro de casa. Servidor de arquivos, e-mail corporativo, banco de dados, ERP — item por item, o que antes vivia em uma sala com ar-condicionado e nobreak dentro da empresa está migrando para data centers especializados.</p>'
                    .'<h3>Por que essa mudança está acontecendo agora</h3>'
                    .'<p>Não é novidade que a nuvem existe — mas o que mudou nos últimos anos foi o custo. Com a concorrência entre provedores e a maturidade da tecnologia, hospedar um servidor na nuvem deixou de ser artigo de luxo reservado a grandes corporações e virou uma conta que fecha para pequenas e médias empresas. O resultado: o que era tendência de multinacional agora é decisão de qualquer negócio que faz as contas com atenção.</p>'
                    .'<h3>O que as empresas estão tirando de dentro de casa</h3><ul>'
                    .'<li><strong>Servidor de arquivos:</strong> substituído por armazenamento em nuvem, acessível de qualquer lugar, sem depender de um equipamento físico vulnerável a pane, incêndio ou roubo.</li>'
                    .'<li><strong>E-mail corporativo:</strong> soluções robustas de e-mail em nuvem (como Microsoft 365) substituem servidores de e-mail locais, com mais segurança e menos manutenção.</li>'
                    .'<li><strong>ERP e sistemas de gestão:</strong> o próprio sistema que roda a operação da empresa migra para VMs em nuvem, eliminando o servidor local como ponto único de falha.</li>'
                    .'<li><strong>Backup:</strong> cópias de segurança saem do HD externo ou da fita e vão para a nuvem, com retenção configurável e recuperação testada.</li>'
                    .'</ul>'
                    .'<h3>Os ganhos concretos de sair de casa</h3><p>Além da economia direta com hardware, energia e refrigeração, empresas que migram para a nuvem ganham disponibilidade (menos paradas), escalabilidade (aumentar recursos sem comprar equipamento novo), segurança (data centers com infraestrutura muito mais robusta que uma sala de servidor comum) e mobilidade real para o time trabalhar de qualquer lugar.</p>'
                    .'<h3>Como a Databit ajuda nessa transição</h3><p>O <strong>DataCloud</strong> oferece máquinas virtuais sob demanda — Linux, Windows e SQL Server — dimensionadas para o seu projeto, com migração assistida do seu servidor físico atual. E, para quem quer ir além da infraestrutura e transferir toda a gestão de TI para especialistas, o <strong>Databit MSP</strong> cuida do ambiente de ponta a ponta, incluindo o backup gerenciado do add-on <strong>DataBackup+</strong>. Fale com a gente para entender por onde começar a tirar a sua empresa de dentro de casa.</p>',
            ],
            [
                'title' => 'DataMobile 2025 chega com assinatura em lote, rota inteligente e novo dashboard',
                'category' => 'Lançamento',
                'is_featured' => true,
                'cover_image' => 'news/datamobile-2025-chega-com-assinatura-em-lote-rota-inteligente-e-novo-dashboard.svg',
                'excerpt' => 'Nova versão do app reforça a produtividade das equipes técnicas em campo com seis novos recursos.',
            ],
            [
                'title' => 'DataCloud lança plano ENTERPRISE para operações de grande porte',
                'category' => 'Lançamento',
                'is_featured' => true,
                'cover_image' => 'news/datacloud-lanca-plano-enterprise-para-operacoes-de-grande-porte.svg',
                'excerpt' => 'Novo plano oferece até 12 vCPU, 64 GB de RAM e 400 GB SSD com o mesmo suporte especializado da Databit.',
            ],
            [
                'title' => 'DataSAC chega para centralizar o atendimento multicanal da sua empresa',
                'category' => 'Lançamento',
                'is_featured' => true,
                'cover_image' => 'news/datasac-chega-para-centralizar-o-atendimento-multicanal-da-sua-empresa.svg',
                'excerpt' => 'Plataforma unifica WhatsApp, e-mail e chat em uma única caixa de entrada, com automações e IA.',
            ],
            [
                'title' => 'Databit lança o DataClient CRM integrado ao ecossistema DataSAC e DataClassic',
                'category' => 'Lançamento',
                'is_featured' => false,
                'cover_image' => 'news/databit-lanca-o-dataclient-crm-integrado-ao-ecossistema-datasac-e-dataclassic.svg',
                'excerpt' => 'Novo CRM 100% web centraliza o pipeline comercial e automatiza follow-ups da equipe de vendas.',
            ],
            [
                'title' => 'Databit celebra mais de 30 anos de mercado',
                'category' => 'Institucional',
                'is_featured' => false,
                'cover_image' => 'news/databit-celebra-mais-de-30-anos-de-mercado.svg',
                'excerpt' => 'Trajetória é marcada pela evolução constante do ecossistema de produtos para gestão empresarial.',
            ],
            [
                'title' => 'DataMDFe simplifica a emissão do Manifesto Eletrônico para transportadoras parceiras',
                'category' => 'Novidade',
                'is_featured' => false,
                'cover_image' => 'news/datamdfe-simplifica-a-emissao-do-manifesto-eletronico-para-transportadoras-parceiras.svg',
                'excerpt' => 'Solução vincula NF-e e CT-e em um único documento, reduzindo o trabalho manual das equipes fiscais.',
            ],
            [
                'title' => 'Reforma Tributária: o que muda para sua empresa e como preparar seus sistemas',
                'category' => 'Reforma Tributária',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
                'cover_image' => 'news/reforma-tributaria-o-que-muda-para-sua-empresa-e-como-preparar-seus-sistemas.svg',
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
                'cover_image' => 'news/ataques-de-ransomware-por-que-nenhuma-empresa-esta-imune.svg',
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
                'cover_image' => 'news/backup-e-disponibilidade-o-seguro-que-sua-empresa-nao-pode-deixar-de-ter.svg',
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
                    .'<p>O add-on <strong>DataBackup+</strong> oferece backup diário automatizado, testes de restauração periódicos e plano de recuperação de desastres documentado. Conheça o modelo completo de gestão de TI no <a href="/servicos-ti/msp">Databit MSP</a>.</p>',
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
                    'cover_image' => $item['cover_image'] ?? null,
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
        $this->putPlaceholderSvg('banners/campaign-30-anos.svg', 800, 400, '#2347d6', 'Databit · +30 anos de mercado');

        $items = [
            ['title' => 'Da placa à peça: DataClassic integrado à Minas Parts', 'image' => 'banners/databit-minasparts-da-placa-a-peca.png', 'placement' => 'home_hero', 'sort_order' => 3, 'link_url' => route('news.show', 'databit-confirma-presenca-na-feira-minas-parts-2026'), 'overlay_title' => false],
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

        // Banners de destaque de produto (ERP DataClassic e DataCloud) —
        // slides desenhados em CSS a partir dos dados reais do produto, sem
        // depender de peças gráficas prontas. Giram no carrossel principal
        // junto com o banner "Da placa à peça" acima (troca automática a
        // cada 6s + navegação manual pelos indicadores).
        $spotlights = [
            [
                'title' => 'Destaque: DataClassic (ERP)',
                'product_slug' => 'dataclassic',
                'sort_order' => 1,
                'highlights' => ['12 módulos integrados', 'Fiscal e financeiro completo', 'Mais de 30 anos de mercado'],
            ],
            [
                'title' => 'Destaque: DataCloud',
                'product_slug' => 'datacloud',
                'sort_order' => 2,
                'highlights' => ['Linux, Windows e SQL Server', 'Escalabilidade sem migração complexa', 'Suporte especializado em português'],
            ],
        ];

        foreach ($spotlights as $item) {
            $product = Product::where('slug', $item['product_slug'])->first();

            Banner::firstOrCreate(
                ['title' => $item['title']],
                [
                    'title' => $item['title'],
                    'variant' => 'product_spotlight',
                    'product_id' => $product?->id,
                    'highlights' => $item['highlights'],
                    'placement' => 'home_hero',
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

    // Casos de sucesso reais (databit.com.br/grupo-databit/, seção "Confira
    // quem já simplificou a sua Gestão"). Os vídeos hospedados no domínio da
    // Databit são reaproveitados diretamente para os clientes em que existem;
    // Maqlarem e Apnet ainda não têm vídeo publicado na página de origem.
    private function seedSuccessStories(): void
    {
        $items = [
            [
                'company' => 'MR Copiadoras',
                'location' => 'Belo Horizonte',
                'client_since' => 2011,
                'highlight' => 'Destaque por ser onde nasceu o projeto de desenvolvimento de um software ERP, foi vivenciando as dores da MR, que pegamos o nosso software e adequamos com as particularidades de distribuição, outsourcing de impressão e locação de equipamentos.',
                'video_url' => 'https://databit.com.br/wp-content/uploads/2024/12/Caue2.mp4',
                'video_person' => 'Cauê',
                'video_role' => 'Diretor',
            ],
            [
                'company' => 'Mapel',
                'location' => 'Belo Horizonte/MG',
                'client_since' => 2014,
                'highlight' => 'Destaque por contribuir muito na qualidade e eficiência das nossas soluções. Cliente passou por SAP e TOTVS. Tem um alto nível de exigência, com foco em otimização de processos e confiabilidade nos dados. A vivência e experiência com as grandes de mercado nos ajudou muito na evolução com qualidade.',
                'video_url' => 'https://databit.com.br/wp-content/uploads/2024/12/Depoimento-Giovani-Mapel.mp4',
                'video_person' => 'Giovanni Pimenta',
                'video_role' => 'CEO',
            ],
            [
                'company' => 'Maqlarem',
                'location' => 'João Pessoa',
                'client_since' => 2017,
                'highlight' => 'Destaque pela cultura de investimento em evolução tecnológica e de processos. Usam praticamente todas as soluções que lançamos. Com o tempo, a parceria foi se consolidando e, com as dores deles, foi onde se materializou o projeto DataClient.',
                'video_url' => null,
                'video_person' => null,
                'video_role' => null,
            ],
            [
                'company' => 'Apnet',
                'location' => 'Rio de Janeiro',
                'client_since' => 2019,
                'highlight' => 'Destaque pelo uso eficiente da ferramenta. Alcançou um alto nível de maturidade com nossas soluções em pouco tempo. Passou por SAP. E com menos de 1 ano com a nossa ferramenta, ultrapassou em muito o nível de gestão que tinha com o SAP.',
                'video_url' => null,
                'video_person' => null,
                'video_role' => null,
            ],
            [
                'company' => 'Tinsei',
                'location' => 'Belo Horizonte',
                'client_since' => 2022,
                'highlight' => 'Destaque pela velocidade da implantação, maturidade com o ERP e crescimento contínuo de gestão, com os dados do ERP. Cliente com foco em importação e distribuição. Saiu do TOTVS e está em amplo crescimento com nossa ferramenta.',
                'video_url' => 'https://databit.com.br/wp-content/uploads/2024/12/Depoimento-Tinsei-Bragi.mp4',
                'video_person' => 'Marcela Tavares',
                'video_role' => 'Marketing',
            ],
        ];

        foreach ($items as $index => $item) {
            SuccessStory::firstOrCreate(
                ['company' => $item['company']],
                [
                    ...$item,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    // Presença de clientes por estado (Brasil) e por país (fora do Brasil),
    // usada no mapa "Databit pelo Brasil e além" da página inicial. Os números
    // são estimativas ilustrativas, editáveis pelo painel (Conteúdo > Presença
    // de Clientes) até que a Databit forneça a contagem real por região.
    private function seedClientPresences(): void
    {
        $stateDeviceCounts = [
            'MG' => 1050, 'SP' => 700, 'RJ' => 340, 'PR' => 150, 'BA' => 180,
            'RS' => 130, 'PE' => 140, 'CE' => 120, 'GO' => 100, 'SC' => 110,
            'DF' => 90, 'ES' => 80, 'PB' => 95, 'MT' => 70, 'PA' => 60,
            'RN' => 45, 'MS' => 55, 'AM' => 40, 'MA' => 35, 'PI' => 30,
            'AL' => 30, 'SE' => 25, 'TO' => 20, 'RO' => 18, 'AC' => 12,
            'AP' => 10, 'RR' => 8,
        ];

        $states = collect(require resource_path('data/brazil-states.php'))['states'];

        foreach ($states as $index => $state) {
            ClientPresence::firstOrCreate(
                ['region_type' => ClientPresence::TYPE_STATE, 'code' => $state['code']],
                [
                    'region_type' => ClientPresence::TYPE_STATE,
                    'code' => $state['code'],
                    'name' => $state['name'],
                    'device_count' => $stateDeviceCounts[$state['code']] ?? 0,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        $countries = [
            ['code' => 'MX', 'name' => 'México', 'device_count' => 110],
            ['code' => 'US', 'name' => 'Estados Unidos', 'device_count' => 90],
        ];

        foreach ($countries as $index => $country) {
            ClientPresence::firstOrCreate(
                ['region_type' => ClientPresence::TYPE_COUNTRY, 'code' => $country['code']],
                [
                    'region_type' => ClientPresence::TYPE_COUNTRY,
                    'code' => $country['code'],
                    'name' => $country['name'],
                    'device_count' => $country['device_count'],
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
                    .'<ul><li>WhatsApp: (31) 3416-8225</li><li>E-mail: atendimento@databit.com.br</li><li>Telefone: (31) 3416-8225</li></ul>'
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
