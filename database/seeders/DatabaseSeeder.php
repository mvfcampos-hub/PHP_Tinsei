<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Campaign;
use App\Models\CampaignEpisode;
use App\Models\CouncilGroup;
use App\Models\CouncilMember;
use App\Models\DocumentTemplate;
use App\Models\DocumentTemplateFile;
use App\Models\EducationInstitution;
use App\Models\EventItem;
use App\Models\Faq;
use App\Models\FiscalizacaoProcess;
use App\Models\FiscalizacaoRegionStat;
use App\Models\FiscalizacaoStat;
use App\Models\Inspector;
use App\Models\JobListing;
use App\Models\LibraryDocument;
use App\Models\LibraryDocumentFile;
use App\Models\Licitacao;
use App\Models\LicitacaoDocument;
use App\Models\Magazine;
use App\Models\MenuItem;
use App\Models\MunicipalityProfessionalCount;
use App\Models\News;
use App\Models\NutritionStory;
use App\Models\Page;
use App\Models\PodeNaoPodeQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Conteúdo institucional (páginas, menu, equipe de fiscalização) migrado
 * a partir do site oficial https://crn9.org.br/ em 24/07/2026. Notícias,
 * vagas e revistas trazem uma amostra real para validar os módulos —
 * o restante do histórico deve ser cadastrado pelo time do CRN-9 via
 * painel administrativo (Filament).
 */
class DatabaseSeeder extends Seeder
{
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
        $this->linkIndexPages();
        $this->seedMenu();
        $this->seedCampaigns();
        $this->seedNews($admin);
        $this->seedEvents();
        $this->seedBanners();
        $this->seedJobs();
        $this->seedMagazines();
        $this->seedInspectors();
        $this->seedMunicipalityCounts();
        $this->seedCouncil();
        $this->seedLicitacoes();
        $this->seedEducationInstitutions();
        $this->seedLibraryDocuments();
        $this->seedFaqs();
        $this->seedPodeNaoPode();
        $this->seedNutritionStories();
        $this->seedDocumentTemplates();
        $this->seedFiscalizacaoStats();
        $this->seedFiscalizacaoProcesses();
        $this->seedFiscalizacaoRegionStats();
    }

    /**
     * Copia uma imagem real (migrada de crn9.org.br) empacotada em
     * database/seeders/assets/ para o disco público, se ainda não existir.
     */
    private function seedImage(string $sourceRelativePath, string $storageRelativePath): string
    {
        if (! Storage::disk('public')->exists($storageRelativePath)) {
            $absolute = __DIR__.'/assets/'.$sourceRelativePath;
            Storage::disk('public')->put($storageRelativePath, file_get_contents($absolute));
        }

        return $storageRelativePath;
    }

    private function seedPages(): void
    {
        $iv = [
            'conceito' => $this->seedImage('identidade-visual/conceito-da-marca.jpg', 'identidade-visual/conceito-da-marca.jpg'),
            'cores' => $this->seedImage('identidade-visual/paleta-cores.jpg', 'identidade-visual/paleta-cores.jpg'),
            'tipografia' => $this->seedImage('identidade-visual/tipografia.png', 'identidade-visual/tipografia.png'),
            'tagline' => $this->seedImage('identidade-visual/assinatura-tagline.jpg', 'identidade-visual/assinatura-tagline.jpg'),
            'preferencial' => $this->seedImage('identidade-visual/versao-preferencial.jpg', 'identidade-visual/versao-preferencial.jpg'),
            'horizontal' => $this->seedImage('identidade-visual/versao-horizontal.jpg', 'identidade-visual/versao-horizontal.jpg'),
            'fundos' => $this->seedImage('identidade-visual/versoes-fundo.jpg', 'identidade-visual/versoes-fundo.jpg'),
            'grafismos' => $this->seedImage('identidade-visual/grafismos.jpg', 'identidade-visual/grafismos.jpg'),
        ];
        foreach ($iv as $key => $path) {
            $iv[$key] = Storage::url($path);
        }

        $identidadeVisualContent = <<<HTML
            <p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) é o órgão público responsável por garantir e desenvolver a qualidade dos serviços prestados pelos profissionais de Nutrição (Nutricionistas e Técnicos em Nutrição e Dietética). Em 2020, após um processo elaborado "a muitas mãos", o CRN-9 lançou sua nova identidade visual e novo site, mantida como referência oficial da marca neste projeto.</p>
            <h2>Conceito da marca</h2>
            <p><img src="{$iv['conceito']}" alt="Conceito da marca CRN-9" style="max-width:100%;height:auto;" loading="lazy"></p>
            <h2>Paleta de cores</h2>
            <p>O estudo de cores da marca busca equilibrar jovialidade, credibilidade, proximidade e seriedade:</p>
            <ul>
                <li><strong>Verde jovial</strong> #A3A64A — contraponto entre jovialidade e credibilidade.</li>
                <li><strong>Verde sóbrio</strong> #5C5E2B — tom mais sóbrio, reforça a credibilidade.</li>
                <li><strong>Laranja</strong> #F58C4A — referência ao humano, trabalha a proximidade com o público.</li>
                <li><strong>Azul luminoso</strong> #85B0FF — traz seriedade e credibilidade, em tom luminoso.</li>
            </ul>
            <p><img src="{$iv['cores']}" alt="Paleta de cores da marca CRN-9" style="max-width:100%;height:auto;" loading="lazy"></p>
            <h2>Construção da marca</h2>
            <p>A marca do CRN-9 foi construída visando trazer, em seu símbolo, os conceitos de proximidade, simplicidade e fluidez. O símbolo gráfico apresenta formas orgânicas e fluidas dispostas de modo a compor uma paisagem natural aconchegante. Aliado a esse símbolo, a identidade visual apresenta uma tipografia que reforça a jovialidade, leveza e legibilidade da marca.</p>
            <h2>Tipografia</h2>
            <p>A tipografia construída especialmente para a marca CRN-9 apresenta um desenho geométrico e amplo, um traçado fino que emprega leveza à sua forma, e quinas arredondadas para trazer proximidade.</p>
            <p><img src="{$iv['tipografia']}" alt="Tipografia da marca CRN-9" style="max-width:100%;height:auto;" loading="lazy"></p>
            <h2>Assinatura de marca</h2>
            <p>Completando a assinatura de marca, temos a <em>tagline</em> com o nome do CRN-9 escrito por extenso, em uma tipografia também geométrica com grande legibilidade.</p>
            <p><img src="{$iv['tagline']}" alt="Assinatura completa da marca CRN-9" style="max-width:100%;height:auto;" loading="lazy"></p>
            <h2>Versões da marca</h2>
            <p>Para trazer mais dinamicidade e adaptabilidade em sua aplicação nas peças de comunicação, a marca CRN-9 possui 3 versões diferentes:</p>
            <p><strong>Preferencial</strong></p>
            <p><img src="{$iv['preferencial']}" alt="Versão preferencial da marca CRN-9" style="max-width:100%;height:auto;" loading="lazy"></p>
            <p><strong>Horizontal</strong></p>
            <p><img src="{$iv['horizontal']}" alt="Versão horizontal da marca CRN-9" style="max-width:100%;height:auto;" loading="lazy"></p>
            <p>Cada uma dessas versões apresenta diversas opções de aplicação em relação às suas cores, permitindo que a marca seja aplicada em fundos claros e escuros, em diversas tonalidades:</p>
            <p><img src="{$iv['fundos']}" alt="Versões da marca em fundos claros e escuros" style="max-width:100%;height:auto;" loading="lazy"></p>
            <h2>Elementos extensivos</h2>
            <p>Para completar a identidade visual do CRN-9, foi elaborado um conjunto de elementos extensivos, que têm como objetivo reforçar os conceitos presentes na marca. Como extensão do símbolo gráfico, os elementos extensivos são inspirados nos alimentos, montanhas e nas mineiridades. As composições possíveis com os elementos extensivos podem e devem variar — desde que dentro da paleta cromática do projeto — trazendo ainda mais versatilidade e personalização.</p>
            <p><img src="{$iv['grafismos']}" alt="Elementos gráficos extensivos da marca CRN-9" style="max-width:100%;height:auto;" loading="lazy"></p>
            <h2>Tipografia do site</h2>
            <p>O site institucional utiliza a família <strong>Poppins</strong> para títulos e destaques, e <strong>Open Sans</strong> para textos correntes — mantendo a leveza e a legibilidade da identidade original.</p>
            <p>A nova identidade visual do CRN-9 e o site original foram criados pela Amí Comunicação &amp; Design.</p>
            HTML;

        $pages = [
            [
                'title' => 'Identidade Visual do CRN-9',
                'slug' => 'identidade-visual-do-crn-9',
                'content' => $identidadeVisualContent,
            ],
            [
                'title' => 'Links Importantes',
                'slug' => 'links-importantes',
                'content' => <<<'HTML'
                    <h2>Legislação e Ética Profissional</h2>
                    <ul>
                    <li><a href="https://www.cfn.org.br/wpcontent/uploads/resolucoes/Res_599_2018.html" target="_blank" rel="noopener">Resolução CFN 599/2018 — CÓDIGO DE ÉTICA E CONDUTA DO NUTRICIONISTA</a></li>
                    <li><a href="https://www.cfn.org.br/wp-content/uploads/resolucoes/Res_333_2004.htm" target="_blank" rel="noopener">Resolução CFN nº 333/2010 — Código de ética do TND</a></li>
                    </ul>
                    <h2>Órgãos e Entidades Parceiras</h2>
                    <ul>
                    <li><a href="http://www.cfn.org.br" target="_blank" rel="noopener">CFN — Conselho Federal de Nutricionistas</a></li>
                    <li><a href="http://www.fnn.org.br" target="_blank" rel="noopener">FNN — Federação Nacional de Nutricionistas</a></li>
                    <li><a href="http://www.asbran.org.br" target="_blank" rel="noopener">ASBRAN — Associação Brasileira de Nutrição</a></li>
                    <li><a href="http://portal.anvisa.gov.br" target="_blank" rel="noopener">ANVISA</a></li>
                    <li><a href="http://www.saude.gov.br" target="_blank" rel="noopener">MINISTÉRIO DA SAÚDE</a></li>
                    <li><a href="http://nutricao.saude.gov.br" target="_blank" rel="noopener">CGPAN — Coordenação Geral da Política de Alimentação e Nutrição</a></li>
                    <li><a href="http://www.planalto.gov.br/consea" target="_blank" rel="noopener">CONSEA — Conselho Nacional de Segurança Alimentar</a></li>
                    <li><a href="http://www.fnde.gov.br/" target="_blank" rel="noopener">FNDE — Fundo Nacional de Desenvolvimento da Educação</a></li>
                    <li><a href="http://www.mte.gov.br/pat/" target="_blank" rel="noopener">PAT — Programa de Alimentação do Trabalhador</a></li>
                    <li><a href="http://www.mda.gov.br" target="_blank" rel="noopener">MDA — Ministério do Desenvolvimento Agrário</a></li>
                    <li><a href="http://www.mds.gov.br/" target="_blank" rel="noopener">MDS — Ministério do Desenvolvimento Social e Combate a Fome</a></li>
                    <li><a href="http://www.rebrae.com.br/" target="_blank" rel="noopener">REBRAE — Rede Brasileira de Alimentação e Nutrição Escolar</a></li>
                    </ul>
                    <h2>Materiais de Educação Alimentar e Nutricional</h2>
                    <ul>
                    <li><a href="http://189.28.128.100/dab/docs/portaldab/publicacoes/guia_da_crianca_2019.pdf" target="_blank" rel="noopener">Guia Alimentar para Crianças Brasileiras Menores de 2 Anos</a></li>
                    <li><a href="https://bvsms.saude.gov.br/bvs/publicacoes/guia_alimentar_populacao_brasileira_2ed.pdf" target="_blank" rel="noopener">Guia Alimentar para População Brasileira</a></li>
                    <li><a href="https://cnn.cfn.org.br/application/index/consulta-nacional" target="_blank" rel="noopener">Consulta Nacional de Nutricionitas — Consulta de Nutricionistas Ativos</a></li>
                    <li><a href="https://www.cfn.org.br/wp-content/uploads/2020/03/nota_coronavirus_3-1.pdf" target="_blank" rel="noopener">Covid-19 — Resoluções CFN</a></li>
                    </ul>
                    <h2>Legislação do Sistema CFN/CRN e da Profissão</h2>
                    <ul>
                    <li><a href="http://www.planalto.gov.br/ccivil_03/leis/1970-1979/L6583.htm" target="_blank" rel="noopener">LEI 6583/1978 — Cria o Sistema CFN – CRN</a></li>
                    <li><a href="https://www2.camara.leg.br/legin/fed/decret/1980-1987/decreto-84444-30-janeiro-1980-433856-publicacaooriginal-1-pe.html" target="_blank" rel="noopener">Decreto 84.444/1980 — Regulamenta o Sistema CFN – CRN</a></li>
                    <li><a href="http://www.planalto.gov.br/ccivil_03/leis/1989_1994/L8234.htm" target="_blank" rel="noopener">Lei 8234/1991 — Regulamenta a Profissão de Nutricionista</a></li>
                    <li><a href="http://crn9.org.br/content/uploads/2014/09/Res_600_2018.pdf" target="_blank" rel="noopener">Resolução CFN 600/2018 — Definição das áreas de atuação do nutricionista e suas atribuições</a></li>
                    <li><a href="https://www.cfn.org.br/wp-content/uploads/resolucoes/Res_465_2010.htm" target="_blank" rel="noopener">Resolução CFN 465/2010 — Programa Nacional de Alimentação Escolar – PNAE</a></li>
                    <li><a href="https://www.cfn.org.br/wpcontent/uploads/resolucoes/Res_378_2005.htm" target="_blank" rel="noopener">Resolução CFN 378/2005 — LEGISLAÇÃO SOBRE MODALIDADE DE INSCRIÇÃO DA EMPRESA/INSTITUIÇÃO NO CRN9</a></li>
                    <li><a href="http://www.cfn.org.br/wp-content/uploads/resolucoes/Res_576_2016.htm" target="_blank" rel="noopener">Resolução CFN 576/2016 — LEGISLAÇÃO SOBRE SOLICITAÇÃO, ANÁLISE, CONCESSÃO E ANOTAÇÃO DE RESPONSABILIDADE TÉCNICA</a></li>
                    <li><a href="https://www.cfn.org.br/wp-content/uploads/resolucoes/Res_604_2018.html" target="_blank" rel="noopener">Resolução CFN nº 604/2018 — LEGISLAÇÃO SOBRE O TÉCNICO EM NUTRIÇÃO E DIETÉTICA (TND)</a></li>
                    <li><a href="https://www.cfn.org.br/wp-content/uploads/resolucoes/Res_605_2018.htm" target="_blank" rel="noopener">Resolução CFN nº 604/2018 — Áreas de atuação e atribuições do TND</a></li>
                    </ul>
                    <h2>Área de Alimentação Coletiva — Tabelas de Composição de Alimentos</h2>
                    <ul>
                    <li><a href="http://www.tbca.net.br/" target="_blank" rel="noopener">Tabelas de Composição de Alimentos para Elaboração de Cardápio: Tabela TACO</a></li>
                    <li><a href="https://biblioteca.ibge.gov.br/visualizacao/livros/liv50002.pdf" target="_blank" rel="noopener">Tabelas de Composição de Alimentos para Elaboração de Cardápio: Tabela IBGE</a></li>
                    <li><a href="http://tabnut.dis.epm.br/" target="_blank" rel="noopener">Tabelas de Composição de Alimentos para Elaboração de Cardápio: Tabela Online UNIFESP</a></li>
                    </ul>
                    <h2>Programa de Alimentação do Trabalhador (PAT)</h2>
                    <ul>
                    <li><a href="https://www.gov.br/trabalho/pt-br/assuntos/fiscalizacao/programa-de-alimentacao-do-trabalhador-pat/sistema-pat" target="_blank" rel="noopener">Informações Gerais sobre o PAT</a></li>
                    <li><a href="http://www3.mte.gov.br/sistemas/patnet/" target="_blank" rel="noopener">Novo link para consulta do PAT</a></li>
                    <li><a href="http://189.28.128.100/nutricao/docs/legislacao/portaria66_25_08_06.pdf" target="_blank" rel="noopener">Parâmetros nutricionais do PAT</a></li>
                    <li><a href="http://plataforma.redesan.ufrgs.br/biblioteca/pdf_bib.php?COD_ARQUIVO=14603" target="_blank" rel="noopener">Orientações para Educação Nutricional no PAT</a></li>
                    <li><a href="http://www.in.gov.br/materia/-/asset_publisher/Kujrw0TZC2Mb/content/id/23174647" target="_blank" rel="noopener">PORTARIA Nº 1.274, DE 7 DE JULHO DE 2016</a></li>
                    </ul>
                    <h2>Manual de Boas Práticas de Manipulação e POPs</h2>
                    <ul>
                    <li><a href="http://portal.anvisa.gov.br/documents/33916/388704/RESOLU%25C3%2587%25C3%2583O-RDC%2BN%2B216%2BDE%2B15%2BDE%2BSETEMBRO%2BDE%2B2004.pdf/23701496-925d-4d4d-99aa-9d479b316c4b" target="_blank" rel="noopener">RDC 216/04 sobre o regulamento técnicos de boas práticas para serviços de alimentação</a></li>
                    <li><a href="http://portal.anvisa.gov.br/documents/10181/2718376/RDC_275_2002_COMP.pdf/fce9dac0-ae57-4de2-8cf9-e286a383f254" target="_blank" rel="noopener">RDC 275/02 sobre o regulamento técnicos de POPs e verificação de boas práticas de fabricação em estabelecimentos produtores/industrializadores de alimentos</a></li>
                    <li><a href="http://www.ceasaminas.com.br/agroqualidade/portaria1428.asp" target="_blank" rel="noopener">Portaria ANVISA 1428/93   que trata sobre o &quot;Regulamento Técnico para Inspeção Sanitária de Alimentos&quot;, as &quot;Diretrizes para o Estabelecimento de Boas Práticas de Produção e de Prestação de Serviços (...)</a></li>
                    <li><a href="http://portal.anvisa.gov.br/documents/33916/389979/Guia+de+Boas+Pr%C3%A1ticas+Nutricionais+para+Restaurantes+Coletivos/ce2a88ce-94da-4a09-8cae-19fb9596c3d6" target="_blank" rel="noopener">Guia de Boas Práticas Nutricionais para Restaurantes Coletivos</a></li>
                    <li><a href="http://189.28.128.100/dab/docs/portaldab/publicacoes/guia_elaboracao_refeicoes_saudaveis.pdf" target="_blank" rel="noopener">Guia para a elaboração de refeições saudáveis em eventos</a></li>
                    <li><a href="http://www.in.gov.br/materia/-/asset_publisher/Kujrw0TZC2Mb/content/id/32825363/do1-2015-09-02-resolucao-rdc-n-43-de-1-de-setembro-de-2015-32825340" target="_blank" rel="noopener">RDC Nº 43/2015 - Dispõe sobre a prestação de serviços de alimentação em eventos de massa</a></li>
                    <li><a href="http://portal.anvisa.gov.br/documents/33916/389979/Boas%2Bpraticas%2Bnutricionais.pdf/4cdbc1ed-a68b-4dd4-9dd7-099de516dd3f" target="_blank" rel="noopener">Guia de Boas Práticas Nutricionais – Documento de Referência</a></li>
                    <li><a href="http://www.sindinutrisp.org.br/2014/arquivos/infoarquivo/773.pdf" target="_blank" rel="noopener">MBP e POP - Modelo básico para orientação profissional (sindinutrisp)</a></li>
                    <li><a href="http://www2.crn4.org.br/pg/comunicacao/publicacoesdocrn-4" target="_blank" rel="noopener">Guia de elaboração de boas práticas para manipulação de alimentos</a></li>
                    <li><a href="http://portal.anvisa.gov.br/documents/10181/5321364/MODELO+DE+MANUAL+DE+BOAS+PR%C3%81TICAS+PARA+BANCOS+DE+ALIMENTOS/25ade91a-1b6f-44a9-afba-64f9eb1bce0a?version=1.0" target="_blank" rel="noopener">Modelo de Manual de Boas Práticas para Banco de Alimentos</a></li>
                    <li><a href="http://www.anvisa.gov.br/scriptsweb/anvisalegis/VisualizaDocumento.asp?ID=2243&amp;Versao=1" target="_blank" rel="noopener">RDC 23/2000 — Sobre o Manual de Procedimentos Básicos para Registro e Dispensa da Obrigatoriedade de Registro de Produtos Pertinentes à Área de Alimentos</a></li>
                    <li><a href="https://www.camara.leg.br/proposicoesWeb/prop_mostrarintegra?codteor=440852&amp;filename=Legislacao" target="_blank" rel="noopener">Lei 10.674/2003 — Sobre a obrigatoriedade de informar a presença de glúten nos rótulos dos alimentos</a></li>
                    <li><a href="http://bvsms.saude.gov.br/bvs/saudelegis/anvisa/2003/anexo/anexo_res0359_23_12_2003.pdf" target="_blank" rel="noopener">RDC 359/2003 — Sobre Regulamento Técnico de Porções de Alimentos Embalados para Fins de Rotulagem Nutricional</a></li>
                    <li><a href="http://portal.anvisa.gov.br/documents/33880/2568070/res0360_23_12_2003.pdf/5d4fc713-9c66-4512-b3c1-afee57e7d9bc" target="_blank" rel="noopener">RDC 360/2003 — Sobre o regulamento técnico de porções de alimentos para fins de rotulagem nutricional</a></li>
                    <li><a href="http://portal.anvisa.gov.br/documents/%2033880/2568070/rdc0054_12_11_2012.pdf/c5ac23fd-974e-4f2c-9fbc-48f7e0a31864" target="_blank" rel="noopener">RDC 54/2012 — Sobre o Regulamento Técnico sobre Informação Nutricional Complementar</a></li>
                    <li><a href="http://portal.anvisa.gov.br/documents/10181/2694583/RDC_26_2015_.pdf/b0a1e89b-e23d-452f-b029-a7bea26a698c" target="_blank" rel="noopener">RDC 26/2015 — Sobre os requisitos para rotulagem obrigatória dos principais alimentos que causam alergias alimentares</a></li>
                    <li><a href="http://www.in.gov.br/materia/-/asset_publisher/Kujrw0TZC2Mb/content/id/20794620/do1-2017-02-09-resolucao-rdc-n-136-de-8-de-fevereiro-de-2017-20794494" target="_blank" rel="noopener">RDC 136/2017 — Estabelece os requisitos para declaração obrigatória da presença de lactose nos rótulos dos alimentos</a></li>
                    <li><a href="http://www.agricultura.gov.br/assuntos/inspecao/produtos-vegetal/legislacao-1/biblioteca-de-normas-vinhos-e-bebidas/portaria-no-326-de-30-de-julho-de-1997.pdf/view" target="_blank" rel="noopener">Portaria 326/97 — Sobre as Boas Práticas de Fabricação para estabelecimentos produtores/industrializadores de alimentos</a></li>
                    <li><a href="http://portal.anvisa.gov.br/documents/33916/389979/Guia+de+Boas+Pr%C3%A1ticas+Nutricionais+para+P%C3%A3o+Franc%C3%AAs/a389f51c-7e4c-4496-a1dd-33de55a48ae1" target="_blank" rel="noopener">Guia de Boas Práticas Nutricionais Para o Pão Francês</a></li>
                    </ul>
                    <h2>Área de Alimentação Escolar (PNAE)</h2>
                    <ul>
                    <li><a href="https://www.fnde.gov.br/index.php/acesso-a-informacao/institucional/legislacao/item/13511-resolu%C3%A7%C3%A3o-n%C2%BA-6,-de-08-de-maio-de-2020" target="_blank" rel="noopener">Resolução/CD/FNDE 06/2020</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/ferramentas-de-apoio-ao-nutricionista/item/12820-plan-pnae-ferramenta-de-planejamento-de-card%C3%A1pio" target="_blank" rel="noopener">Ferramenta de Planejamento de Cardápio - PLAN PNAE</a></li>
                    <li><a href="http://www.fnde.gov.br/index.php/acessibilidade/item/12142-iq-cosan" target="_blank" rel="noopener">Índice de Qualidade – Coordenação de Segurança Alimentar e Nutricional – IQ COSAN</a></li>
                    <li><a href="http://www.ufrgs.br/cecane/downloads/" target="_blank" rel="noopener">Manual de Orientação para a Alimentação Escolar na Educação Infantil, Ensino Fundamental, Ensino Médio e na Educação de Jovens e Adultos</a></li>
                    <li><a href="http://www.fnde.gov.br/component/k2/item/10532-31-de-mar%C3%A7o-de-2017" target="_blank" rel="noopener">Caderno de Referência - Alimentação Escolar para Estudantes com necessidades alimentares especiais</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-notas-tecnicas-pareceres-relatorios" target="_blank" rel="noopener">Links para diversas Notas Técnicas | Pareceres | Relatórios</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-notas-tecnicas-pareceres-relatorios" target="_blank" rel="noopener">NOTA TÉCNICA Alterações dos aspectos da Agricultura Familiar da Resolução CD/FNDE (...)</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-notas-tecnicas-pareceres-relatorios" target="_blank" rel="noopener">NOTA TÉCNICA Nº 1894784/2020/COSAN/CGPAE/DIRAE - Atualização das recomendações para o planejamento de cardápios das creches atendidas pelo Programa Nacional de Alimentação Escolar – PNAE.</a></li>
                    <li><a href="https://www.cfn.org.br/wp-content/uploads/2015/07/Parecer-do-CFN-sobre-merenda-escolar.pdf" target="_blank" rel="noopener">Parecer CFN sobre inclusão do café na merenda escolar</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas/item/5166-manual-para-aplica%C3%A7%C3%A3o-dos-testes-de-aceitabilidade-no-pnae" target="_blank" rel="noopener">Manual para aplicação dos testes de aceitabilidade no PNAE</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas/item/10491-pnae-agricultura-familiar-2016" target="_blank" rel="noopener">PNAE – Agricultura Familiar</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas/item/11122-boas-pr%C3%A1ticas-de-agricultura-familiar-para-a-alimenta%C3%A7%C3%A3o-escolar" target="_blank" rel="noopener">Boas práticas de agricultura familiar para a alimentação escolar</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas/item/11122-boas-pr%C3%A1ticas-de-agricultura-familiar-para-a-alimenta%C3%A7%C3%A3o-escolar" target="_blank" rel="noopener">Boas práticas de agricultura familiar para a alimentação escolar</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas/item/8595-manual-de-aquisi%C3%A7%C3%A3o-de-produtos-da-agricultura-familiar-para-a-alimenta%C3%A7%C3%A3o-escolar" target="_blank" rel="noopener">Manual de Aquisição de Produtos da Agricultura Familiar para a Alimentação Escolar</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas/item/5842-folder-pnae" target="_blank" rel="noopener">Folders PNAE</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas?limitstart=0" target="_blank" rel="noopener">Manuais e Cartilhas PNAE</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas?start=10" target="_blank" rel="noopener">Manual de apoio para as atividades técnicas do Nutricionista no  mbito do PNAE</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas/item/9483-manual-orientativo-para-forma%C3%A7%C3%A3o-de-manipuladores-de-alimentos" target="_blank" rel="noopener">Manual orientativo para formação de manipuladores de alimentos</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas/item/6805-manual-de-instru%C3%A7%C3%B5es-para-o-cadastro-de-nutricionistas-no-simec" target="_blank" rel="noopener">Manual de instruções para o cadastro de nutricionistas no SIMEC</a></li>
                    <li><a href="https://www.fnde.gov.br/index.php/programas/pnae/pnae-area-gestores/pnae-manuais-cartilhas/item/5320-ferramenta-de-boas-pr%C3%A1ticas-de-fabrica%C3%A7%C3%A3o-de-alimentos" target="_blank" rel="noopener">Manual de Boas Práticas na Alimentação Escolar</a></li>
                    <li><a href="http://www.ufrgs.br/cecane/downloads/" target="_blank" rel="noopener">Materiais de Apoio disponíveis pelo Centro Colaborador em Alimentação e Nutrição do Escolar (CECANE) da UFRGS</a></li>
                    <li><a href="http://cecanesc.ufsc.br/core/getarquivo/idarquivo/685" target="_blank" rel="noopener">Programa para Elaboração de Manual de Boas Práticas — Plano de trabalho anual específico das atividades</a></li>
                    <li><a href="http://www.fao.org/3/a-i7519o.pdf" target="_blank" rel="noopener">Material de Educação alimentar e nutricional para escolares — Manual de Educação Alimentar e Nutricional Através da Horta Escolar</a></li>
                    <li><a href="http://189.28.128.100/dab/docs/portaldab/publicacoes/caderno_atividades_educacao_infantil.pdf" target="_blank" rel="noopener">Caderno de Atividades - Promoção da Alimentação Adequada e Saudável - Educação Infantil</a></li>
                    <li><a href="http://189.28.128.100/dab/docs/portaldab/publicacoes/caderno_atividades_ensino_fundamental_I.pdf" target="_blank" rel="noopener">Caderno de Atividades - Promoção da Alimentação Adequada e Saudável - Ensino Fundamental I</a></li>
                    <li><a href="https://bvsms.saude.gov.br/bvs/publicacoes/planos_aula.pdf" target="_blank" rel="noopener">Educação nutricional para alunos do ensino fundamental</a></li>
                    <li><a href="http://189.28.128.100/dab/docs/portaldab/documentos/manual_do_aluno.pdf" target="_blank" rel="noopener">Manual do aluno: promovendo a alimentação saudável</a></li>
                    </ul>
                    HTML,
            ],
            ['title' => 'O CRN-9', 'slug' => 'o-crn-9', 'content' => <<<'HTML'
                <p>O CONSELHO REGIONAL DE NUTRIÇÃO DA 9ª REGIÃO é uma autarquia sem fins lucrativos, de interesse público, com poder delegado pela União para orientar, disciplinar e fiscalizar o exercício e as atividades da profissão de Nutricionista e Técnico em Nutrição e Dietética no estado de Minas Gerais, em defesa da sociedade. É um órgão do Sistema Conselho Federal de Nutrição/Conselhos Regionais de Nutrição (CFN/CRN).</p>
                <p>O Sistema CFN/CRN tem como órgão central o Conselho Federal de Nutrição (CFN) e é integrado, atualmente, por onze Conselhos Regionais de Nutrição que representam os diversos Estados brasileiros. O Sistema se mantém com a arrecadação proveniente de anuidades, taxas, multas e emolumentos (taxa cobrada pela expedição de um documento), recolhidos por pessoas físicas (nutricionistas e técnicos) e jurídicas (empresas e instituições). Do montante de recursos arrecadados em todos os onze regionais, 20% é destinado ao CFN.</p>
                <p>O CRN-9 atua em Minas Gerais, tendo sua sede em Belo Horizonte e cinco delegacias, nas cidades de Juiz de Fora, Montes Claros, Pouso Alegre, Uberlândia e Ipatinga.</p>
                <h2>Documentos "Eleições CRN9 2020"</h2>
                <ul>
                <li><a href="https://crn9.org.br/wp-content/uploads/2021/01/Chamamento-Publico.pdf" target="_blank" rel="noopener">Chamamento Público – Comissão Eleitoral Pleito 2020/2023</a></li>
                <li><a href="https://crn9.org.br/wp-content/uploads/2021/01/DOU-Edital-01-Aviso-Eleicoes-Pleito-2020-2023.pdf" target="_blank" rel="noopener">DOU Edital 01 – Aviso Eleições Pleito 2020-2023</a></li>
                <li><a href="https://crn9.org.br/wp-content/uploads/2021/01/DOU-Edital-01-Aviso-Eleicoes-Pleito-2020-2023-Pagina-02.pdf" target="_blank" rel="noopener">DOU Edital 01 – Aviso Eleições Pleito 2020-2023 – Página 02</a></li>
                <li><a href="https://crn9.org.br/wp-content/uploads/2021/01/Edital_0067065_DOU___Edital_3___Registro_Definitivo_das_Chapas.pdf" target="_blank" rel="noopener">DOU Edital 03 – Registro Definitivo das Chapas</a></li>
                <li><a href="https://crn9.org.br/wp-content/uploads/2021/01/DOU_Edital_04-Resultado-Eleicoes.pdf" target="_blank" rel="noopener">DOU Edital 04 – Resultado das Eleições</a></li>
                </ul>
                HTML,
            ],
            ['title' => 'Política de Ingresso', 'slug' => 'politica-de-ingresso', 'content' => <<<'HTML'
                <ul>
                <li>Projeto "Comida de Verdade na Escola – A importância da Nutrição e da Agricultura Familiar no Programa Nacional de Alimentação Escolar – PNAE"
                <ul>
                <li><a href="https://crn9.org.br/wp-content/uploads/2021/02/ETAPA-SELECAO-BOLSISTAS-2021____________.pdf" target="_blank" rel="noopener">Etapa Seleção de Bolsistas</a></li>
                <li><a href="https://crn9.org.br/wp-content/uploads/2021/02/SELECAO-DE-BOLSISTAS-CHAMAMENTO-PARA-ENTREVISTA.pdf" target="_blank" rel="noopener">Seleção de Bolsistas – Chamamento para entrevista</a></li>
                <li><a href="https://crn9.org.br/wp-content/uploads/2021/02/Bolsistas-apos-as-entrevistas.xlsx" target="_blank" rel="noopener">Resultado da seleção de Bolsistas</a></li>
                <li><a href="https://crn9.org.br/wp-content/uploads/2021/02/CRONOGRAMA-SELECAO-BOLSISTAS_.pdf" target="_blank" rel="noopener">Cronograma de seleção de bolsistas</a></li>
                <li><a href="https://crn9.org.br/wp-content/uploads/2021/02/Relacao_0261897_RESULTADO_BOLSISTAS_PROJETO_COMIDA_VERDADE.pdf" target="_blank" rel="noopener">Resultado homologado após o prazo recursal</a></li>
                </ul>
                </li>
                </ul>
                HTML,
            ],
            ['title' => 'Concurso Público', 'slug' => 'concurso-publico', 'content' => <<<'HTML'
                <h4>• Qual a forma de ingresso no CRN9?</h4>
                <p>O CRN9 é uma Autarquia Federal e, dessa forma, parte integrante da Administração Pública Indireta. Conforme o art. 37, II, da Constituição Federal, a investidura em cargo ou emprego público depende de aprovação prévia em concurso público de provas ou de provas e títulos, ressalvadas as nomeações para cargo em comissão declarado em lei de livre nomeação e exoneração.</p>
                <h4>• Fui aprovado no concurso. Tenho garantia de que serei convocado?</h4>
                <p>Não. Os candidatos aprovados serão convocados conforme a necessidade do órgão, durante o período de vigência do concurso.</p>
                <h4>• O que é o cadastro de reserva?</h4>
                <p>O cadastro de reserva, ou banco de aprovados, é utilizado para contratações futuras do órgão, quando a Administração Pública não tem certeza de quantos servidores serão necessários para seu quadro de pessoal, ou quantas vagas vão surgir durante a validade do concurso (dois anos contados a partir de 19/02/2020, com possibilidade de prorrogação por igual período). O cadastro de reserva funciona como uma “fila de espera”.</p>
                <h4>Atenção: O concurso 01/2019, homologado em 20/02/2020, foi prorrogado até 19/02/2024.</h4>
                <h4>• Como são feitas as convocações dos candidatos aprovados?</h4>
                <p>As convocações são feitas por meio de publicação no Diário Oficial da União (DOU) e envio de correspondência e/ou e-mail para o candidato. Para isso, é importante que o mesmo mantenha seus dados atualizados junto ao CRN9 pelo endereço eletrônico crn9@crn9.org.br.</p>
                <h4>• Como posso acompanhar as convocações do concurso do CRN9?</h4>
                <p>No Portal de Transparência do CRN9: <a target="_blank" rel="noopener" href="https://crn-mg.implanta.net.br/portaltransparencia/#publico/Listas?id=d01136e8-28ae-4ac7-bb39-4aa351709161">Portal da Transparência </a></p>
                <h4>• Qual o quadro atual de funcionários do CRN9?</h4>
                <p>No Portal de Transparência do CRN9: <a target="_blank" rel="noopener" href="https://crn-mg.implanta.net.br/portaltransparencia/#publico/Conteudos?id=aa1437dd-3a16-4bca-96f2-cdd5e3c8803e">Portal da Transparência</a></p>
                HTML,
            ],
            ['title' => 'Sede e Delegacias', 'slug' => 'sede-delegacias', 'content' => '<h3>Sede CRN-9 – Belo Horizonte</h3><p>Edifício Celta — R. Maranhão, 310, 4º Andar, Santa Efigênia, Belo Horizonte/MG — CEP: 30150-330</p>
<h3>Delegacia de Ipatinga</h3><p>Edifício Horto Office — R. Vinhático, 15, Sala 707, Horto, Ipatinga/MG — CEP: 35160-317</p>
<h3>Delegacia de Juiz de Fora</h3><p>Edifício Bancantil — R. Halfed, 651, Sala 1406, Centro, Juiz de Fora/MG — CEP: 36010-902</p>
<h3>Delegacia de Montes Claros</h3><p>Edifício Premier Center — R. Correia Machado, 1025, Salas 1305 e 1306, Centro, Montes Claros/MG — CEP: 39400-090</p>
<h3>Delegacia de Pouso Alegre</h3><p>Edifício Pouso Alegre Shopping Center — R. Coronel Otávio Meyer, 160, Salas 224 e 225, Centro, Pouso Alegre/MG — CEP: 37550-068</p>
<h3>Delegacia de Uberlândia</h3><p>Edifício Executivo — R. Coronel Antônio Alves Pereira, 400, Sala 915, Centro, Uberlândia/MG — CEP: 38400-104</p>'],
            ['title' => 'Fale Conosco', 'slug' => 'fale-conosco', 'content' => '<p>Rua Maranhão, 310, 4º Andar, Santa Efigênia, Belo Horizonte/MG — CEP: 30150-330</p>
<p>Funcionamento: das 9h às 17h</p>
<p>Telefone: (31) 3226-8403</p>
<p>E-mail: crn9@crn9.org.br</p>'],
            ['title' => 'Ouvidoria', 'slug' => 'ouvidoria', 'content' => '<p>A Ouvidoria do CRN-9 é um canal exclusivo para o registro de sugestões, elogios, reclamações ou denúncias quanto aos serviços prestados pelo Conselho e que não tenham sido atendidos no prazo regulamentar pelos canais de atendimento.</p>
<p>Registre sua manifestação no sistema E-OUV do Governo Federal.</p>'],
            ['title' => 'Convênios', 'slug' => 'convenios', 'content' => '<p>A Qualicorp trabalha em parceria com diversos órgãos públicos e entidades de classe para oferecer benefícios em saúde para os profissionais inscritos no CRN-9 e seus familiares.</p>
<p>Consulte as condições vigentes diretamente com a Qualicorp Saúde.</p>'],
            ['title' => 'Projetos de Lei em Andamento', 'slug' => 'projetos-de-lei-em-andamento', 'content' => '<p>Acompanhamento dos Projetos de Lei de interesse da categoria, monitorados pelo Conselho Federal de Nutricionistas (CFN) em conjunto com os Conselhos Regionais.</p>'],
            ['title' => 'CRN-9 Divulga', 'slug' => 'crn9-divulga', 'content' => '<p>O "CRN-9 Divulga" reúne pesquisas, levantamentos e materiais técnicos produzidos ou apoiados pelo Conselho, de interesse para a categoria e para a sociedade. Confira alguns dos temas já divulgados:</p>
<h3><a href="https://docs.google.com/forms/d/e/1FAIpQLSfgTTnLakzcngTcDGAhXG2RXLGjQh0bUyjdnYIFTLkvy7wwZA/viewform" target="_blank" rel="noopener">Hábitos de consumo de alimentos, leitura de rótulos e compras on-line durante a pandemia de COVID-19</a></h3>
<h3><a href="https://docs.google.com/forms/d/e/1FAIpQLSf80nDeikb_Oi2IyMGDgzPSwnhvn0I2b1d6K620550EDjXZHQ/viewform" target="_blank" rel="noopener">Utilização das Tecnologias de Informação e Comunicação (TICs) nas diferentes áreas de atuação do nutricionista</a></h3>
<h3><a href="https://docs.google.com/forms/d/e/1FAIpQLSfMj-jPYxOnbWD27qCNg3ntzijsMUT48eNXV8NkRCktQl_WQA/viewform" target="_blank" rel="noopener">Pesquisa sobre o perfil dos consumidores de produtos de origem animal no Brasil e sua percepção sobre impacto ambiental, bem-estar, qualidade e saúde</a></h3>'],
            ['title' => 'Denúncia', 'slug' => 'denuncia', 'content' => <<<'HTML'
                <p>O CRN-9 recebe e analisa denúncias contra Nutricionistas e Técnicos em Nutrição e Dietética inscritos neste Regional, contra profissionais sem inscrição regular, contra leigos que exerçam ilegalmente a profissão e contra Pessoas Jurídicas. Escolha abaixo o tipo de denúncia:</p>
                <ul>
                <li><a href="/paginas/denuncia-etica">Denúncia ética contra nutricionistas e técnicos</a> — para condutas de profissionais regularmente inscritos que possam configurar infração ético-disciplinar.</li>
                <li><a href="/paginas/denuncia-sem-inscricao">Denúncia contra nutricionistas e técnicos que atuam sem inscrição</a> — para profissionais formados que exercem a profissão com a inscrição cancelada, suspensa, baixada ou nunca regularizada no CRN-9.</li>
                <li><a href="/paginas/denuncia-leigo">Denúncia contra leigo que atua como nutricionista</a> — para pessoas sem formação em Nutrição, ou de outra profissão, exercendo ilegalmente a profissão.</li>
                <li><a href="/paginas/denuncia-pessoa-juridica">Denúncia contra pessoa jurídica</a> — para empresas e instituições que atuam em desacordo com a legislação do exercício profissional.</li>
                </ul>
                HTML,
            ],
            ['title' => 'Denúncia Ética contra Nutricionistas e Técnicos', 'slug' => 'denuncia-etica', 'content' => <<<'HTML'
                <p>O CRN-9 recebe e analisa denúncias éticas contra Nutricionistas e Técnicos em Nutrição e Dietética inscritos neste Regional. Caso a apuração resulte na detecção de conduta com indícios de infração disciplinar, são tomadas providências para abertura de Processo Disciplinar.</p>
                <p>Os trâmites do Processo Disciplinar devem seguir o procedimento estabelecido na <a href="http://resolucao.cfn.org.br/" target="_blank" rel="noopener">Resolução CFN nº 705 de 16/09/2021</a>, que institui o Código de Processamento Disciplinar para o Nutricionista e o Técnico em Nutrição e Dietética.</p>
                <h3>A denúncia ético-disciplinar deverá indicar (Art. 24)</h3>
                <ul>
                <li>Identificação completa do autor da denúncia: nome completo, documento oficial com foto, CPF, endereço atualizado com CEP, telefone e e-mail;</li>
                <li>Descrição circunstanciada e objetiva dos fatos com informações que caracterizem ou possam vir a caracterizar eventual infração ético-disciplinar;</li>
                <li>Nome, número de inscrição no CRN, qualificação e endereço do denunciado;</li>
                <li>Elementos mínimos de prova;</li>
                <li>Nome das testemunhas e suas qualificações, quando houver (até 3).</li>
                </ul>
                <p>A ausência dos elementos indicados nos itens acima poderá obstar o conhecimento da denúncia. As denúncias anônimas serão conhecidas desde que seguidas de diligências mínimas para averiguar os fatos noticiados. O denunciante pode optar pela não divulgação dos seus dados, com sigilo da identidade, imagem e dados pessoais garantido pelo Conselho.</p>
                <p><strong>Atenção:</strong> denúncia comprovadamente falsa ou sem fundamento pode configurar o crime tipificado no art. 339 do Código Penal (reclusão de dois a oito anos, e multa).</p>
                <p><a href="https://form.jotformz.com/91133592437660" target="_blank" rel="noopener">Ir para o formulário de denúncia ética</a></p>
                HTML,
            ],
            ['title' => 'Denúncia contra Nutricionistas e Técnicos sem Inscrição', 'slug' => 'denuncia-sem-inscricao', 'content' => <<<'HTML'
                <p>Esta categoria é destinada a denúncias contra profissionais formados em Nutrição ou em Nutrição e Dietética (Técnicos) que estejam exercendo a profissão sem inscrição regular no CRN-9 — por exemplo, com inscrição cancelada, suspensa, baixada temporariamente sem reativação, ou que nunca tenha sido solicitada.</p>
                <p>Diferente da denúncia ética (para profissionais já inscritos) e da denúncia contra leigos (para quem não tem formação em Nutrição), este canal trata especificamente da irregularidade cadastral de quem já possui a formação, mas atua fora da situação regular exigida pela <a href="https://cfn.org.br/legislacao/" target="_blank" rel="noopener">Lei Federal nº 8.234/1991</a>.</p>
                <h3>A denúncia deverá indicar, preferencialmente</h3>
                <ul>
                <li>Nome completo, telefone, e-mail ou outra forma de contato do denunciante;</li>
                <li>Nome completo do profissional denunciado e, se souber, o número de inscrição anterior ou motivo da irregularidade (ex.: inscrição cancelada, baixa temporária vencida);</li>
                <li>Descrição circunstanciada do fato: local, período e forma de atuação observada;</li>
                <li>Provas ou indícios (documentos, fotos, capturas de tela, testemunhas), sempre que houver;</li>
                <li>Disponibilidade do denunciante para prestar esclarecimentos, se necessário.</li>
                </ul>
                <h3>Informações importantes</h3>
                <p>A apuração é conduzida pela equipe de fiscalização do CRN-9, que pode notificar o profissional para regularização imediata da inscrição ou, conforme o caso, para abertura de processo por exercício ilegal da profissão. Os atos processuais têm caráter sigiloso, e denúncias anônimas são aceitas desde que acompanhadas de elementos mínimos que permitam a apuração.</p>
                <p><a href="https://form.jotform.com/250764901956667" target="_blank" rel="noopener">Ir para o formulário de denúncia</a></p>
                HTML,
            ],
            ['title' => 'Denúncia contra Leigo que Atua como Nutricionista', 'slug' => 'denuncia-leigo', 'content' => <<<'HTML'
                <p>Esta categoria é destinada a denúncias contra pessoas sem formação em Nutrição — ou profissionais de outras áreas — que exerçam ilegalmente a profissão de nutricionista ou de técnico em nutrição e dietética.</p>
                <p>As denúncias contra leigos e/ou outros profissionais no exercício ilegal da profissão, para tramitar neste Conselho, deverão conter preferencialmente:</p>
                <ul>
                <li>Nome completo, profissão, telefone, e-mail ou outra forma de contato do denunciante;</li>
                <li>Descrição circunstanciada e objetiva do fato e identificação da relação do denunciante com o fato descrito;</li>
                <li>Possível legislação transgredida;</li>
                <li>Indicação de provas ou indícios dos fatos com dados que permitam apuração, tais como data e local onde ocorreram os fatos, nome completo do denunciado e de testemunhas (quando houver), acompanhado de endereço ou outra forma de contato;</li>
                <li>Provas documentais ou materiais, sempre que houver;</li>
                <li>Disponibilidade do denunciante para comparecer ao Conselho para esclarecimentos ou depoimentos.</li>
                </ul>
                <h3>Informações importantes</h3>
                <p>Os atos processuais relativos à apuração de denúncia têm caráter sigiloso. Denúncias acolhidas serão previamente apuradas e, havendo constatação de indícios de exercício ilegal, farão parte de processo que poderá ser encaminhado ao Ministério Público ou ao Conselho de Classe Profissional competente (caso o infrator pertença a outra categoria profissional). Denúncias anônimas ou com solicitação de sigilo serão recebidas, mas se as informações forem insuficientes e/ou sem indícios mínimos de prova estarão sujeitas ao arquivamento.</p>
                <p>As denúncias também podem ser feitas mediante o preenchimento do formulário abaixo e envio das provas pelos correios ou pelo e-mail crn9@crn9.org.br.</p>
                <p><a href="https://form.jotform.com/250764901956667" target="_blank" rel="noopener">Ir para o formulário de denúncia</a></p>
                HTML,
            ],
            ['title' => 'Denúncia contra Pessoa Jurídica', 'slug' => 'denuncia-pessoa-juridica', 'content' => <<<'HTML'
                <p>As denúncias contra Pessoas Jurídicas (empresas) deverão ser realizadas, preferencialmente, por meio do preenchimento do formulário próprio abaixo, que também pode ser encaminhado pelo correio, por e-mail (crn9@crn9.org.br) ou entregue pessoalmente na sede ou nas delegacias do CRN9.</p>
                <p>Alguns campos deverão ser obrigatoriamente preenchidos:</p>
                <ul>
                <li>Razão Social;</li>
                <li>Endereço Completo;</li>
                <li>Motivo(s) da denúncia.</li>
                </ul>
                <h3>Informações importantes</h3>
                <p>Após a apuração dos fatos, o denunciante será informado, por meio de ofício ou e-mail, sobre a ação do Regional — a identificação do denunciante torna-se, assim, fundamental. Excepcionalmente serão aceitas denúncias anônimas contra empresas, tendo em vista a preocupação do CRN-9 com a saúde da população e a qualidade dos serviços prestados.</p>
                <p><a href="https://form.jotform.com/250765127632659" target="_blank" rel="noopener">Ir para o formulário de denúncia – Pessoa Jurídica</a></p>
                HTML,
            ],
            ['title' => 'Política Nacional de Fiscalização', 'slug' => 'politica-nacional-de-fiscalizacao', 'content' => '<p>A Política Nacional de Fiscalização (PNF), estabelecida pela Resolução CFN 527/2013, fornece as diretrizes das ações de fiscalização no âmbito do sistema CFN/CRNs, determinando que a fiscalização do exercício profissional deva estar pautada em uma conduta orientadora além de fiscalizadora.</p>
<h3>Objetivos principais</h3>
<ul><li>Assegurar à sociedade que a assistência alimentar e nutricional seja prestada por Nutricionistas habilitados;</li><li>Buscar, de forma permanente, a segurança e a qualidade dos produtos e serviços relacionados à alimentação e nutrição;</li><li>Orientar os Nutricionistas e Técnicos em Nutrição e Dietética, contribuindo para a segurança alimentar e nutricional dos indivíduos.</li></ul>'],
            ['title' => 'Atividades da Fiscalização', 'slug' => 'atividades-da-fiscalizacao', 'content' => '<p>Além das visitas fiscais e da apuração de denúncias, a equipe de fiscalização do CRN9 realiza:</p>
<ul>
<li>Visitas técnicas de orientação do exercício profissional;</li>
<li>Visitas de rotina nos municípios de abrangência;</li>
<li>Ações estratégicas de fiscalização (2 por ano), com objetivo de traçar panoramas da atuação profissional;</li>
<li>Apuração de denúncias contra pessoas físicas e jurídicas;</li>
<li>Plantões fiscais de orientação on-line;</li>
<li>Reconhecimento de trabalhos de excelência (Projeto Nutricionista/Equipe 5 Estrelas).</li>
</ul>'],
            ['title' => 'Visitas Técnicas', 'slug' => 'visitas-tecnicas', 'content' => '<p>As fiscais do CRN9 realizam visitas técnicas de orientação do exercício profissional, com o objetivo de orientar o nutricionista em seu local de trabalho e melhorar a qualidade do serviço prestado. As visitas são, geralmente, agendadas previamente por telefone, e-mail ou durante uma visita fiscal.</p>
<p>O instrumento utilizado é o Roteiro de Visita Técnica (RVT), padronizado pelo CFN e específico para cada área de atuação, conforme as Resoluções CFN nº 465/2010 e nº 600/2018. A visita técnica também pode ser solicitada pelo próprio profissional.</p>'],
            ['title' => 'Orientações On-line', 'slug' => 'orientacoes-online', 'content' => '<p>A videoconferência é um importante canal de atendimento realizado pelos fiscais do CRN9 — uma alternativa ao atendimento telefônico e presencial.</p>
<p>Agende com o fiscal responsável pela sua região.</p>'],
            ['title' => 'Dúvidas Frequentes (Fiscalização)', 'slug' => 'duvidas-frequentes-fiscalizacao', 'content' => '<p>A Responsabilidade Técnica exercida pelo Nutricionista é o compromisso profissional e legal na execução de suas atividades, compatível com a formação e os princípios éticos da profissão, visando à qualidade dos serviços prestados à sociedade.</p>
<p>O profissional assume o planejamento, coordenação, direção, supervisão e avaliação na área de alimentação e nutrição, pautado nas Normas Técnicas e no Código de Ética dos Nutricionistas. A assunção de Responsabilidade Técnica deve ser solicitada através de formulário próprio; o afastamento por mais de 30 dias também deve ser comunicado ao CRN.</p>
<p>Para mais esclarecimentos, consulte a Resolução CFN nº 576/2016 e as Resoluções CFN nº 645 a 650/2020, que tratam de prazos de anuidade, atendimento não presencial e Carteira de Identidade Profissional.</p>'],
            ['title' => 'O que é Fiscalização', 'slug' => 'o-que-e-fiscalizacao', 'content' => '<p>A fiscalização do exercício profissional é uma das competências legais do CRN-9, prevista na Lei nº 6.583/1978 e na Lei nº 8.234/1991, que instituíram o Sistema CFN/CRN. Fiscalizar é, antes de tudo, proteger a sociedade: garantir que a assistência alimentar e nutricional seja prestada por profissionais habilitados, dentro de condições técnicas e éticas adequadas.</p>
<p><strong>Fiscalizar também é orientar.</strong> A Política Nacional de Fiscalização (Resolução CFN nº 527/2013) determina que a atuação da fiscalização seja pautada por uma conduta orientadora, e não apenas punitiva — priorizando a prevenção de irregularidades e o apoio técnico ao profissional e às instituições.</p>
<p>Conheça as demais frentes desta área: <a href="/paginas/areas-de-atuacao-fiscalizadas">Áreas de Atuação Fiscalizadas</a>, <a href="/paginas/atividades-da-fiscalizacao">Como Funciona a Fiscalização</a>, <a href="/fiscalizacao">Quadro Técnico</a> e <a href="/fiscalizacao/em-numeros">Fiscalização em Números</a>.</p>'],
            ['title' => 'Áreas de Atuação Fiscalizadas', 'slug' => 'areas-de-atuacao-fiscalizadas', 'content' => '<p>Conforme a Resolução CFN nº 380/2005, a fiscalização do CRN-9 alcança o exercício profissional em todas as áreas de atuação do(a) nutricionista e do(a) técnico(a) em Nutrição e Dietética:</p>
<ul>
<li><strong>Alimentação Coletiva:</strong> Unidades de Alimentação e Nutrição (UAN), restaurantes, cozinhas industriais, alimentação escolar e alimentação do trabalhador;</li>
<li><strong>Nutrição Clínica:</strong> hospitais, clínicas, consultórios, Instituições de Longa Permanência para Idosos (ILPI), bancos de leite humano e atendimento domiciliar;</li>
<li><strong>Saúde Coletiva:</strong> políticas e programas institucionais, atenção básica e vigilância sanitária;</li>
<li><strong>Docência</strong> nos cursos de graduação em Nutrição;</li>
<li><strong>Indústria de Alimentos</strong>, no desenvolvimento e controle de qualidade de produtos;</li>
<li><strong>Nutrição em Esportes</strong>, em academias e clubes esportivos;</li>
<li><strong>Marketing na área de Alimentação e Nutrição.</strong></li>
</ul>
<p>Em todas essas áreas, a fiscalização verifica, entre outros pontos, a existência de Responsabilidade Técnica regularmente registrada e o cumprimento dos parâmetros normativos de cada atividade.</p>'],
            ['title' => 'Responsabilidade Técnica', 'slug' => 'responsabilidade-tecnica', 'content' => '<p>A Responsabilidade Técnica (RT) é o compromisso profissional e legal assumido pelo(a) nutricionista pelo planejamento, coordenação, direção, supervisão e avaliação dos serviços de alimentação e nutrição de uma instituição, nos termos da Resolução CFN nº 576/2016 e do Código de Ética e Conduta (Resolução CFN nº 599/2018).</p>
<h3>Como assumir a Responsabilidade Técnica</h3>
<p>A assunção de RT é feita por meio de formulário próprio junto ao CRN-9. O afastamento por período superior a 30 dias — férias, licenças ou outros motivos — também deve ser formalmente comunicado ao Conselho, com indicação de substituto quando aplicável.</p>
<h3>Deveres do Responsável Técnico</h3>
<ul>
<li>Elaborar e manter atualizado o Manual de Boas Práticas do serviço;</li>
<li>Zelar pelo cumprimento das normas técnicas e sanitárias aplicáveis à atividade;</li>
<li>Detectar e comunicar ao hierárquico superior e às autoridades competentes condições que coloquem em risco a saúde da coletividade atendida (veja o <a href="/ferramentas/modelos">modelo de Laudo de Notificação de Irregularidades</a>);</li>
<li>Colaborar com as autoridades de fiscalização profissional e sanitária.</li>
</ul>
<p>Dúvidas frequentes sobre o tema estão disponíveis em <a href="/paginas/duvidas-frequentes-fiscalizacao">Dúvidas Frequentes (Fiscalização)</a> e na ferramenta <a href="/pode-ou-nao-pode">Pode ou Não Pode?</a>.</p>'],
            ['title' => 'Exercício Ilegal da Profissão', 'slug' => 'exercicio-ilegal-da-profissao', 'content' => '<p>O exercício ilegal da profissão ocorre quando uma pessoa sem habilitação e sem inscrição regular no CRN-9 realiza atividades privativas do(a) nutricionista ou do(a) técnico(a) em Nutrição e Dietética — como elaborar prescrição dietética, planos alimentares individualizados ou assumir Responsabilidade Técnica por um serviço de alimentação e nutrição — nos termos dos artigos 3º e 4º da Lei nº 8.234/1991.</p>
<p>Essa prática coloca em risco a saúde da população, por não haver garantia de formação técnica e compromisso ético na orientação prestada, e é passível de apuração pelo CRN-9, inclusive com encaminhamento ao Ministério Público quando cabível.</p>
<p>Se você identificar uma situação de exercício ilegal da profissão, utilize o canal específico: <a href="/paginas/denuncia-leigo">Denúncia contra Leigo que Atua como Nutricionista</a>.</p>'],
            ['title' => 'Relatórios da Fiscalização', 'slug' => 'relatorios-da-fiscalizacao', 'content' => '<p>O CRN-9 consolida periodicamente os resultados do trabalho da equipe de fiscalização, reunindo indicadores como visitas realizadas, orientações prestadas e denúncias apuradas, como parte do compromisso com a transparência das ações do Conselho junto à categoria e à sociedade.</p>
<p>Acesse o painel consolidado em <a href="/fiscalizacao/em-numeros">Fiscalização em Números</a>. Relatórios de gestão e prestação de contas mais amplos do CRN-9 estão disponíveis no Portal da Transparência.</p>'],
            ['title' => 'Projetos Especiais da Fiscalização', 'slug' => 'projetos-especiais-fiscalizacao', 'content' => '<p>Além das visitas de rotina e da apuração de denúncias, a equipe de fiscalização do CRN-9 desenvolve projetos temáticos voltados ao aprimoramento do exercício profissional em áreas específicas, entre eles:</p>
<ul>
<li><strong>Aprimoramento da atuação da(o) Nutricionista em Instituições de Longa Permanência para Idosos (ILPI):</strong> projeto que traça panorama do cuidado nutricional oferecido a idosos em ILPIs de Minas Gerais, com produção de material orientativo para os profissionais responsáveis técnicos;</li>
<li><strong>Projeto Portas Abertas:</strong> aproximação entre o CRN-9 e as Instituições de Ensino Superior (IES) de Nutrição, com apresentação da constituição e do funcionamento do Conselho a estudantes concluintes;</li>
<li><strong>Ações Estratégicas de Fiscalização:</strong> realizadas periodicamente para traçar panoramas da atuação profissional em áreas ou regiões específicas do estado;</li>
<li><strong>Nutricionista/Equipe 5 Estrelas:</strong> reconhecimento de trabalhos de excelência identificados pela fiscalização durante suas visitas.</li>
</ul>'],
            ['title' => 'Serviços para Nutricionistas', 'slug' => 'servicos-nutricionistas', 'content' => '<p>Serviços disponíveis para Nutricionistas inscritos no CRN-9: valores e datas da anuidade, inscrição provisória e definitiva, prorrogação e cancelamento de inscrição, baixa temporária, transferência, reativação de inscrição, registro do Título de Especialista e Anotação de Responsabilidade Técnica.</p>
<p>Consulte o serviço desejado e os documentos necessários com a Secretaria do CRN-9.</p>'],
            ['title' => 'Serviços para Técnicos em Nutrição e Dietética', 'slug' => 'servicos-tnd', 'content' => '<p>Serviços disponíveis para Técnicos em Nutrição e Dietética (TND) inscritos no CRN-9: valores e datas da anuidade, inscrição provisória e definitiva (validade de 12 meses), prorrogação e cancelamento de inscrição, baixa temporária, transferência e reativação de inscrição.</p>'],
            ['title' => 'Serviços para Pessoa Jurídica', 'slug' => 'servicos-pessoa-juridica', 'content' => '<p>Empresas e instituições que prestam serviços de alimentação e nutrição (restaurantes, indústrias de alimentos, clínicas, hospitais, escolas, entre outras) devem se registrar no CRN-9 e manter um Nutricionista como Responsável Técnico.</p>
<p>Principais serviços disponíveis para Pessoa Jurídica:</p>
<ul>
<li>Pagamento da Anuidade Pessoa Jurídica;</li>
<li>Registro e cadastro de empresas junto ao Conselho;</li>
<li>Anotação e cancelamento de Responsabilidade Técnica;</li>
<li>Emissão de Certidão de Registro e de Atestado de Capacidade Técnica;</li>
<li>Atualização cadastral de dados da empresa.</li>
</ul>
<p>Para orientações detalhadas sobre cada serviço, entre em contato com a Secretaria do CRN-9.</p>'],
            ['title' => 'Oportunidade de Emprego', 'slug' => 'oportunidade-de-emprego', 'content' => '<p>O CRN-9 divulga, como cortesia, oportunidades de emprego para Nutricionistas e Técnicos em Nutrição e Dietética enviadas por empresas e instituições.</p>
<p>Confira as vagas ativas no <a href="/vagas">Banco de Oportunidades</a> ou cadastre uma nova oportunidade entrando em contato com a Secretaria do CRN-9.</p>'],
            ['title' => 'Anuidade 2026 Nutricionistas', 'slug' => 'servico-anuidade-2026-nutricionista', 'content' => '<p>Emita o boleto da anuidade 2026 clicando AQUI .</p>
<p>Nutricionista: R$ 595,66 (quinhentos e noventa e cinco reais, sessenta e seis centavos)</p>
<p>FORMAS DE PAGAMENTO:</p>
<p>EM COTA ÚNICA até 10/07/2026, ou em 10 PARCELAS com os seguintes vencimentos: 10/02, 10/03, 10/04, 10/05, 10/06 e 10/07, 10/08, 10/09, 10/10 e 10/11/2026</p>
<p>COM DESCONTO DE 15% para vencimento cota única em 10/02/2026: Nutricionista: R$ 506,31 (quinhentos e seis reais, trinta e um centavos).</p>
<ol><li>O PAGAMENTO DA ANUIDADE DE 2026 NÃO QUITA DÉBITOS ANTERIORES.</li><li>MANTENHA SEUS DADOS ATUALIZADOS NO CRN9. ACESSE O ATENDIMENTO ONLINE OU ENVIE UM E-MAIL PARA pf.atendimento@crn9.org.br.</li><li>ACESSE ATENDIMENTO ONLINE e tenha uma série de serviços, tais como:</li></ol>
<ul><li>Atualização Cadastral;</li><li>Emissão de Certidão;</li><li>Emissão de 2ª via de boleto bancário, entre outros.</li></ul>
<p>RESOLUÇÃO CFN Nº 829, DE 1º DE DEZEMBRO DE 2025</p>
<p>Consulte o documento que dispõe sobre normas gerais aplicáveis às anuidades, critérios para reajustes, opções de pagamentos e critérios de cobrança.</p>
<p>Documento PDF</p>'],
            ['title' => 'Inscrição Provisória – Nutricionista', 'slug' => 'servico-inscricao-provisoria-pf-nutri', 'content' => '<p>Atenção: leia todas as orientações com cuidado antes de preencher os dados cadastrais.</p>
<h3>Tipo de Inscrição:</h3>
<p>A primeira inscrição do profissional poderá ser provisória ou definitiva, dependendo da documentação acadêmica.</p>
<p>Inscrição Provisória – Tem validade de 2 (dois) anos. Esta inscrição é destinada ao profissional que possui certificado ou declaração de conclusão de curso, com a data em que colou grau, de curso reconhecido pelo MEC; ou ao portador de diploma, com a data em que colou grau emitido por instituição de ensino superior em processo de reconhecimento regular de acordo com os termos da Portaria Normativa MEC nº 23/2017 ou outra que vier a substitui-la.</p>
<p>Inscrição Definitiva – Tem validade indeterminada. Esta inscrição é destinada ao portador de diploma registrado no órgão de ensino competente, obtido em instituição com curso reconhecido pelo Ministério da Educação (MEC), nos termos da Portaria Normativa MEC nº 23/2017 ou outra que vier a substitui-la.</p>
<h3>Documentos necessários:</h3>
<ul><li>“Ficha de Inscrição” devidamente preenchida e assinada ( manualmente ou eletronicamente pela conta no gov.br);</li><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos (documentos expedidos há mais de 10 anos não serão aceitos) e com o nome civil atual e nome social, caso exista;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia, não sendo aceitas imagens geradas por inteligência artificial (IA) . Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Digital do polegar direito reproduzida em papel branco, sem pauta, com tinta preta;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li><li>Declaração de Conclusão de Curso, constando a data em que colou de grau;</li><li>Cópia de comprovante de endereço atual;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome.</li></ul>
<p>Para mais detalhes, confira as orientações completas:</p>
<p>Clique aqui para conferir as orientações</p>
<h3>Link de inscrição: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>Valores a serem quitados:</h3>
<p>Anuidade do ano corrente (R$ 595,66) proporcional (o cálculo será realizado considerando-se o mês do recebimento da solicitação de inscrição até dezembro).</p>
<p>Obs: Será concedido desconto de 50% (cinquenta por cento) do valor da primeira anuidade cobrada no ato da primeira inscrição (anuidades posteriores serão cobradas integralmente) aos recém-formados que requererem a inscrição profissional até 365 (trezentos e sessenta e cinco) dias após a data de colação de grau.</p>
<h3>Observações importantes:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>Após ativação da inscrição, será cobrada anuidade independente de sua efetiva atuação profissional;</li><li>O boleto da anuidade proporcional será fornecido apenas após confirmação dos dados do diploma junto ao estabelecimento de ensino. Este contato será realizado pelo próprio CRN-9 após a solicitação de inscrição e recebimento dos documentos solicitados;</li><li>A inscrição será ativada em até 30 (trinta) dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido.</li></ul>'],
            ['title' => 'Inscrição de provisória para definitiva – Nutricionista', 'slug' => 'servico-inscricao-de-provisoria-para-definitiva-nutri', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Ficha de Inscrição” devidamente preenchida e assinada (manualmente ou eletronicamente pela conta no gov.br);</li><li>Cópia do Diploma (frente e verso) devidamente registrado e assinado pela instituição de ensino e pelo profissional(quando houver campo específico);</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li><li>Cópia de comprovante de endereço atual – em caso de alteração de domicílio;</li><li>Cópia de Certidão de casamento ou averbação de divórcio – em caso de alteração do nome.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>Após ativação da inscrição, será cobrada anuidade independente de sua efetiva atuação profissional;</li><li>A inscrição será ativada em até 30 (trinta) dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido.</li></ul>'],
            ['title' => 'Inscrição Definitiva – Nutricionista', 'slug' => 'servico-inscricao-definitiva-pf-nutri', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Ficha de Inscrição” devidamente preenchida e assinada (manualmente ou eletronicamente pela conta no gov.br);</li><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos e com o nome civil atual e nome social, caso exista;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Digital do polegar direito reproduzida em papel branco, sem pauta, com tinta preta;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de mínimo 150 dpi e tamanho máximo de 5 MB;</li><li>Cópia do Diploma (frente e verso) devidamente registrado e assinado pela instituição de ensino e pelo profissional (quando houver campo específico);</li><li>Cópia de comprovante de endereço atual;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<h3>VALORES A SEREM QUITADOS:</h3>
<p>Anuidade do ano corrente (R$ 566,32) proporcional (o cálculo será realizado considerando-se o mês do recebimento da solicitação de inscrição até dezembro).</p>
<p>Obs.: Será concedido desconto de 50% (cinquenta por cento) do valor da primeira anuidade cobrada no ato da primeira inscrição (anuidades posteriores serão cobradas integralmente) aos recém-formados que requererem a inscrição profissional até 365 (trezentos e sessenta e cinco) dias após a data de colação de grau.</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>Após ativação da inscrição, será cobrada anuidade independente de sua efetiva atuação profissional;</li><li>O boleto da anuidade proporcional será fornecido apenas após confirmação dos dados do diploma junto ao estabelecimento de ensino. Este contato será realizado pelo próprio CRN-9 após a solicitação de inscrição e recebimento da documentação completa;</li><li>A inscrição será ativada em até 30 (trinta) dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido.</li></ul>'],
            ['title' => 'Transferência – Nutricionista', 'slug' => 'servico-transferencia-pf-nutri', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Ficha de Inscrição” devidamente preenchida e assinada (manualmente ou eletronicamente pela conta no gov.br);</li><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos e com o nome civil atual e nome social, caso exista;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Digital do polegar direito reproduzida em papel branco, sem pauta, com tinta preta;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li><li>Cópia do Diploma (frente e verso) devidamente registrado e assinado pela instituição de ensino e pelo profissional (quando houver campo específico);</li><li>Certidão de Regularidade, emitida nos últimos 30 (trinta) dias, fornecida pelo CRN onde o profissional tem inscrição originária, na qual constem dados do inscrito, além da informação de estar o mesmo quite com todas as suas obrigações;</li><li>Cópia de comprovante de endereço atual;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome;</li><li>Declaração de responsabilidade do profissional.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<p>A carteira profissional do CRN de origem deverá ser entregue pessoalmente ou via correios, na sede ou delegacias do CRN-9. Se preferir, pode ser devolvida ao CRN de origem.</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>O profissional deverá entrar em contato com o CRN de origem para verificar possíveis pendências (exemplos: débito, processos administrativo ou vínculos de trabalho em aberto) e saná-las, para que o pedido de transferência não seja indeferido;</li><li>O boleto da anuidade do ano corrente, caso esta não tenha sido quitado no CRN de origem, será enviad0, por e-mail, após ativação de inscrição;</li><li>A inscrição será ativada em até 30 dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido.</li><li>O profissional poderá atuar até que seu processo de transferência seja concluído, utilizando a inscrição do CRN de origem e com protocolo do pedido de transferência em mãos;</li><li>Após ativação da inscrição, será cobrada anuidade independente de sua efetiva atuação profissional.</li></ul>'],
            ['title' => 'Inscrição secundária – Nutricionista', 'slug' => 'servico-inscricao-secundaria-pf-nutri', 'content' => '<p>A inscrição secundária é destinada a profissionais já inscritos em um CRN que desejam exercer atividades presenciais em uma jurisdição diferente por mais de 90 dias (consecutivos ou intercalados) no mesmo ano civil. O profissional deve obrigatoriamente solicitar esta inscrição junto ao CRN da nova jurisdição onde irá atuar.</p>
<p>Conforme RESOLUÇÃO CFN N° 795, DE 16 DE SETEMBRO DE 2024</p>
<p>Art. 15. O CRN poderá anotar responsabilidade técnica ou a responsabilidade pelas atividades de alimentação e nutrição humana para nutricionista com inscrição secundária ativa, sem prejuízo das demais disposições desta Resolução, mediante apresentação de:</p>
<p>I – certidão de regularidade emitida pelo Regional de origem;</p>
<p>II – declaração (ões) de responsabilidades anotadas, emitida(s) pelo(s) Regional(is) em que estiver inscrito ( Anexo V )</p>
<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Ficha de Inscrição” devidamente preenchida e assinada (manualmente ou eletronicamente pela conta no gov.br);</li><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos e com o nome civil atual e nome social, caso exista;</li><li>Certidão de Regularidade, emitida nos últimos 30 (trinta) dias, fornecida pelo CRN onde o profissional tem inscrição originária, na qual constem dados do inscrito, além da informação de estar o mesmo quite com todas as suas obrigações;</li><li>Cópia digital da Carteira de Identidade Profissional definitiva ou provisória do CRN de origem;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Digital do polegar direito reproduzida em papel branco, sem pauta, com tinta preta;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li><li>Cópia do Diploma (frente e verso) devidamente registrado e assinado pela instituição de ensino e pelo profissional (quando houver campo específico);</li><li>Cópia de comprovante de endereço atual;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<h3>VALORES A SEREM QUITADOS:</h3>
<p>Anuidade de inscrição secundária do ano corrente (R$ 119,13) proporcional (o cálculo será realizado considerando-se o mês do recebimento da solicitação de inscrição até dezembro).</p>
<p>Conforme RESOLUÇÃO CFN N° 829, DE 1° de dezembro DE 2025</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>A inscrição será ativada em até 30 dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido.</li></ul>'],
            ['title' => 'Prorrogação de inscrição provisória – Nutricionista', 'slug' => 'servico-prorrogacao-de-inscricao-provisoria', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<p>A inscrição provisória poderá ser prorrogada durante o período de vigência da inscrição provisória ativa, de preferência em até 15 (quinze) dias antes do término da validade.</p>
<p>Inscrições provisórias vencidas não poderão ser prorrogadas. Neste caso, deverá ser requerida uma nova (link para inscrição definitiva nutricionista).</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Formulário Prorrogação de Inscrição (CLIQUE AQUI)” devidamente preenchid0 e assinad0 (manualmente ou eletronicamente pela conta no gov.br);</li><li>Declaração de Conclusão de Curso recente, constando a data em que colou grau;</li><li>Cópia de comprovante de endereço atual;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>A inscrição será ativada em até 30 (trinta) dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido.</li></ul>'],
            ['title' => 'Baixa Temporária – Nutricionista', 'slug' => 'servico-baixa-temporaria', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<p>A baixa temporária de inscrição será concedida se o nutricionista não estiver exercendo atividades na área previstas nos Art. 3º. e Art. 4º da Lei Federal Nº 8234/1991.</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>Carteira de Identidade Profissional original: deverá ser devolvida pelos correios ou entregue na Sede BH ou em uma das Delegacias do CRN-9;</li><li>“Formulário de Solicitação de Baixa Temporária da Inscrição (CLIQUE AQUI)” devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li><li>A documentação com comprovação da não atuação na área de alimentação e nutrição pelo profissional, deverá estar de acordo com a justificativa apresentada no formulário EXEMPLOS DE DOCUMENTOS VÁLIDOS –</li></ul>
<h3>LINK PARA BAIXA TEMPORÁRIA: Clique Aqui</h3>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>Em caso de perda ou roubo da carteira de identidade profissional, o requerimento deverá estar acompanhado de um boletim de ocorrência da polícia, informando do fato;</li><li>O profissional ficará isento do pagamento da anuidade do ano em exercício se a solicitação de baixa temporária da inscrição for protocolada no CRN-9 até o dia 31 de março;</li><li>Após o dia 31 de março, será cobrado o valor da anuidade proporcional até o mês em que o requerimento for protocolado;</li><li>O pedido de baixa temporária poderá ser realizado mesmo que o profissional possua débitos em aberto com o CRN-9. No entanto, os débitos em aberto serão cobrados pelo CRN-9. A cobrança poderá acontecer por inscrição em dívida ativa;</li><li>Em até 30 (trinta) dias úteis após o requerimento, o parecer desse Conselho sobre a solicitação de baixa temporária será comunicado por ofício, via e-mail. Mantenha seus dados atualizados;</li><li>Em caso de indeferimento da baixa temporária da inscrição, a mesma permanecerá ativa e a Carteira de Identidade Profissional será devolvida;</li><li>Caso a inscrição não seja reativada no período de vigência da baixa temporária, será cancelada ex-offício. Será necessário requerer uma nova inscrição, caso volte a atuar.</li></ul>'],
            ['title' => 'Cancelamento de Inscrição – Nutricionista', 'slug' => 'servico-cancelamento-de-inscricao', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<p>Caso o nutricionista não deseje mais trabalhar na área, o cancelamento de inscrição será concedido se o profissional não estiver exercendo atividades na área previstas nos Art. 3º. e Art. 4º da Lei Federal Nº 8234/1991.</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>Carteira de Identidade Profissional original: deverá ser devolvida pelos correios ou entregue na Sede BH ou em uma das Delegacias do CRN-9;</li><li>“Formulário de Solicitação de Cancelamento de Inscrição (CLIQUE AQUI)” devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li><li>A documentação com comprovação da não atuação na área de alimentação e nutrição pelo profissional, deverá estar de acordo com a justificativa apresentada no formulário EXEMPLOS DE DOCUMENTOS VÁLIDOS –</li></ul>
<h3>LINK PARA CANCELAMENTO DE INSCRIÇÃO: Clique Aqui</h3>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>Em caso de perda ou roubo da carteira de identidade profissional, o requerimento deverá estar acompanhado de um boletim de ocorrência da polícia, informando do fato;</li><li>O profissional ficará isento do pagamento da anuidade do ano em exercício se a solicitação de cancelamento da inscrição for protocolada no CRN-9 até o dia 31 de março;</li><li>Após o dia 31 de março, será cobrado o valor da anuidade proporcional até o mês em que o requerimento for protocolado;</li><li>O pedido de cancelamento poderá ser realizado mesmo que o profissional possua débitos em aberto com o CRN-9. No entanto, os débitos em aberto serão cobrados pelo CRN-9. A cobrança poderá acontecer por inscrição em dívida ativa;</li><li>Em até 30 (trinta) dias úteis após o requerimento, o parecer desse Conselho sobre a solicitação de cancelamento será comunicado por ofício, via e-mail. Mantenha seus dados atualizados;</li><li>Em caso de indeferimento da cancelamento da inscrição, a mesma permanecerá ativa e a Carteira de Identidade Profissional será devolvida;</li><li>Caso volte a atuar, será necessário requerer uma nova inscrição.</li></ul>'],
            ['title' => 'Reativação de Inscrição – Nutricionista', 'slug' => 'servico-reativacao-de-inscricao', 'content' => '<p>A inscrição poderá ser reativada durante o período de vigência da baixa temporária a qualquer momento.</p>
<p>Inscrições canceladas não poderão ser reativadas. Neste caso, deverá ser requerida uma nova ( link para inscrição definitiva nutricionista ).</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>Formulário de Reativação de Inscrição(CLIQUE AQUI) devidamente preenchido e assinad0 (manualmente ou eletronicamente pela conta no gov.br);</li><li>Cópia de comprovante de endereço atual.</li></ul>
<p>Caso tenha inscrição provisória, mas já seja portador de diploma registrado:</p>
<ul><li>Cópia do Diploma (frente e verso) devidamente registrado e assinado pela instituição de ensino e pelo profissional (quando houver campo específico).</li></ul>
<p>Caso os documentos estejam desatualizados:</p>
<ul><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos e com o nome civil atual e nome social, caso exista;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li></ul>
<h3>VALORES A SEREM QUITADOS PARA A REATIVAÇÃO DE INSCRIÇÃO:</h3>
<ul><li>Anuidade do ano corrente (R$ 566,32) proporcional (o cálculo será realizado considerando-se o mês do recebimento da solicitação de inscrição até dezembro).</li></ul>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>O prazo para reativação é de até 30 dias úteis, após o recebimento do requerimento e do diploma (para inscrição prévia provisória), desde que não constem pendências cadastrais, de reconhecimento do curso e/ou financeiras a serem resolvidas;</li><li>Caso o processo de reativação da inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido;</li><li>Após ativação da inscrição, será cobrada anuidade independente de sua efetiva atuação profissional.</li></ul>'],
            ['title' => 'Prorrogação de Baixa Temporária', 'slug' => 'servico-prorrogacao-de-baixa-temporaria', 'content' => '<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Formulário de Solicitação de Prorrogação de Baixa Temporária da Inscrição (CLIQUE AQUI)” devidamente preenchid0 e assinad0 (manualmente ou eletronicamente pela conta no gov.br);</li></ul>
<h3>LINK PARA PRORROGAÇÃO: Clique Aqui</h3>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>Em até 30 (trinta) dias úteis após o requerimento, o parecer desse Conselho sobre a solicitação de prorrogação de baixa temporária será comunicado por ofício, via e-mail;</li><li>Caso a solicitação de prorrogação não seja realizada antes do término do prazo de 5 (cinco) anos da baixa temporária da inscrição, a mesma será cancelada automaticamente;</li><li>A prorrogação da baixa temporária da inscrição será concedida uma única vez;</li><li>Ao término do período de prorrogação da baixa temporária, caso não haja manifestação do profissional solicitando a reativação da inscrição, a mesma será cancelada.</li></ul>'],
            ['title' => 'Solicitação de segunda via de carteira profissional – TND', 'slug' => 'servico-solicitacao-de-segunda-via-de-carteira-profissional-2', 'content' => '<ul><li>Formulário de Solicitação de Emissão de 2ª via da Carteira de Identidade Profissional(CLIQUE AQUI) devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li></ul>
<ul><li>Formulário de Solicitação de Emissão de 2ª via da Carteira de Identidade Profissional(CLIQUE AQUI) devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li><li>Boletim de Ocorrência informando perda/roubo/extravio da Carteira de Identidade Profissional;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li></ul>
<ul><li>Formulário de Solicitação de Emissão de 2ª via da Carteira de Identidade Profissional(CLIQUE AQUI) devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos e com o nome civil atual e nome social, caso exista;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li></ul>
<h3>CLIQUE AQUI PARA ANEXAR DOCUMENTOS: Clique Aqui</h3>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>O profissional não poderá ter débitos vencidos para receber o novo documento;</li><li>A carteira a ser substituída deverá ser devidamente descartada após o recebimento do novo documento;</li><li>Caso o processo de emissão da segunda via da Carteira de Identidade Profissional não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data de protocolo, por falta de manifestação do solicitante, os documentos apresentados serão inutilizados, sendo necessário o envio de nova documentação para reinício do processo;</li></ul>'],
            ['title' => 'Solicitação de Certidão de Regularidade – Nutricionista', 'slug' => 'servico-solicitacao-certidao-regularidade-nutri', 'content' => '<p>A solicitação de Certidão de Regularidade pode ser feita pelo Auto Atendimento ( Clique Aqui ).</p>
<p>Ao entrar com os seus dados de acesso no menu “Acesse sua Inscrição”, escolha a opção “Emissão de Certidão” e selecione o documento desejado.</p>'],
            ['title' => 'Registro de Documentação Fitoterapia/PICS', 'slug' => 'servico-registro-de-documentacao-fitoterapia-pics', 'content' => '<p>O registro para atuação em Fitoterapia/PICS é centralizado no CFN.</p>
<p>Para esse requerimento acesse o link</p>
<p>https://pics.cfn.org.br/application/pics/index</p>'],
            ['title' => 'Registro do Título de Especialista', 'slug' => 'servico-especialidades', 'content' => '<h2>Leia atentamente todas as orientações</h2>
<p>Conforme Resolução CFN Nº 689/2021 , o Sistema CFN/CRN reconhece 34 especialidades em nutrição.  Clique aqui.</p>
<h3>A obtenção de título de especialista em nutrição está condicionada a:</h3>
<ol><li>ser nutricionista com, pelo menos, três anos de inscrição ativa no CRN9;</li><li>ser nutricionista com, pelo menos, dois anos de inscrição ativa no CRN9 e portador de certificado de residência na área da especialidade; e</li><li>atender aos requisitos estabelecidos no respectivo edital.</li></ol>
<h3>Documentos necessários</h3>
<ul><li>Requerimento de registro do título de especialista / Declaração de veracidade e autenticidade de dados e documentos (em formato .pdf, assinado eletronicamente)( Baixe Aqui )</li><li>Título de especialista em nutrição emitido pela ASBRAN ou emitido por outra entidade com a chancela da Asbran e do CFN; ou Certificado de Residência (em formato .pdf).</li></ul>
<h3>Valores a serem quitados:</h3>
<p>Taxa: R$ 44,22 Conforme RESOLUÇÃO CFN N° 833, DE 1° de dezembro DE 2025</p>
<h3>Formulário para envio do requerimento ( Clique aqui )</h3>
<h3>Observações importantes:</h3>
<ul><li>O nutricionista poderá requerer quantos títulos desejar;</li><li>É vedado ao CRN-9 o registro de título de especialista em nutrição não chancelado previamente pelo CFN e ASBRAN;</li><li>O profissional deve estar atento ao e-mail e mantê-lo atualizado no CRN-9 para que possa receber comunicados e solicitações para efetivação da análise;</li><li>Havendo o deferimento do requerimento e quitação da taxa, a declaração de registro do título expedida pelo CRN-9 será enviado por e-mail. Mantenha seu e-mail atualizado.</li></ul>'],
            ['title' => 'Anotação de Responsabilidade', 'slug' => 'servico-responsabilidade-tecnica', 'content' => '<p>Conforme a Resolução CFN nº 795/2024, a Anotação de Responsabilidade (ART ou ARAAN) deverá ser solicitada ao CRN pelo nutricionista interessado, mediante preenchimento fidedigno de formulário próprio.</p>
<p>A RESPONSABILIDADE TÉCNICA (RT)/ RESPONSABILIDADE PELAS ATIVIDADES DE ALIMENTAÇÃO E NUTRIÇÃO HUMANA é a atribuição anotada pelo CRN para o nutricionista habilitado, que assume integralmente o compromisso profissional e legal pela execução das atividades técnicas de alimentação e nutrição humana, compatível com a formação e os princípios éticos da profissão, visando a qualidade dos serviços prestados à sociedade.</p>
<p>CRITÉRIOS PARA A ANOTAÇÃO:</p>
<p>– o nutricionista deverá estar em situação cadastral regular e sem pendência financeira;</p>
<p>– o CRN anotará até 5 (cinco) responsabilidades técnicas e/ou responsabilidades pelas atividades de alimentação e nutrição humana;</p>
<h3>Solicitação de Anotação de Responsabilidade Técnica</h3>
<p>Sou nutricionista e desejo solicitar a anotação da responsabilidade técnica por uma empresa que desenvolve atividades de alimentação e nutrição.</p>
<p>Preencher e encaminhar pelo formulário JOTFORM : 1. Solicitação de Anotação de Responsabilidade Técnica ( CLIQUE AQUI ) 2. Termo de Compromisso do nutricionista responsável técnico ( CLIQUE AQUI ) 3. Dimensionamento correspondente ao serviço executado pela empresa e, nos casos de concessionárias de alimentação, considerar as características das unidades/clientes: verifique qual dos listados abaixo atende as características da atividade e preencha o formulário correspondente</p>
<ul><li>Alimentação Coletiva</li><li>Indústria de Alimentos e Bebidas</li><li>Bufê de Eventos</li><li>Nutrição Clínica ambulatório, consultório e atendimento personalizado</li></ul>
<p>4. Declaração de Veracidade e Autenticidade de Dados e Documentos de Pessoa Jurídica 5. Cópia da prova de vínculo de trabalho vigente com a pessoa jurídica do(s) profissionais (nutricionistas e técnicos em nutrição e dietética)</p>
<p>Para emissão da Anotação de Responsabilidade Técnica (ART) por uma empresa –>  preencha o requerimento ( Clique aqui )</p>
<p>ATENÇÃO: Para a emissão da ART a pessoa jurídica deverá estar regularmente inscrita no CRN-9 e com dados atualizados.</p>
<h3>Solicitação de Anotação de Responsabilidade pelas Atividades de Alimentação e Nutrição Humana (ARAAN)</h3>
<p>Sou nutricionista e desejo solicitar a anotação da responsabilidade pelas atividades de alimentação e nutrição humana por uma empresa/instituição/entidade, que disponha de serviço de alimentação e nutrição humana, não sendo sua atividade-fim.</p>
<p>Preencher e encaminhar pelo formulário JOTFORM :</p>
<p>1. Solicitação de Anotação de Responsabilidade pelas atividades de alimentação e nutrição humana ( CLIQUE AQUI ) 2. Termo de Compromisso do nutricionista responsável pelas atividades de alimentação e nutrição humana ( CLIQUE AQUI ) 3. Dimensionamento correspondente ao serviço executado pela empresa e, nos casos de concessionárias de alimentação, considerar as características das unidades/clientes: verifique qual dos listados abaixo atende as características da atividade e preencha o formulário correspondente</p>'],
            ['title' => 'Cadastro da atuação como autônomo', 'slug' => 'servico-cadastro-da-atuacao-como-autonomo', 'content' => '<ul><li>Sou nutricionista e desejo cadastrar minha atuação como autônomo no CRN-9 –> preencha o Requerimento de Cadastro da Atuação do Nutricionista como profissional liberal autônomo e solicite a emissão da Certidão de Cadastro do Autônomo (CCA), se desejar.</li><li>Sou nutricionista com cadastro de autônomo no CRN-9 e preciso da Certidão de Cadastro do Autônomo (CCA) –> preencha o Requerimento de Atualização de Dados e Emissão de CCA.</li></ul>
<p>Todos os documentos devem ser enviados, exclusivamente, pelo formulário .</p>
<p>Para maiores esclarecimentos, consulte a Resolução CFN nº 670/2020 ou entre em contato com o setor de fiscalização (fiscalizacao@crn9.org.br).</p>'],
            ['title' => 'Documentos para atuação no PNAE', 'slug' => 'servico-documentos-para-atuacao-no-pnae', 'content' => '<ul><li>Sou nutricionista e desejo solicitar a responsabilidade técnica pelo PNAE de uma entidade executora –> siga as orientações do link Solicitação de Anotação</li><li>Sou nutricionista RT pelo PNAE e desejo solicitar a emissão da Anotação de Responsabilidade Técnica (ART) para cadastro no SigPNAE/FNDE –> preencha o Requerimento de ART .</li><li>Sou nutricionista, atuo como quadro técnico no PNAE e preciso da Declaração de Quadro Técnico para cadastro no SigPNAE/FNDE –> preencha o Comunicado-de-Quadro-Técnico .</li><li>Sou nutricionista, deixei de atuar no PNAE e preciso da declaração de baixa para desvinculação no SigPNAE/FNDE –> preencha o documento Comunicado de Afastamento/Cancelamento de Responsável Técnico (RT) e Quadro Técnico (QT) .</li></ul>
<p>Todos os documentos devem ser enviados, exclusivamente, pelo formulário .</p>
<p>Havendo dúvidas, entre em contato com o setor de fiscalização (fiscalizacao.atendimento@crn9.org.br).</p>'],
            ['title' => 'Anuidade 2026 – TND', 'slug' => 'servico-anuidade-2026-tnd', 'content' => '<p>Emita o boleto da anuidade 2026 clicando AQUI.</p>
<p>Técnico em Nutrição e Dietética: R$ 297,83 (duzentos e noventa e sete reais, oitenta e três centavos).</p>
<p>FORMAS DE PAGAMENTO:</p>
<p>EM COTA ÚNICA até 10/07/2026, ou em 10 PARCELAS com os seguintes vencimentos: 10/02, 10/03, 10/04, 10/05, 10/06 e 10/07, 10/08, 10/09, 10/10 e 10/11/2026.</p>
<p>COM DESCONTO DE 15% para vencimento cota única em 10/02/2025: Técnico em Nutrição e Dietética: R$ 253,16 (duzentos e cinquenta e três reais, dezesseis centavos). (utilizando o mesmo boleto de pagamento integral).</p>
<ol><li>O PAGAMENTO DA ANUIDADE DE 2025 NÃO QUITA DÉBITOS ANTERIORES</li><li>MANTENHA SEUS DADOS ATUALIZADOS NO CRN9. ACESSE O ATENDIMENTO ONLINE OU ENVIE UM E-MAIL PARA: PF.ATENDIMENTO@CRN9.ORG.BR</li><li>ACESSE ATENDIMENTO ONLINE e tenha uma série de serviços, tais como:</li></ol>
<ul><li>Atualização Cadastral;</li><li>Emissão de Certidão;</li><li>Solicitação de Inscrição; Emissão de 2ª via de boleto bancário, entre outros.</li></ul>
<ul><li>Emissão de 2ª via de boleto bancário, entre outros.</li></ul>
<p>RESOLUÇÃO CFN Nº 829, DE 1º DE DEZEMBRO DE 2025</p>
<p>Consulte o documento que dispõe sobre normas gerais aplicáveis às anuidades, critérios para reajustes, opções de pagamentos e critérios de cobrança.</p>
<p>Documento PDF</p>'],
            ['title' => 'Inscrição Provisória – TND', 'slug' => 'servico-inscricao-provisoria-pf-tnd', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Ficha de Inscrição” devidamente preenchida e assinada (manualmente ou eletronicamente pela conta no gov.br);</li><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos e com o nome civil atual e nome social, caso exista;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Digital do polegar direito reproduzida em papel branco, sem pauta, com tinta preta;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li><li>Declaração de Conclusão de Curso, constando a data em que colou de grau;</li><li>Cópia de comprovante de endereço atual;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<h3>VALORES A SEREM QUITADOS:</h3>
<p>Anuidade do ano corrente (R$283,16) proporcional (o cálculo será realizado considerando-se o mês do recebimento da solicitação de inscrição até dezembro).</p>
<p>Obs.: Será concedido desconto de 50% (cinquenta por cento) do valor da primeira anuidade cobrada no ato da primeira inscrição (anuidades posteriores serão cobradas integralmente) aos recém-formados que requererem a inscrição profissional até 365 (trezentos e sessenta e cinco) dias após a data de colação de grau.</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>Após ativação da inscrição, será cobrada anuidade independente de sua efetiva atuação profissional;</li><li>O boleto da anuidade proporcional será fornecido apenas após confirmação dos dados do diploma junto ao estabelecimento de ensino. Este contato será realizado pelo próprio CRN-9 após a solicitação de inscrição e recebimento dos documentos solicitados;</li><li>A inscrição será ativada em até 30 (trinta) dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido.</li></ul>'],
            ['title' => 'Inscrição de provisória para definitiva – TND', 'slug' => 'servico-inscricao-de-provisoria-para-definitiva-tnd', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Ficha de Inscrição” devidamente preenchida e assinada (manualmente ou eletronicamente pela conta no gov.br);</li><li>Cópia do Diploma (frente e verso) devidamente registrado e assinado pela instituição de ensino e pelo profissional (quando houver campo específico);</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de mínimo 150 dpi e tamanho máximo de 5 MB;</li><li>Cópia de comprovante de endereço atual – em caso de alteração de domicílio;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN/9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>Após ativação da inscrição, será cobrada anuidade independente de sua efetiva atuação profissional;</li><li>A inscrição será ativada em até 30 (trinta) dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido.</li></ul>'],
            ['title' => 'Inscrição Definitiva – TND', 'slug' => 'servico-inscricao-definitiva-pf-tnd', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Ficha de Inscrição” devidamente preenchida e assinada (manualmente ou eletronicamente pela conta no gov.br);</li><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos e com o nome civil atual e nome social, caso exista;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Digital do polegar direito reproduzida em papel branco, sem pauta, com tinta preta;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de mínimo 150 dpi e tamanho máximo de 5 MB;</li><li>Cópia do Diploma (frente e verso) devidamente registrado e assinado pela instituição de ensino e pelo profissional (quando houver campo específico);</li><li>Cópia de comprovante de endereço atual;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<h3>VALORES A SEREM QUITADOS:</h3>
<p>Anuidade do ano corrente (R$283,16) proporcional (o cálculo será realizado considerando-se o mês do recebimento da solicitação de inscrição até dezembro).</p>
<p>Obs.: Será concedido desconto de 50% (cinquenta por cento) do valor da primeira anuidade cobrada no ato da primeira inscrição (anuidades posteriores serão cobradas integralmente) aos recém-formados que requererem a inscrição profissional até 365 (trezentos e sessenta e cinco) dias após a data de colação de grau.</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>Após ativação da inscrição, será cobrada anuidade independente de sua efetiva atuação profissional;</li><li>O boleto da anuidade proporcional será fornecido apenas após confirmação dos dados do diploma junto ao estabelecimento de ensino. Este contato será realizado pelo próprio CRN-9 após a solicitação de inscrição e recebimento da documentação completa;</li><li>A inscrição será ativada em até 30 (trinta) dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido.</li></ul>'],
            ['title' => 'Transferência – TND', 'slug' => 'servico-transferencia-pf-tnd', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Ficha de Inscrição” devidamente preenchida e assinada (manualmente ou eletronicamente pela conta no gov.br);</li><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos e com o nome civil atual e nome social, caso exista;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Digital do polegar direito reproduzida em papel branco, sem pauta, com tinta preta;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li><li>Cópia do Diploma (frente e verso) devidamente registrado e assinado pela instituição de ensino e pelo profissional (quando houver campo específico);</li><li>Cópia de comprovante de endereço atual;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome;</li><li>Declaração de responsabilidade do profissional.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<p>A carteira profissional do CRN de origem deverá ser entregue pessoalmente ou via correios, na sede ou delegacias do CRN-9. Se preferir, pode ser devolvida ao CRN de origem.</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>O profissional deverá entrar em contato com o CRN de origem para verificar possíveis pendências (exemplos: débito, processos administrativo ou vínculos de trabalho em aberto) e saná-las, para que o pedido de transferência não seja indeferido;</li><li>O boleto da anuidade do ano corrente, caso esta não tenha sido quitado no CRN de origem, será enviado, por e-mail, após ativação de inscrição;</li><li>A inscrição será ativada em até 30 dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido;</li><li>O profissional poderá atuar até que seu processo de transferência seja concluído, utilizando a inscrição do CRN de origem e com protocolo do pedido de transferência em mãos;</li><li>Após ativação da inscrição, será cobrada anuidade independente de sua efetiva atuação profissional.</li></ul>'],
            ['title' => 'Inscrição secundária – TND', 'slug' => 'servico-inscricao-secundaria-pf-tnd', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Ficha de Inscrição” devidamente preenchida e assinada (manualmente ou eletronicamente pela conta no gov.br);</li><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos e com o nome civil atual e nome social, caso exista;</li><li>Certidão de Regularidade, emitida nos últimos 30 (trinta) dias, fornecida pelo CRN onde o profissional tem inscrição originária, na qual constem dados do inscrito, além da informação de estar o mesmo quite com todas as suas obrigações;</li><li>Cópia digital da Carteira de Identidade Profissional definitiva ou provisória do CRN de origem;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Digital do polegar direito reproduzida em papel branco, sem pauta, com tinta preta;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li><li>Cópia do Diploma (frente e verso) devidamente registrado e assinado pela instituição de ensino e pelo profissional (quando houver campo específico);</li><li>Cópia de comprovante de endereço atual;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<h3>VALORES A SEREM QUITADOS PARA ATIVAÇÃO DA INSCRIÇÃO:</h3>
<p>Anuidade de inscrição secundária do ano corrente (R$ 59,56) proporcional (o cálculo será realizado considerando-se o mês do recebimento da solicitação de inscrição até dezembro).</p>
<p>Conforme RESOLUÇÃO CFN N° 829, DE 1° de dezembro DE 2025</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>A inscrição será ativada em até 30 dias úteis, após a conferência dos documentos e deferimento do requerimento, e o profissional comunicado por e-mail;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido.</li></ul>'],
            ['title' => 'Prorrogação de inscrição provisória – TND', 'slug' => 'servico-prorrogacao-de-inscricao-provisoria-2', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<p>A inscrição provisória poderá ser prorrogada durante o período de vigência da inscrição provisória ativa, de preferência em até 15 (quinze) dias antes do término da validade</p>
<p>Inscrições provisórias vencidas não poderão ser prorrogadas. Neste caso, deverá ser requerida uma nova (link para inscrição definitiva TND)</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Formulário Prorrogação de Inscrição (CLIQUE AQUI)” assinada digitalmente (preencha a ficha, depois salve preenchida e somente depois assine. Qualquer alteração feita após a assinatura, irá invalidar o documento);</li><li>Certificado de Conclusão de Curso constando a data de colação de grau (já realizada) com validade de até 06 (seis) meses, ou dentro do prazo de validade especificado na declaração.</li></ul>
<p>Clique aqui e veja algumas orientações para preparação dos documentos.</p>
<h3>VALORES A SEREM QUITADOS PARA ATIVAÇÃO DA INSCRIÇÃO:</h3>
<p>Taxa de emissão de carteira profissional: R$ 20,25</p>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<ul><li>Atenção, somente prossiga com o requerimento de inscrição, se você pretende atuar na área de jurisdição do CRN-9: Minas Gerais. Caso contrário, acesse o site do CRN da sua jurisdição. Clique aqui</li></ul>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>A comunicação será feita por meio do e-mail cadastrado no requerimento de inscrição. Mantenha-o atualizado no seu cadastro;</li><li>O boleto de taxas será direcionado para o e-mail do profissional após o recebimento dos documentos citados acima;</li><li>A inscrição será ativada em até 10 dias úteis após a quitação do boleto e o profissional comunicado por e-mail. Você receberá uma Declaração Digital de Inscrição;</li><li>A carteira profissional será encaminhada ao profissional via correios e assim que possível após a ativação de inscrição;</li><li>Caso o processo de inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido. Uma nova solicitação deverá ser feita.</li></ul>'],
            ['title' => 'Baixa Temporária – TND', 'slug' => 'servico-baixa-temporaria-2', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<p>A baixa temporária de inscrição será concedida se o TND não estiver exercendo atividades na área.</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>Carteira de Identidade Profissional original: deverá ser devolvida pelos correios ou entregue na Sede BH ou em uma das Delegacias do CRN-9;</li><li>“Formulário de Solicitação de Baixa Temporária da Inscrição (CLIQUE AQUI)” devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li><li>A documentação com comprovação da não atuação na área de alimentação e nutrição pelo profissional, deverá estar de acordo com a justificativa apresentada no formulário EXEMPLOS DE DOCUMENTOS VÁLIDOS –</li></ul>
<h3>LINK PARA BAIXA TEMPORÁRIA: Clique Aqui</h3>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>Em caso de perda ou roubo da carteira de identidade profissional, o requerimento deverá estar acompanhado de um boletim de ocorrência da polícia, informando do fato;</li><li>O profissional ficará isento do pagamento da anuidade do ano em exercício se a solicitação de baixa temporária da inscrição for protocolada no CRN-9 até o dia 31 de março;</li><li>Após o dia 31 de março, será cobrado o valor da anuidade proporcional até o mês em que o requerimento for protocolado;</li><li>O pedido de baixa temporária poderá ser realizado mesmo que o profissional possua débitos em aberto com o CRN-9. No entanto, os débitos em aberto serão cobrados pelo CRN-9. A cobrança poderá acontecer por inscrição em dívida ativa;</li><li>Em até 30 (trinta) dias úteis após o requerimento, o parecer desse Conselho sobre a solicitação de baixa temporária será comunicado por ofício, via e-mail. Mantenha seus dados atualizados;</li><li>Em caso de indeferimento da baixa temporária da inscrição, a mesma permanecerá ativa e a Carteira de Identidade Profissional será devolvida;</li><li>Caso a inscrição não seja reativada no período de vigência da baixa temporária, será cancelada ex-offício. Será necessário requerer uma nova inscrição, caso volte a atuar.</li></ul>'],
            ['title' => 'Cancelamento de Inscrição – TND', 'slug' => 'servico-cancelamento-de-inscricao-2', 'content' => '<p>LEIA ATENTAMENTE TODAS AS ORIENTAÇÕES ANTES DE PREENCHER OS DADOS CADASTRAIS</p>
<p>A baixa temporária de inscrição será concedida se o TND não estiver exercendo atividades na área.</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>Carteira de Identidade Profissional original: deverá ser devolvida pelos correios ou entregue na Sede BH ou em uma das Delegacias do CRN-9;</li><li>“Formulário de Solicitação de Cancelamento de Inscrição (CLIQUE AQUI)” devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li><li>A documentação com comprovação da não atuação na área de alimentação e nutrição pelo profissional, deverá estar de acordo com a justificativa apresentada no formulário EXEMPLOS DE DOCUMENTOS VÁLIDOS –</li></ul>
<h3>LINK PARA CANCELAMENTO DE INSCRIÇÃO: Clique Aqui</h3>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>Em caso de perda ou roubo da carteira de identidade profissional, o requerimento deverá estar acompanhado de um boletim de ocorrência da polícia, informando do fato;</li><li>O profissional ficará isento do pagamento da anuidade do ano em exercício se a solicitação de cancelamento da inscrição for protocolada no CRN-9 até o dia 31 de março;</li><li>Após o dia 31 de março, será cobrado o valor da anuidade proporcional até o mês em que o requerimento for protocolado;</li><li>O pedido de cancelamento poderá ser realizado mesmo que o profissional possua débitos em aberto com o CRN-9. No entanto, os débitos em aberto serão cobrados pelo CRN-9. A cobrança poderá acontecer por inscrição em dívida ativa;</li><li>Em até 30 (trinta) dias úteis após o requerimento, o parecer desse Conselho sobre a solicitação de cancelamento será comunicado por ofício, via e-mail. Mantenha seus dados atualizados;</li><li>Em caso de indeferimento da cancelamento da inscrição, a mesma permanecerá ativa e a Carteira de Identidade Profissional será devolvida;</li><li>Caso volte a atuar, será necessário requerer uma nova inscrição.</li></ul>'],
            ['title' => 'Reativação de Inscrição – TND', 'slug' => 'servico-reativacao-de-inscricao-2', 'content' => '<p>A inscrição poderá ser reativada durante o período de vigência da baixa temporária a qualquer momento.</p>
<p>Inscrições canceladas não poderão ser reativadas. Neste caso, deverá ser requerida uma nova ( link para inscrição definitiva TND ).</p>
<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>Formulário de Reativação de Inscrição(CLIQUE AQUI) devidamente preenchido e assinad0 (manualmente ou eletronicamente pela conta no gov.br);</li><li>Cópia de comprovante de endereço atual.</li></ul>
<p>Caso tenha inscrição provisória, mas já seja portador de diploma registrado:</p>
<ul><li>Cópia do Diploma (frente e verso) devidamente registrado e assinado pela instituição de ensino e pelo profissional (quando houver campo específico).</li></ul>
<p>Caso os documentos estejam desatualizados:</p>
<ul><li>Documento oficial de identificação com foto e número de CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 (dez) anos e com o nome civil atual e nome social, caso exista;</li><li>Cópia de Certidão de casamento ou averbação de divórcio, caso tenha alterado o nome;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li></ul>
<h3>VALORES A SEREM QUITADOS PARA A REATIVAÇÃO DE INSCRIÇÃO:</h3>
<ul><li>Anuidade do ano corrente (R$ 283,16) proporcional (o cálculo será realizado considerando-se o mês do recebimento da solicitação de inscrição até dezembro).</li></ul>
<h3>LINK DE INSCRIÇÃO: Clique Aqui</h3>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>O prazo para reativação é de até 30 dias úteis, após o recebimento do requerimento e do diploma (para inscrição prévia provisória), desde que não constem pendências cadastrais, de reconhecimento do curso e/ou financeiras a serem resolvidas;</li><li>Caso o processo de reativação da inscrição não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data do protocolo, o requerimento será indeferido;</li><li>Após ativação da inscrição, será cobrada anuidade independente de sua efetiva atuação profissional.</li></ul>'],
            ['title' => 'Prorrogação de Baixa Temporária – TND', 'slug' => 'servico-prorrogacao-de-baixa-temporaria-tnd', 'content' => '<h3>DOCUMENTOS NECESSÁRIOS:</h3>
<ul><li>“Formulário de Solicitação de Prorrogação de Baixa Temporária da Inscrição (CLIQUE AQUI)” devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li></ul>
<h3>LINK PARA PRORROGAÇÃO: Clique Aqui</h3>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>Em até 30 (trinta) dias úteis após o requerimento, o parecer desse Conselho sobre a solicitação de prorrogação de baixa temporária será comunicado por ofício, via e-mail;</li><li>Caso a solicitação de prorrogação não seja realizada antes do término do prazo de 5 (cinco) anos da baixa temporária da inscrição, a mesma será cancelada automaticamente;</li><li>A prorrogação da baixa temporária da inscrição será concedida uma única vez;</li><li>Ao término do período de prorrogação da baixa temporária, caso não haja manifestação do profissional solicitando a reativação da inscrição, a mesma será cancelada.</li></ul>'],
            ['title' => 'Solicitação de segunda via de carteira profissional – Nutricionista', 'slug' => 'servico-solicitacao-de-segunda-via-de-carteira-profissional', 'content' => '<ul><li>Formulário de Solicitação de Emissão de 2ª via da Carteira de Identidade Profissional(CLIQUE AQUI) devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li></ul>
<ul><li>Formulário de Solicitação de Emissão de 2ª via da Carteira de Identidade Profissional(CLIQUE AQUI) devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li><li>Boletim de Ocorrência informando perda/roubo/extravio da Carteira de Identidade Profissional;</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li></ul>
<ul><li>Formulário de Solicitação de Emissão de 2ª via da Carteira de Identidade Profissional(CLIQUE AQUI) devidamente preenchido e assinado (manualmente ou eletronicamente pela conta no gov.br);</li><li>Uma foto 3×4, colorida e nítida, recente (com no máximo 6 meses), sem data, sem moldura, sem marcas, sem óculos, com fundo branco e em postura formal (rosto e ombros enquadrados e olhar diretamente para câmera), a cabeça e o topo dos ombros devem estar posicionados de forma a ocupar 70-80% da fotografia. Para maiores informações, acesse o material de ajuda disponível em: https://carteiradigital.cfn.org.br/</li><li>Cópia de documento de RG ou CTPS(desde que possua número de RG, órgão expedidor e data de expedição) com a alteração do nome;</li><li>Assinatura em papel branco, sem pauta, em formato .png, com largura de 400 pixels e altura de 100 pixels, com resolução de no mínimo 150 dpi e tamanho máximo de 5 MB;</li></ul>
<h3>CLIQUE AQUI PARA ANEXAR DOCUMENTOS: Clique Aqui</h3>
<h3>OBSERVAÇÕES IMPORTANTES:</h3>
<ul><li>O profissional não poderá ter débitos vencidos para receber o novo documento;</li><li>A carteira a ser substituída deverá ser devidamente descartada após o recebimento do novo documento;</li><li>Caso o processo de emissão da segunda via da Carteira de Identidade Profissional não seja concluído no prazo de 60 (sessenta) dias corridos a partir da data de protocolo, por falta de manifestação do solicitante, os documentos apresentados serão inutilizados, sendo necessário o envio de nova documentação para reinício do processo;</li></ul>'],
            ['title' => 'Solicitação de Certidão de Regularidade – TND', 'slug' => 'servico-solicitacao-certidao-regularidade-tnd', 'content' => '<p>A solicitação de Certidão de Regularidade pode ser feita pelo Autoatendimento ( Clique Aqui ).</p>
<p>Ao entrar com os seus dados de acesso no menu “Acesse sua Inscrição”, escolha a opção “Emissão de Certidão” e selecione o documento desejado.</p>'],
            ['title' => 'Anuidade 2026 – Pessoa Jurídica', 'slug' => 'servico-anuidade-2026-pj', 'content' => '<p>Emita o boleto da anuidade 2026 clicando AQUI .</p>
<p>Para as pessoas jurídicas abaixo relacionadas: valor de R$ 765,37 (setecentos e sessenta e cinco reais, trinta e sete centavos)</p>
<ul><li>Que atuam exclusivamente como serviços comerciais de alimentação;</li><li>Que distribuem e/ou comercializam suplementos alimentares;</li><li>Indústrias de alimentos;</li><li>Indústrias de bebidas;</li><li>Microempresas e empresas de pequeno porte;</li><li>Empresas que forneçam cestas de alimentos, desde que não seja esta sua atividade principal;</li><li>Pessoas Jurídicas enquadradas no regime tributário do SIMPLES.</li><li>Associação sem fins lucrativos com atividades de concessionária de alimentação.</li></ul>
<p>Demais empresas conforme a faixa do Capital Social :</p>
<ul><li>Até R$ 50.000: R$1.034,30</li><li>De R$ 50.000,01 a R$ 200.000,00: R$ 2.068,60</li><li>De R$ 200.000,01 a R$ 500.000,00: R$ 3.102,88</li><li>De R$ 500.000,01 a R$ 1.000.000,00: R$ 4.137,21</li><li>De R$1.000.000,01 a R$ 2.000.000,00: R$ 5.171,49</li><li>De R$2.000.000,01 a R$10.000.000,00: R$ 6.205,80</li><li>Acima de R$10.000.000,00: R$ 8.274,39</li></ul>
<p>As empresas cujo único sócio seja Nutricionista regularmente inscrito no seu respectivo CRN enquadradas em quaisquer das situações previstas no § 1º deste artigo, uma vez requerida a isenção, ficarão dispensadas do pagamento de anuidades dos exercícios subsequentes desde que não tenha alteração contratual que modifique o quadro societário.</p>
<p>Conforme previsto na Resolução CFN Nº 830/2025, Os Microempreendedores Individuais (MEIs) terão os custos reduzidos a 0 (zero), inclusive os prévios, à inscrição, ao registro, ao funcionamento, ao alvará, à licença, ao cadastro, às alterações e procedimentos de baixa e encerramento, assim como os valores referentes a taxas, a emolumentos e as demais contribuições, inclusive de anotação de responsabilidade técnica.</p>
<h3>FORMAS DE PAGAMENTO:</h3>
<p>EM COTA ÚNICA até 10/02/2026</p>
<p>ou em 5 PARCELAS com os seguintes vencimentos: 10/02, 10/03, 10/04, 10/05, 10/06.</p>
<p>COM DESCONTO de 5% para pagamento com vencimento em cota única no dia 10/02/2026 (utilizando o mesmo boleto de pagamento integral)</p>
<p>SEM DESCONTO E SEM ACRÉSCIMO para vencimento cota única em 10/04/2026.</p>
<ol><li>O PAGAMENTO DA ANUIDADE DE 2026 NÃO QUITA DÉBITOS ANTERIORES.</li><li>ANTECIPE A ATUALIZAÇÃO CADASTRAL DE SUA EMPRESA, ENTRE EM CONTATO PELO E-MAIL: pj.atendimento@crn9.org.br</li></ol>
<p>RESOLUÇÃO CFN N° 830, DE 1° DE DEZEMBRO DE 2025</p>
<p>Consulte o documento que dispõe sobre normas gerais aplicáveis às anuidades, critérios para reajustes, opções de pagamentos e critérios de cobrança.</p>
<p>Documento PDF</p>'],
            ['title' => 'Anotação de Responsabilidade', 'slug' => 'servico-solicitacao-de-responsabilidade-tecnica', 'content' => '<p>Conforme a Resolução CFN nº 795/2024, a Anotação de Responsabilidade (ART ou ARAAN) deverá ser solicitada ao CRN pelo nutricionista interessado, mediante preenchimento fidedigno de formulário próprio.</p>
<p>A RESPONSABILIDADE TÉCNICA (RT)/ RESPONSABILIDADE PELAS ATIVIDADES DE ALIMENTAÇÃO E NUTRIÇÃO HUMANA é a atribuição anotada pelo CRN para o nutricionista habilitado, que assume integralmente o compromisso profissional e legal pela execução das atividades técnicas de alimentação e nutrição humana, compatível com a formação e os princípios éticos da profissão, visando a qualidade dos serviços prestados à sociedade.</p>
<p>CRITÉRIOS PARA A ANOTAÇÃO:</p>
<p>– o nutricionista deverá estar em situação cadastral regular e sem pendência financeira;</p>
<p>– o CRN anotará até 5 (cinco) responsabilidades técnicas e/ou responsabilidades pelas atividades de alimentação e nutrição humana;</p>
<h3>Solicitação de Anotação de Responsabilidade Técnica</h3>
<p>Sou nutricionista e desejo solicitar a anotação da responsabilidade técnica por uma empresa que desenvolve atividades de alimentação e nutrição.</p>
<p>Preencher e encaminhar pelo formulário JOTFORM : 1. Solicitação de Anotação de Responsabilidade Técnica ( CLIQUE AQUI ) 2. Termo de Compromisso do nutricionista responsável técnico ( CLIQUE AQUI ) 3. Dimensionamento correspondente ao serviço executado pela empresa e, nos casos de concessionárias de alimentação, considerar as características das unidades/clientes: verifique qual dos listados abaixo atende as características da atividade e preencha o formulário correspondente</p>
<ul><li>Alimentação Coletiva</li><li>Indústria de Alimentos e Bebidas</li><li>Bufê de Eventos</li><li>Nutrição Clínica ambulatório, consultório e atendimento personalizado</li></ul>
<p>4. Declaração de Veracidade e Autenticidade de Dados e Documentos de Pessoa Jurídica</p>
<p>5. Cópia da prova de vínculo de trabalho vigente com a pessoa jurídica do(s) profissionais (nutricionistas e técnicos em nutrição e dietética)</p>
<p>Para emissão da Anotação de Responsabilidade Técnica (ART) por uma empresa –>  preencha o requerimento ( Clique aqui )</p>
<p>ATENÇÃO: Para a emissão da ART a pessoa jurídica deverá estar regularmente inscrita no CRN-9 e com dados atualizados.</p>
<h3>Solicitação de Anotação de Responsabilidade pelas Atividades de Alimentação e Nutrição Humana (ARAAN)</h3>
<p>Sou nutricionista e desejo solicitar a anotação da responsabilidade pelas atividades de alimentação e nutrição humana por uma empresa/instituição/entidade, que disponha de serviço de alimentação e nutrição humana, não sendo sua atividade-fim.</p>
<p>Preencher e encaminhar pelo formulário JOTFORM :</p>'],
            ['title' => 'Comunicado de Afastamento', 'slug' => 'servico-https-crn9-org-br-servico-comunicado-de-afastamento', 'content' => '<p>Sou Nutricionista ou Técnico em Nutrição e Dietética e desejo informar meu afastamento, desligamento ou troca de função no local que atuo –> preencha o COMUNICADO DE AFASTAMENTO DESLIGAMENTO</p>
<p>– Este comunicado NÃO é válido para solicitação de Baixa Temporária/Cancelamento da inscrição profissional ou do registro/cadastro da pessoa jurídica no CRN-9 – Deverá ser preenchido um formulário para cada local e profissional – O comunicado pode ser enviado ao CRN-9 pelo formulário ou por e-mail (fiscalizacao@crn9.org.br)</p>
<p>– Caso não seja possível preencher o formulário, a informação poderá ser dada por e-mail (fiscalizacao@crn9.org.br), desde que contenha os seguintes dados:</p>
<ul><li>Razão social e CNPJ da empresa</li><li>Unidade, se houver</li><li>Nome completo do profissional</li><li>Nº de inscrição do profissional</li><li>Data (dia/mês/ano) de desligamento, afastamento ou da troca de função</li></ul>
<p>– O comunicado ao CRN-9 não isenta o profissional de informar outros órgãos (PAT, FNDE, CNES, Vigilância Sanitária etc.) – O comunicado deve ser feito em casos de desligamento, afastamento ou troca de função superior a 30 dias – O profissional deve comunicar o CRN-9 em até 15 dias, do desligamento, afastamento ou troca de função – Não são aceitos comunicados com data futura – A comunicação também pode ser feita pela empresa na qual o profissional estava vinculado – Solicitação sem ônus de taxa</p>
<p>– Referência: Resolução CFN 576/2016</p>
<p>Havendo dúvidas, entre em contato com o setor de fiscalização (fiscalizacao@crn9.org.br).</p>'],
            ['title' => 'Inscrição no CRN-9 (Registro e Cadastro)', 'slug' => 'servico-inscricao-no-crn-9-registro-e-cadastro', 'content' => '<p>As pessoas jurídicas (PJ) são inscritas no CRN-9 na modalidade de Registro, Registro Espontâneo ou Cadastro, conforme Resolução CFN nº 702/2021 . A Tabela de Classificação Nacional de Atividades Econômicas é utilizada como subsídio para correspondência de atividades das pessoas jurídicas. Confira o tipo de inscrição da sua empresa a seguir:</p>
<p>O registro no CRN-9 é obrigatório para as pessoas jurídicas que atuam em Minas Gerais e desenvolvem atividade-fim ou possuem objeto social nas áreas de alimentação e nutrição. São elas:</p>
<ul><li>Concessionárias de alimentação;</li><li>Consultórios ou clínicas de nutrição;</li><li>Empresas que prestam serviços de alimentação convênio e/ou refeição convênio;</li><li>Empresas que prestam atendimento nutricional personalizado;</li><li>Empresas que realizam auditoria, assessoria ou consultoria;</li><li>Empresas que realizam a comercialização de dietas enterais;</li><li>Empresas responsáveis pelo fornecimento de cestas de alimentos;</li><li>Empresas de produção de dietas;</li><li>Empresas de produção de refeições;</li></ul>
<p>As pessoas jurídicas a seguir, não são obrigadas ao registro no CRN-9, todavia podem se registrar de forma espontânea, desde que suas atividades estejam ligadas à alimentação e nutrição humanas e desde que apresentem nutricionista como responsável técnico. São elas:</p>
<ul><li>Empresas que atuam exclusivamente como serviços comerciais de alimentação (RESTAURANTE E HOTEL);</li><li>Empresas que distribuem e/ou comercializam suplementos alimentares;</li><li>Indústrias de alimentos; e</li><li>Indústrias de bebidas</li></ul>
<ul><li>O registro implica no pagamento de anuidade ao CRN-9, conforme normas vigentes, exceto para empresas classificadas como Microempreendedor Individual (MEI) nos termos da Lei Complementar nº 123, de 14 de dezembro de 2006, art. 4º, § 3º. Consulte os valores em: Anuidade e Taxas PJ .</li><li>Não será exigido o registro de MEI que possua como proprietário nutricionista regularmente inscrito como pessoa física no CRN, nos termos da Lei Complementar nº 123, de 2006, art. 18- A, §19-A, § 19-B, incluído pela Lei Complementar nº 155, de 27 de outubro de 2016.</li><li>Será obrigatória a manutenção de nutricionista como responsável pelas atividades de alimentação e nutrição humana.</li></ul>
<h2>Relação de documentos necessários para Registro Obrigatório ou Registro Espontâneo</h2>
<ul><li>Requerimento de Pessoa Jurídica .</li><li>Ficha de registro pessoa jurídica</li><li>Cópia do ato constitutivo em vigor, acompanhado das respectivas alterações, ou última alteração contratual consolidada, com as informações acerca do arquivamento e registro no órgão competente</li><li>Termo de Compromisso do nutricionista RT : o nutricionista também deverá Solicitar a Anotação de Responsabilidade</li><li>Dimensionamento, conforme a atividade da pessoa jurídica: Alimentação Coletiva Indústria de Alimentos e Bebidas Bufê de Eventos Nutrição Clínica ambulatório, consultório e atendimento personalizado</li><li>Cópia da prova de vínculo de trabalho vigente com a pessoa jurídica do(s) profissionais (nutricionistas e técnicos em nutrição e dietética)</li><li>Declaração de Veracidade e Autenticidade de Dados e Documentos de Pessoa Jurídica</li><li>Em caso de concessionária de alimentação: Relação de clientes</li><li>Em caso de serviço comercial de alimentação, comercialização de suplementos alimentares e indústrias de alimentos ou bebidas: Requerimento de registro espontâneo</li><li>Todos os documentos devem ser enviados, exclusivamente, pelo Formulário de envio de documento de Pessoa Jurídica ou de Nutricionista Autônomo</li><li>Havendo dúvidas, entre em contato com o setor de fiscalização (fiscalizacao.atendimento@crn9.org.br)</li></ul>
<ul><li>Alimentação Coletiva</li><li>Indústria de Alimentos e Bebidas</li><li>Bufê de Eventos</li><li>Nutrição Clínica ambulatório, consultório e atendimento personalizado</li></ul>
<p>A pessoa jurídica, de direito público ou privado, que disponha de serviço de alimentação e nutrição humana, não sendo sua atividade-fim, poderá efetuar o cadastro (não obrigatório) junto ao CRN9:</p>
<ul><li>SAÚDE COLETIVA;</li><li>EXTENSÃO RURAL;</li><li>AUTOGESTÃO;</li><li>UNIDADE ESCOLAR OU SIMILAR, PNAE, ESTABELECIMENTO DE ENSINO;</li><li>INSTITUIÇÃO DE LONGA PERMANÊNCIA PARA IDOSOS;</li><li>HOSPITAL OU SIMILAR;</li><li>AMBULATÓRIO;</li><li>CENTRO DE ATENÇÃO MULTIDISCIPLINAR;</li><li>COMUNIDADE TERAPÊUTICA;</li><li>SPA, CLÍNICA DE ESTÉTICA OU ACADEMIA;</li><li>SERVIÇOS DE TERAPIA RENAL SUBSTITUTIVA;</li><li>BANCO DE ALIMENTOS;</li><li>BANCO DE LEITE HUMANO;</li><li>COMÉRCIO ATACADISTA OU VAREJISTA DE ALIMENTOS;</li><li>CLÍNICAS DE NUTRIÇÃO DE IES;</li><li>OUTRAS (USO EXCLUSIVO EM CADASTRO)</li></ul>
<ul><li>Não há ônus de anuidade ou taxa de inscrição para essa modalidade</li><li>Será obrigatória a manutenção de nutricionista como responsável pelas atividades de alimentação e nutrição humana</li></ul>
<h2>Relação de documentos necessários para Cadastro</h2>
<ul><li>Requerimento de Pessoa Jurídica .</li></ul>
<ul><li>Cópia do ato constitutivo em vigor, acompanhado das respectivas alterações, ou última alteração contratual consolidada, com as informações acerca do arquivamento e registro no órgão competente</li><li>Termo de Compromisso do nutricionista RT : o nutricionista também deverá Solicitar a Anotação de Responsabilidade</li><li>Dimensionamento, conforme a atividade da pessoa jurídica: Alimentação Coletiva Alimentação Escolar Nutrição Clínica e Alimentação Coletiva Nutrição Clínica ambulatório, consultório e atendimento personalizado Nutrição Clínica Alimentação Coletiva ILPI Nutrição Clínica Alimentação Coletiva Serviço de Terapia Renal Substitutiva</li><li>Cópia da prova de vínculo de trabalho vigente com a pessoa jurídica do(s) profissionais (nutricionistas e técnicos em nutrição e dietética)</li><li>Declaração de Veracidade e Autenticidade de Dados e Documentos de Pessoa Jurídica</li><li>Todos os documentos devem ser enviados, exclusivamente, pelo Formulário de envio de documento de Pessoa Jurídica ou de Nutricionista Autônomo</li><li>Havendo dúvidas, entre em contato com o setor de fiscalização (fiscalizacao.atendimento@crn9.org.br)</li></ul>
<ul><li>Alimentação Coletiva</li><li>Alimentação Escolar</li><li>Nutrição Clínica e Alimentação Coletiva</li><li>Nutrição Clínica ambulatório, consultório e atendimento personalizado</li><li>Nutrição Clínica Alimentação Coletiva ILPI</li><li>Nutrição Clínica Alimentação Coletiva Serviço de Terapia Renal Substitutiva</li></ul>'],
            ['title' => 'Solicitação de Certidão', 'slug' => 'servico-solicitacao-de-certidao', 'content' => '<p>O CRN-9 emite certidões de regularidade mediante requerimento por escrito do interessado – Requerimento de Pessoa Jurídica</p>
<p>Constam nas certidões os dados da pessoa jurídica e do nutricionista responsável técnico pelo local e, qualquer alteração nas informações que constam na certidão, invalidam o documento.</p>
<p>Caso a substituição da certidão seja necessária apenas por alteração de dados do contrato social, a pessoa jurídica deve encaminhar a alteração contratual ou documento equivalente junto ao Requerimento de Pessoa Jurídica através do link constante AQUI . A empresa pagará a taxa para emissão de uma nova certidão emitida.</p>
<p>Os documentos devem ser enviados, exclusivamente, por meio do formulário constante AQUI .</p>
<ul><li>A empresa e os nutricionistas e/ou técnicos em Nutrição e Dietética não podem ter pendência financeira com o CRN-9 (anuidades em dia, sem multas, etc.);</li><li>Apresentar atualização cadastral da empresa ( ATUALIZAÇÃO DE DADOS ), incluído todos os nutricionistas e TND da empresa;</li><li>Para concessionárias de alimentação, apresentar a atualização cadastral de todos os clientes da empresa em Minas Gerais;</li><li>Caso o nutricionista/ TND trabalhe em mais de um local, deverá apresentar carga horária distinta para cada um deles sem horário conflitante e considerando possíveis deslocamentos entre os locais de trabalho;</li><li>Para cada local de atuação o nutricionista na empresa deverá ser apresentado um termo de compromisso;</li><li>No caso de concessionárias de alimentação, para cada cliente, deverá ser apresentado um formulário de dimensionamento;</li></ul>
<ul><li>Anuidade do ano corrente pagas do(s) nutricionista(s), TND(s) e pessoa jurídica – CRR da pessoa jurídica é válida 30 de abril do ano seguinte.</li></ul>
<ul><li>A empresa e os nutricionistas e/ou técnicos em Nutrição e Dietética não podem ter pendência financeira com o CRN-9 (anuidades em dia, sem multas, etc.);</li><li>Apresentar atualização cadastral da filial ( ATUALIZAÇÃO DE DADOS ), incluído todos os nutricionistas e técnicos em Nutrição e Dietética da filial;</li><li>No caso de cozinha central, no Formulário termo de compromisso do nutricionista deverá ser informado os dados da cozinha central e no Formulário Dimensionamento Alimentação Coletiva UAN Concessionária deverá ser informado os dados do cliente.</li><li>Caso o nutricionista/ técnicos em Nutrição e Dietética trabalhe em mais de um local, deverá apresentar carga horária distinta para cada um deles sem horário conflitante e considerando possíveis deslocamentos entre os locais de trabalho;</li></ul>
<ul><li>Anuidades do ano corrente pagas do(s) nutricionista(s), TND(s) e pessoa jurídica – CRR de filial é válida 30 de abril do ano seguinte.</li></ul>
<ul><li>Os nutricionistas e/ou técnicos em Nutrição e Dietética não podem ter pendência financeira com o CRN-9 (anuidades em dia, sem multas, etc.);</li><li>Apresentar atualização cadastral da instituição ( ATUALIZAÇÃO DE DADOS ), incluído todos os nutricionistas e técnicos em Nutrição e Dietética que trabalham no local;</li><li>Caso o nutricionista/ técnico em Nutrição e Dietética trabalhe em mais de um local, deverá apresentar carga horária distinta para cada um deles sem horário conflitante e considerando possíveis deslocamentos entre os locais de trabalho;</li><li>Certidões emitidas para setores específicos de Prefeituras e outros órgãos públicos serão emitidas com os dados da pessoa jurídica e endereço do setor, caso os mesmos não tenha CNPJ próprio.</li></ul>
<ul><li>A empresa e o nutricionista e/ou técnicos em Nutrição e Dietética não podem ter pendência financeira com o CRN-9 (anuidades em dia, sem multas, etc.);</li><li>Apresentar atualização cadastral da unidade ( ATUALIZAÇÃO DE DADOS ), incluído todos os nutricionistas e técnicos em Nutrição e Dietética da unidade;</li><li>Caso o nutricionista/ técnico em Nutrição e Dietética trabalhe em mais de um local, deverá apresentar carga horária distinta para cada um deles sem horário conflitante e considerando possíveis deslocamentos entre os locais de trabalho;</li><li>No caso de cozinha central (refeição transporta para outro local), não poderá ser emitida certidão de unidade, apenas CRR de filial.</li></ul>
<ul><li>Anuidade do ano corrente pagas do(s) nutricionista(s), TND(s) e pessoa jurídica – certidão é válida 30 de abril do ano seguinte.</li></ul>
<ul><li>15 dias úteis</li></ul>'],
            ['title' => 'Atualização de Dados', 'slug' => 'servico-atualizacao-de-dados', 'content' => '<p>A pessoa jurídica é responsável por manter atualização de seus dados junto ao CRN-9.</p>
<h3>Quando atualizar os dados junto ao CRN-9</h3>
<p>As informações devem ser atualizadas, sempre que houver alteração de nutricionista responsável técnico ou no quadro técnico do local, alteração significativa no número de serviços prestados, alteração de qualquer informação no contrato social da empresa (razão social, objetivo e capital social, endereço da matriz ou filial principal em Minas Gerais,) inclusão de novos clientes PJ; alteração das informações do cliente PJ (razão social, endereço) ou exclusão de clientes.</p>
<ul><li>Os formulários devem estar completos (duas páginas), legíveis, devidamente preenchidos e assinados, sem emendas ou rasuras que possam comprometer a clareza das informações;</li><li>Serão aceitos apenas os formulários, cuja data seja de até 90 dias anteriores ao recebimento da documentação pelo CRN-9;</li><li>Para atualizações de informações que constam no contrato social, a alteração contratual, documento equivalente, atualização de quadro técnico, número de serviços e dados do cliente, que dependem de envio de formulários, deverão ser enviados deve ser encaminhado por meio do formulário JotForm através do link constante AQUI ;</li><li>Para exclusão de clientes, a pessoa jurídica poderá enviar e-mail para fiscalizacao.atendimento@crn9.org.br, informando a data de encerramento do contrato com o cliente (dia/mês/ano);</li><li>Para substituição ou inclusão de responsável técnico, seguir as orientações do link Solicitação de Anotação</li></ul>
<ul><li>Cópia da prova de vínculo empregatício vigente (carteira de trabalho, contrato de trabalho assinado, ficha de registro de funcionário, termo de posse) de todos os nutricionistas e técnicos em Nutrição e Dietética. Holerites, contracheques, RPA, comprovante de consultoria, assessoria e auditoria, contratos locação de sala e parceria comercial não são aceitos como prova de vínculo empregatício. Caso já tenha sido enviada prova de vínculo anteriormente e essa ainda esteja vigente, não há necessidade de enviar novamente;</li><li>Certidão de nada consta ou certidão positiva com efeitos de negativa de todos os nutricionistas e técnicos em Nutrição e Dietética que trabalham no local Atendimento Online</li></ul>
<ul><li>Requerimento de Pessoa Jurídica .</li><li>Declaração de Veracidade e Autenticidade de Dados e Documentos de Pessoa Jurídica</li><li>Solicitação de Anotação</li><li>Termo de Compromisso do nutricionista RT</li></ul>
<p>Dimensionamento, conforme a atividade da pessoa jurídica:</p>
<ul><li>Alimentação Coletiva</li><li>Alimentação Escolar</li><li>Nutrição Clínica ambulatório, consultório e atendimento personalizado</li><li>Nutrição Clínica e Alimentação Coletiva – Hospital</li><li>Nutrição Clínica Alimentação Coletiva ILPI</li><li>Nutrição Clínica Alimentação Coletiva Serviço de Terapia Renal Substitutiva</li><li>Indústria de Alimentos e Bebidas</li><li>Bufê de Eventos</li></ul>
<p>Observações : para a área de saúde coletiva, enviar o formulário de quadro técnico complementar</p>
<ul><li>Todos os documentos devem ser enviados, exclusivamente, pelo Formulário de envio de documento de Pessoa Jurídica ou de Nutricionista Autônomo .</li><li>Havendo dúvidas, entre em contato com o setor de fiscalização (fiscalizacao.atendimento@crn9.org.br).</li></ul>
<ul><li>Mantenha os dados de sua empresa ou instituição atualizados;</li><li>Caso o cliente não seja declarado e as informações sobre o mesmo não sejam atualizadas, atestados de capacidade técnica expedidos pelo mesmo não poderão ser registrados.</li><li>As certidões não são emitidas automaticamente a partir da solicitação de atualização cadastral, sendo necessária a solicitação por escrito da pessoa jurídica. Para maiores informações consulte o link Solicitação de Certidões .</li></ul>
<ul><li>15 dias úteis</li></ul>
<p>Para mais esclarecimentos, consulte a Resolução CFN nº 702/21 .</p>'],
            ['title' => 'Certidão de Registro de Atestado de Capacidade Técnica de Pessoa Jurídica', 'slug' => 'servico-certidao-de-registro-de-atestado-de-capacidade-tecnica-de-pessoa-juridica', 'content' => '<p>Para fins de comprovação de qualificação técnico-operacional o CRN-9 poderá expedir a Certidão de Registro de Atestado de Capacidade Técnica de Pessoa Jurídica, que tenha sido emitido pela contratante da empresa requerente, demonstrando a capacidade operacional na execução de serviços nas áreas de Alimentação e Nutrição.</p>
<p>O CRN-9 emite certidão de registro de atestado de capacidade técnica referente a serviços prestados no estado de Minas Gerais por empresas com registro ativo no CRN-9.</p>
<h3>A solicitação deve ser feita por meio do formulário constante AQUI . Devem ser encaminhados, ainda:</h3>
<ul><li>Atestado original digital ou digitalizado, acompanhado de Declaração de veracidade e autenticidade conforme Lei Federal 13.726/18</li><li>Requerimento de Pessoa Jurídica</li></ul>
<ul><li>O atestado a ser registrado deverá se referir a serviços prestados no estado de Minas Gerais;</li><li>A empresa deverá ter Registro ativo no CRN-9 durante o período em que foram executados os serviços que constam no atestado;</li><li>A pessoa jurídica deve ter CRR válida;</li><li>O atestado deve ser emitido em papel timbrado do emitente e datado;</li><li>O atestado deve ser assinado por nutricionista responsável técnico ou representante legal do emitente, devidamente identificado;</li><li>Indicar no atestado o número documento que deu origem ao serviço (contrato, nota de empenho, etc.);</li><li>Informar no atestado o período (início e fim) da execução do serviço, especificando dia/mês/ano;</li><li>Indicar no corpo do endereço completo do local onde o serviço foi ou está sendo executado;</li><li>Citar o(s) nome(s) do(s) nutricionista(s) responsável(is) técnico(s) durante o período declarado, o(s) respectivo(s) número(s) de inscrição no CRN-9 e o(s) correspondente(s) período(s) que executou/executaram o(s) serviço(s);</li><li>Descrever, detalhadamente, o serviço executado (tipo e número de refeições produzidas);</li><li>Os documentos enviados não podem conter rasuras, emendas ou danos de qualquer espécie.</li></ul>
<ul><li>15 dias úteis</li></ul>'],
            ['title' => 'Emissão de Atestado de Responsabilidade Técnica e Acervo Técnico', 'slug' => 'servico-emissao-de-atestado-de-responsabilidade-tecnica-e-acervo-tecnico', 'content' => '<p>Atestado de Responsabilidade Técnica por Execução de Serviços: É o documento emitido pelo CRN-9 que comprova a capacitação técnico-profissional do Nutricionista, para apresentação em licitações.</p>
<p>Solicitação: Enviar o formulário de Requerimento de Pessoa Jurídica por meio do link constante AQUI Critérios :</p>
<ul><li>A pessoa jurídica deverá ter CRR válida;</li><li>Nutricionista responsável ter inscrição regular no CRN-9</li><li>Pessoa jurídica não pode ter débitos com o CRN-9</li></ul>
<p>Para mais esclarecimentos, consulte a Resolução CFN nº 703/21 .</p>
<p>Certidão de Acervo Técnico: É o documento que descreve o histórico da atuação da Pessoa Jurídica (unidades/clientes) ou da Pessoa Física (empresas onde trabalhou e atribuição técnica). É elaborado de acordo com os dados constantes no arquivo do CRN-9.</p>
<p>Para solicitar a emissão da Certidão de Acervo Técnico de Pessoa Jurídica, o representante legal deverá preencher e encaminhar o formulário Requerimento de Pessoa Jurídica por meio do formulário constante AQUI .</p>
<p>Para solicitar a emissão da Certidão de Acervo Técnico de Pessoa Física, o profissional deverá preencher e enviar o Formulário de envio de documento de Pessoa Jurídica ou de Nutricionista Autônomo (assinalar a opção “Outros” e escrever, Certidão de Acervo Técnico de Pessoa Física). Caso os trabalhos não tenham sido previamente formalizados ao CRN-9, poderá ser anexada a documentação comprobatória de atuação como autônomo ou vinculado a empresas (neste caso não é possível incluir atribuição técnica como RT). Havendo dúvidas, entrar em contato com o setor de fiscalização ( fiscalizacao@crn9.org.br ).</p>
<p>Para mais esclarecimentos consulte a Resolução CFN nº 703/21.</p>'],
            ['title' => 'Cancelamento/ Baixa Temporária de Inscrição', 'slug' => 'servico-cancelamento-baixa-temporaria-de-inscricao', 'content' => '<h3>Baixa Temporária de Registro:</h3>
<p>Havendo suspensão das atividades relacionadas à alimentação e nutrição, o interessado poderá solicitar a baixa temporária do registro da pessoa jurídica. A baixa é concedida pelo prazo de até 1 (um) ano, podendo ser prorrogada, por igual período, a requerimento do interessado. Findo o prazo total, será efetivado, “ex-ofício”, após visita fiscal, o cancelamento do registro.</p>
<ul><li>Requerimento de Pessoa Jurídica .</li><li>Declaração de veracidade e autenticidade .</li><li>Apresentar documento que comprove a suspensão das atividades ligadas à alimentação e nutrição, assinada pelo representante legal da empresa, declarando o motivo da solicitação.</li><li>Informar, por e-mail ( pj.atendimento@crn9.org.br ) ou por envio de ofício junto à documentação, as datas (dia/mês/ano) dos desligamentos de todos os nutricionistas e técnicos em nutrição, caso ainda não tenham sido informadas.</li><li>Informar as datas (dia/mês/ano) dos encerramentos de todos os contratos com clientes pessoas jurídicas, caso ainda não tenham sido informadas.</li><li>As certidões (CRR, CRR de filial e CRU) expedidas em formato eletrônico pelo CRN9 não estarão mais válidas, portanto, não poderão ser utilizadas pela empresa em nenhuma hipótese.</li></ul>
<ul><li>Em caso de assinatura por procurador, apresentar cópia da procuração registrada em cartório.</li><li>Para reativar inscrição, pessoa jurídica deverá proceder atualização cadastral, conforme orientações do link Atualização de Dados . Caso já tenha ocorrido o cancelamento ex officio da inscrição, a empresa deverá solicitar novo registro, conforme orientações do link Inscrição no CRN-9 .</li><li>A pessoa jurídica que permanecer exercendo as atividades ligadas à alimentação e nutrição humanas, após a baixa temporária do seu registro, incorrerá no exercício irregular da atividade, sujeitando-se às penalidades previstas na legislação vigente.</li></ul>
<p>Solicitação sem ônus .</p>
<h3>Cancelamento de Registro:</h3>
<p>Havendo encerramento das atividades relacionadas à alimentação e nutrição, o interessado poderá solicitar o cancelamento do registro da pessoa jurídica.</p>
<ul><li>Requerimento de Pessoa Jurídica .</li><li>Declaração de veracidade e autenticidade ;</li><li>Apresentar documento que comprove o encerramento das atividades (comprovante de baixa do CNPJ na Receita Federal ou distrato social);</li><li>Informar, por e-mail ( pj.atendimento@crn9.org.br ) ou por envio de ofício junto à documentação, as datas (dia/mês/ano) dos desligamentos de todos os nutricionistas e técnicos em nutrição, caso ainda não tenham sido informadas.</li><li>Informar, por e-mail ( pj.atendimento@crn9.org.br ) ou por envio de ofício junto à documentação,  as datas (dia/mês/ano) dos encerramentos de todos os contratos com clientes pessoas jurídicas, caso ainda não tenham sido informadas.</li><li>As certidões (CRR, CRR de filial e CRU) expedidas em formato eletrônico pelo CRN9 não estarão mais válidas, portanto, não poderão ser utilizadas pela empresa em nenhuma hipótese.</li></ul>
<ul><li>Em caso de assinatura por procurador, apresentar cópia da procuração registrada em cartório.</li><li>O cancelamento do registro poderá ser feito ex-officio nas seguintes situações:</li></ul>
<p>o   Após 3 (três) anos consecutivos de inadimplência da pessoa jurídica em relação ao pagamento de anuidades ao CRN;</p>
<p>o   Quando ficar constatado que a pessoa jurídica não funciona no local indicado ao CRN.</p>
<ul><li>O cancelamento do registro da pessoa jurídica não a exime da responsabilidade pelos atos praticados enquanto registrada no CRN.</li><li>A pessoa jurídica que permanecer exercendo as atividades ligadas à alimentação e nutrição humanas, após o cancelamento do registro, incorrerá no exercício irregular da atividade, sujeitando-se às penalidades previstas na legislação vigente;</li><li>Caso a empresa tenha paralisado as atividades, mas ainda não tenha o documento comprobatório do encerramento das atividades perante os órgãos competentes, deverá solicitar a baixa temporária do registro, e em caso de deferimento da baixa temporária, o cancelamento do registro é feito após um ano, “ex-offício”.</li></ul>
<h3>Cancelamento de Cadastro:</h3>
<p>O cancelamento do cadastro da pessoa jurídica será efetivado pelo CRN9, a qualquer tempo, independentemente de notificação ao cadastrado, quando for constatado que a pessoa jurídica encerrou suas atividades ou que não exerce mais atividades na área de alimentação e nutrição.</p>
<p>Havendo interesse, a Pessoa Jurídica também poderá solicitar o cancelamento do cadastro.</p>
<ul><li>Requerimento de Pessoa Jurídica ;</li><li>Declaração de veracidade e autenticidade ;</li><li>Apresentar documento que comprove a paralização/encerramento das atividades ligadas à alimentação e nutrição ou justificativa por escrito que apresente o motivo da solicitação;</li><li>Informar, por e-mail ( pj.atendimento@crn9.org.br ) ou por envio de ofício junto à documentação, as datas (dia/mês/ano) dos desligamentos de todos os nutricionistas e técnicos em nutrição, caso ainda não tenham sido informadas.</li><li>As certidões de cadastro expedidas em formato eletrônico pelo CRN9 não estarão mais válidas, portanto, não poderão ser utilizadas pela empresa em nenhuma hipótese.</li></ul>'],
            ['title' => 'Anuidade 2024 – Pessoa Jurídica', 'slug' => 'servico-anuidade-2023-pj', 'content' => '<p>Emita o boleto da anuidade 2024 clicando AQUI .</p>
<p>Para as pessoas juridicas abaixo relacionadas: valor de R$ 706,49 (setecentos e seis reais e quarenta e nove centavos) :</p>
<ul><li>Que atuam exclusivamente como serviços comerciais de alimentação;</li><li>Que distribuem e/ou comercializam suplementos alimentares;</li><li>Industrias de alimentos;</li><li>Industrias de bebidas;</li><li>Microempresas e empresas de pequeno porte;</li><li>Empresas que fornecem cestas de alimentos, desde que não seja esta sua atividade principal;</li><li>Pessoas Jurídicas enquadradas no regime tributário do SIMPLES.</li></ul>
<p>Para as demais pessoas jurídicas não incluídas acima serão adotados os valores abaixo conforme a faixa de capital social da empresa:</p>
<ul><li>Ate R$ 50.000,00 R$ 954,72</li><li>De 50.000,01 ate 200.000,00 R$ 1.909,44</li><li>De 200.000,01 ate 500.000,00 R$ 2.864,15</li><li>De 500.000,01 ate 1.000.000,00 R$ 3.818,90</li><li>De 1.000.000,01 ate 2.000.000,00 R$ 4.773,59</li><li>De 2.000.000,01 ate 10.000.000,00 R$ 5.728,32</li><li>Acima de 10.000.000,00 R$ 7.637,75</li></ul>
<p>Empresário Individual: As empresas cujo único sócio seja nutricionista regularmente inscrito no seu respectivo Conselho Regional de Nutricionistas enquadradas em quaisquer das situações previstas no  §1º do art. 1º da Res. CFN Nº 766/2023 quando requerido, e após deferimento pelo Regional, ficarão isentas do pagamento da anuidade prevista, desde que o sócio nutricionista esteja em dia com o pagamento de sua anuidade no exercício de 2024.</p>
<p>Microempresas e demais Empresas enquadradas no Regime Tributário do Simples:</p>
<p>Conforme previsto na Resolução CFN Nº 766/2023, os Microempreendedores Individuais (MEI) terão os custos reduzidos a 0 (zero), inclusive os prévios, à inscrição, ao registro, ao funcionamento, ao alvará, à licença, ao cadastro, às alterações e procedimentos de baixa e encerramento, assim como os valores referentes a taxas, a emolumentos e as demais contribuições, inclusive de anotação de responsabilidade técnica.</p>
<p>FORMAS DE PAGAMENTO:</p>
<p>EM COTA ÚNICA até 10/04/2024</p>
<p>ou em 5 PARCELAS com os seguintes vencimentos: 09/02, 08/03, 10/04, 10/05, 10/06.</p>
<p>COM DESCONTO de 5% para pagamento com vencimento em cota única no dia 09/02/2024 (utilizando o mesmo boleto de pagamento integral)</p>
<p>SEM DESCONTO E SEM ACRÉSCIMO para vencimento cota única em 10/04/2024.</p>
<ol><li>O PAGAMENTO DA ANUIDADE DE 2024 NÃO QUITA DÉBITOS ANTERIORES.</li><li>ANTECIPE A ATUALIZAÇÃO CADASTRAL DE SUA EMPRESA, ENTRE EM CONTATO PELO E-MAIL: pj.atendimento@crn9.org.br</li></ol>'],
            ['title' => 'Visitas Técnicas e Fiscais', 'slug' => 'fiscalizacao-atividade-visitas-tecnicas', 'content' => '<p>As fiscais do CRN9 realizam visitas técnicas de orientação do exercício profissional, visitas fiscais e de apuração de denúncias. As visitas técnicas de orientação do exercício profissional são, geralmente, agendadas previamente e têm por objetivo orientar o nutricionista em seu local de trabalho, visando à melhoria da qualidade do serviço prestado. O instrumento utilizado durante estas visitas é o roteiro de visita técnica, RVT (padronizado pelo CFN e específico para a área de atuação em questão conforme previsto nas Resoluções do CFN nº 465/10 e nº 600/2018). Com a aplicação do roteiro, é possível verificar o cumprimento de atividades obrigatórias e complementares através do relato do profissional e da verificação de documentação comprobatória. Na ausência de RVT a fiscal elabora um relatório descritivo das atividades e estabelece o cumprimento daquelas previstas em legislação vigente. Para mais detalhes sobre as visitas técnicas, consulte o link “ Visitas Técnicas ”</p>
<p>Além de visitas para orientação dos profissionais, são realizadas visitas fiscais sem agendamento, com o objetivo de exigir que empresas e instituições com atividades na área de alimentação e nutrição apresentem um Nutricionista RT pelo serviço ou que procedam ao Registro junto ao CRN9 quando este for obrigatório ou, ainda, que procedam à atualização de dados cadastrais, caso estejam desatualizados. Para todas as solicitações são dadas as devidas orientações e é determinado um prazo. As visitas fiscais também podem ser feitas para diligenciar sobre alguma situação ou para a apuração de denúncias. Em todas as situações é obrigatório que a fiscal se identifique ao entrevistado.</p>'],
            ['title' => 'Projeto Interiorização', 'slug' => 'fiscalizacao-atividade-projeto-interiorizacao', 'content' => '<p>As fiscais do CRN9 realizam visitas de rotina nos municípios onde estão localizadas a sede (BH e região metropolitana) e as delegacias (Ipatinga e região, Juiz de Fora e região, Montes Claros e região, Pouso Alegre e região e Uberlândia e Araguari). Para atender aos demais municípios, desde 2009 é realizado o Projeto Interiorização, que tem por objetivo identificar e atender às demandas de fiscalização do exercício profissional nos municípios que não são visitados rotineiramente, além de promover a politização, apropriação e valorização da profissão pelo interior de Minas Gerais. Neste projeto são programadas viagens das fiscais a diversos municípios de acordo com as demandas levantadas previamente e, além das visitas (técnicas, fiscais e de apuração de denúncias), também podem ocorrer palestras do projeto A Fiscalização do CRN9 Mais Perto de Você e reuniões com gestores para tratar assuntos específicos da área de fiscalização do CRN9.</p>
<p>Durante o período de teletrabalho devido à pandemia do novo Coronavírus, as visitas estão suspensas.</p>'],
            ['title' => 'Ações Estratégicas de Fiscalização', 'slug' => 'fiscalizacao-atividade-acoes-estrategicas-de-fiscalizacao', 'content' => '<p>Anualmente as fiscais desenvolvem 2 ações estratégicas de fiscalização com o objetivo de traçar um diagnóstico da atuação profissional e propor ações de aprimoramento. A cada ano são desenvolvidos, além dos projetos fixos Interiorização , A Fiscalização do CRN9 Mais Perto de Você e Certificação do Nutricionista/Equipe 5 Estrelas , ações estratégicas com foco em determinadas áreas e com objetivos específicos.</p>
<ul><li>Ação em Prefeituras sobre a obrigatoriedade de haver nutricionista responsável técnico pelo Programa de Alimentação Escolar (PAE)</li></ul>
<p>853 municípios no Estado</p>
<p>176 ofícios enviados;</p>
<p>21 municípios apresentaram nutricionista;</p>
<p>115 municípios regularizaram a situação no SINUTRI;</p>
<p>23 municípios informaram possuir RT em contato telefônico;</p>
<p>53 municípios apresentaram RT após receber Comunicado Fiscal;</p>
<p>14 municípios foram encaminhados para o Ministério Público;</p>
<p>Não conseguimos dados de 2 municípios.</p>
<ul><li>Reuniões com as Vigilâncias Sanitárias da Região Metropolitana de Belo Horizonte (RMBH), Uberlândia e Região de Pouso Alegre</li></ul>
<p>O CRN-9 convidou as Vigilâncias Sanitárias (VISA) da RMBH para uma reunião na Sede. Diante do pedido das VISA/s de maiores orientações, a Comissão de Fiscalização solicitou que fosse realizada uma ação especial com as vigilâncias sanitárias municipais nas áreas de visita regular da Sede e Delegacias de Uberlândia e Pouso Alegre. Assim foram visitadas as seguintes VISA/s:</p>
<ul><li>Projeto de Fiscalização da Atuação do Nutricionista em Serviços de Terapia Renal Substitutiva</li></ul>
<ul><li>Projeto de Fiscalização da Atuação do Nutricionista em Bancos de Alimentos</li></ul>
<ul><li>Projeto aprimoramento da atuação do nutricionista em consultórios</li><li>Projeto “Atuação do Técnico em Nutrição e Dietética em Uberlândia”: realização de visitas técnicas aos técnicos em nutrição e dietética que atuam no município de Uberlândia.</li></ul>
<ul><li>Projeto de aprimoramento da atuação do nutricionista em academias e alimentação escolar da rede privada – educação infantil</li></ul>'],
            ['title' => 'Apuração de Denúncias', 'slug' => 'fiscalizacao-atividade-apuracao-de-denuncias', 'content' => '<p>O CRN9 recebe denúncias contra pessoas jurídicas e contra pessoas físicas (ética e de exercício ilegal da profissão) pelo link disponível AQUI .</p>
<p>Cabe à equipe de fiscalização o recebimento e a apuração das denúncias contra pessoas jurídicas e as de exercício ilegal da profissão. Já as denúncias éticas são recebidas e apuradas pela Unidade Técnica, setor que atua conjuntamente à fiscalização. A apuração das denúncias pela fiscalização é feita a partir da sua formalização e das provas que subsidiam as alegações. Considerando que a denúncia tenha os requisitos mínimos para apuração as fiscais elaboram um relatório detalhado a ser encaminhado para avaliação pela Coordenação da Fiscalização e da Comissão de Fiscalização que farão os devidos encaminhamentos.</p>'],
            ['title' => 'Plantão Fiscal', 'slug' => 'fiscalizacao-atividade-plantao-fiscal', 'content' => '<p>O CRN9 disponibiliza em seu atendimento os plantões fiscais direcionados a pessoas físicas e jurídicas que tenham demandas relacionadas ao setor de fiscalização como: dúvidas em relação a questões técnicas do exercício profissional, preenchimento de formulários, emissão de documentos pelo CRN9, responsabilidade técnica, legislação do CFN, denúncias e outras. O atendimento é disponibilizado por telefone, por e-mail e pessoalmente de segunda a sexta-feira de 09:00h às 17:00h. Estão disponíveis para o atendimento telefônico e pessoal as Nutricionistas fiscais (em dias específicos), as Assistentes Técnicas em Nutrição e Dietética (ATNDs) e a estagiária de Nutrição. As ATND atuam diariamente na sede do CRN9, já as fiscais possuem, cada uma, dois dias por semana disponíveis para plantão. Durante esses dias não são realizadas visitas externas, mas as fiscais realizam, além dos atendimentos, outras atividades internas na sede ou nas delegacias. Atividades internas desenvolvidas pelas fiscais:</p>
<ul><li>Programação e agendamento de visitas de rotina e de interiorização por telefone e por e-mail;</li><li>Análise de solicitações de pessoas jurídicas e de concessão de RT;</li><li>Elaboração de relatórios circunstanciados, relatórios de visita técnica para análise e relatórios de denúncia;</li><li>Acompanhamento de ações fiscais, lavratura de Comunicados Fiscais e Autos de Infração, abertura de processos de infração e de denúncia;</li><li>Preenchimento de planilhas de controle e de indicadores;</li><li>Prestação de contas de adiantamentos recebidos para a realização de visitas de rotina e de interiorização;</li><li>Envio de RVT e de material técnico por e-mail aos profissionais visitados;</li><li>Elaboração de relatório mensal de atividades;</li><li>Estudo de Resoluções e contribuições em minutas de Resoluções do CFN;</li><li>Elaboração de projetos e de relatórios de projetos;</li><li>Elaboração de Instruções de Trabalho e de padronizações;</li><li>Elaboração de apresentações para palestras institucionais;</li><li>Levantamento de informações demandadas pela gestão do CRN9 por telefone e por e-mails e com o preenchimento de planilhas;</li><li>Revisão de conteúdo publicado no site.</li></ul>
<p>Mesmo em tempos de isolamento social devido à pandemia do Covid-19, o trabalho do CRN-9 não para e um importantíssimo canal de atendimento é o das videoconferências com o setor de Fiscalização.</p>
<p>Para agendar o atendimento clique AQUI</p>'],
            ['title' => 'Projeto Nutricionista/Equipe 5 Estrelas', 'slug' => 'fiscalizacao-atividade-projeto-nutricionista-equipe-5-estrelas', 'content' => '<p>Com o intuito de reconhecer o trabalho de excelência e valorizar os nutricionistas que têm uma prática profissional qualificada e em conformidade com o Código de Ética e de Conduta do Nutricionista (CECN) o setor de fiscalização do CRN9 executa, desde 2018, o Projeto Nutricionista 5 Estrelas/Equipe 5 Estrelas como forma de estimular a melhoria contínua nos trabalhos prestados a indivíduos e à coletividade, de modo a garantir os objetivos da Política Nacional de Fiscalização (Resolução CFN nº 527/2013). A partir da visita técnica o Nutricionista pode ser indicado para receber o Certificado Nutricionista/Equipe 5 Estrelas desde que cumpra os seguintes critérios:</p>
<p>I – Realização de todas as atividades obrigatórias constantes do Roteiro de Visita Técnica (RVT) aplicado durante a visita técnica;</p>
<p>II – Obtenção de “meta padrão” na avaliação de todos os indicadores qualitativos do RVT;</p>
<p>III – Realização de todas as atividades dos indicadores quantitativos do RVT;</p>
<p>IV –  Realização de todas as atividades complementares do RVT que dependam exclusivamente do nutricionista;</p>
<p>V – Em caso de equipe, inscrição profissional de todos os nutricionistas do quadro técnico em situação regular perante o CRN9, sem débitos, sem condenação em Processo Ético ou de infração;</p>
<p>VI – Evidências de que o trabalho realizado é diferenciado, sendo considerado destaque naquela área de atuação (constatado pela fiscal no momento da visita);</p>
<p>VII – Para os casos de visita técnica sem aplicação de RVT e avaliado o cumprimento das atribuições, por área de atuação, que estão previstas na Resolução CFN nº 600/2018;</p>
<p>Caso você queira receber a visita de uma de nossas fiscais, preencha a solicitação no link: https://form.jotformz.com/91114009657656</p>
<p>Durante o período de teletrabalho devido à pandemia do novo Coronavírus, as visitas estão suspensas.</p>'],
        ];

        // Correção sistêmica: a extração inicial de conteúdo (heurística
        // h2/h3/p/ul em texto puro) removia os links (`<a href>`) de dentro
        // dos parágrafos e listas, derrubando links de download e
        // direcionamentos em dezenas de páginas. Este arquivo traz o
        // conteúdo re-extraído preservando esses links, por slug.
        $linkFixes = json_decode(file_get_contents(__DIR__.'/data/pages_link_overrides.json'), true);

        foreach ($pages as $page) {
            if (isset($linkFixes[$page['slug']])) {
                $page['content'] = $linkFixes[$page['slug']];
            }

            Page::updateOrCreate(['slug' => $page['slug']], $page + ['is_published' => true]);
        }
    }

    /**
     * As páginas de "índice" (Serviços por categoria, Licitações, Biblioteca
     * Virtual, Atividades da Fiscalização) recebem, ao final do seu conteúdo,
     * a lista real de itens individuais migrados de crn9.org.br, com link
     * para a página de cada um.
     */
    private function linkIndexPages(): void
    {
        $groups = [
            'servicos-nutricionistas' => [
                ['title' => 'Anuidade 2026 Nutricionistas', 'slug' => 'servico-anuidade-2026-nutricionista'],
                ['title' => 'Inscrição Provisória – Nutricionista', 'slug' => 'servico-inscricao-provisoria-pf-nutri'],
                ['title' => 'Inscrição de provisória para definitiva – Nutricionista', 'slug' => 'servico-inscricao-de-provisoria-para-definitiva-nutri'],
                ['title' => 'Inscrição Definitiva – Nutricionista', 'slug' => 'servico-inscricao-definitiva-pf-nutri'],
                ['title' => 'Transferência – Nutricionista', 'slug' => 'servico-transferencia-pf-nutri'],
                ['title' => 'Inscrição secundária – Nutricionista', 'slug' => 'servico-inscricao-secundaria-pf-nutri'],
                ['title' => 'Prorrogação de inscrição provisória – Nutricionista', 'slug' => 'servico-prorrogacao-de-inscricao-provisoria'],
                ['title' => 'Baixa Temporária – Nutricionista', 'slug' => 'servico-baixa-temporaria'],
                ['title' => 'Cancelamento de Inscrição – Nutricionista', 'slug' => 'servico-cancelamento-de-inscricao'],
                ['title' => 'Reativação de Inscrição – Nutricionista', 'slug' => 'servico-reativacao-de-inscricao'],
                ['title' => 'Solicitação de Certidão de Regularidade – Nutricionista', 'slug' => 'servico-solicitacao-certidao-regularidade-nutri'],
                ['title' => 'Solicitação de segunda via de carteira profissional – Nutricionista', 'slug' => 'servico-solicitacao-de-segunda-via-de-carteira-profissional'],
            ],
            'servicos-tnd' => [
                ['title' => 'Solicitação de segunda via de carteira profissional – TND', 'slug' => 'servico-solicitacao-de-segunda-via-de-carteira-profissional-2'],
                ['title' => 'Anuidade 2026 – TND', 'slug' => 'servico-anuidade-2026-tnd'],
                ['title' => 'Inscrição Provisória – TND', 'slug' => 'servico-inscricao-provisoria-pf-tnd'],
                ['title' => 'Inscrição de provisória para definitiva – TND', 'slug' => 'servico-inscricao-de-provisoria-para-definitiva-tnd'],
                ['title' => 'Inscrição Definitiva – TND', 'slug' => 'servico-inscricao-definitiva-pf-tnd'],
                ['title' => 'Transferência – TND', 'slug' => 'servico-transferencia-pf-tnd'],
                ['title' => 'Inscrição secundária – TND', 'slug' => 'servico-inscricao-secundaria-pf-tnd'],
                ['title' => 'Prorrogação de inscrição provisória – TND', 'slug' => 'servico-prorrogacao-de-inscricao-provisoria-2'],
                ['title' => 'Baixa Temporária – TND', 'slug' => 'servico-baixa-temporaria-2'],
                ['title' => 'Cancelamento de Inscrição – TND', 'slug' => 'servico-cancelamento-de-inscricao-2'],
                ['title' => 'Reativação de Inscrição – TND', 'slug' => 'servico-reativacao-de-inscricao-2'],
                ['title' => 'Prorrogação de Baixa Temporária – TND', 'slug' => 'servico-prorrogacao-de-baixa-temporaria-tnd'],
                ['title' => 'Solicitação de Certidão de Regularidade – TND', 'slug' => 'servico-solicitacao-certidao-regularidade-tnd'],
            ],
            'servicos-pessoa-juridica' => [
                ['title' => 'Anuidade 2026 – Pessoa Jurídica', 'slug' => 'servico-anuidade-2026-pj'],
                ['title' => 'Anuidade 2024 – Pessoa Jurídica', 'slug' => 'servico-anuidade-2023-pj'],
                ['title' => 'Atualização de Dados', 'slug' => 'servico-atualizacao-de-dados'],
                ['title' => 'Certidão de Registro de Atestado de Capacidade Técnica de Pessoa Jurídica', 'slug' => 'servico-certidao-de-registro-de-atestado-de-capacidade-tecnica-de-pessoa-juridica'],
                ['title' => 'Registro de Documentação Fitoterapia/PICS', 'slug' => 'servico-registro-de-documentacao-fitoterapia-pics'],
                ['title' => 'Registro do Título de Especialista', 'slug' => 'servico-especialidades'],
                ['title' => 'Anotação de Responsabilidade Técnica', 'slug' => 'servico-responsabilidade-tecnica'],
                ['title' => 'Cadastro da atuação como autônomo', 'slug' => 'servico-cadastro-da-atuacao-como-autonomo'],
                ['title' => 'Documentos para atuação no PNAE', 'slug' => 'servico-documentos-para-atuacao-no-pnae'],
                ['title' => 'Comunicado de Afastamento', 'slug' => 'servico-https-crn9-org-br-servico-comunicado-de-afastamento'],
                ['title' => 'Inscrição no CRN-9 (Registro e Cadastro)', 'slug' => 'servico-inscricao-no-crn-9-registro-e-cadastro'],
                ['title' => 'Solicitação de Certidão', 'slug' => 'servico-solicitacao-de-certidao'],
                ['title' => 'Emissão de Atestado de Responsabilidade Técnica e Acervo Técnico', 'slug' => 'servico-emissao-de-atestado-de-responsabilidade-tecnica-e-acervo-tecnico'],
                ['title' => 'Cancelamento/Baixa Temporária de Inscrição', 'slug' => 'servico-cancelamento-baixa-temporaria-de-inscricao'],
                ['title' => 'Prorrogação de Baixa Temporária', 'slug' => 'servico-prorrogacao-de-baixa-temporaria'],
            ],
            'atividades-da-fiscalizacao' => [
                ['title' => 'Visitas Técnicas e Fiscais', 'slug' => 'fiscalizacao-atividade-visitas-tecnicas'],
                ['title' => 'Projeto Interiorização', 'slug' => 'fiscalizacao-atividade-projeto-interiorizacao'],
                ['title' => 'Ações Estratégicas de Fiscalização', 'slug' => 'fiscalizacao-atividade-acoes-estrategicas-de-fiscalizacao'],
                ['title' => 'Apuração de Denúncias', 'slug' => 'fiscalizacao-atividade-apuracao-de-denuncias'],
                ['title' => 'Plantão Fiscal', 'slug' => 'fiscalizacao-atividade-plantao-fiscal'],
                ['title' => 'Projeto Nutricionista/Equipe 5 Estrelas', 'slug' => 'fiscalizacao-atividade-projeto-nutricionista-equipe-5-estrelas'],
            ],
        ];

        foreach ($groups as $indexSlug => $items) {
            $page = Page::where('slug', $indexSlug)->first();

            if (! $page) {
                continue;
            }

            $links = collect($items)
                ->map(fn (array $item) => '<li><a href="/paginas/'.$item['slug'].'">'.$item['title'].'</a></li>')
                ->implode('');

            $marker = '<!-- itens-relacionados -->';

            if (str_contains($page->content, $marker)) {
                continue;
            }

            $page->update([
                'content' => $page->content."\n{$marker}\n<h3>Itens relacionados</h3>\n<ul>{$links}</ul>",
            ]);
        }
    }

    /**
     * Estrutura real do menu principal do crn9.org.br (7 grupos), com os
     * mesmos rótulos e destinos. Itens que no site de origem apontam para
     * domínios fora de crn9.org.br permanecem externos, sem alteração.
     */
    private function seedMenu(): void
    {
        $groups = [
            [
                'label' => 'Conselho',
                'children' => [
                    ['label' => 'O CRN9', 'url' => '/paginas/o-crn-9'],
                    ['label' => 'Plenário', 'url' => '/plenario'],
                    ['label' => 'Política de ingresso', 'url' => '/paginas/politica-de-ingresso'],
                    ['label' => 'Concurso público', 'url' => '/paginas/concurso-publico'],
                    ['label' => 'Licitações', 'url' => '/licitacoes'],
                    ['label' => 'Sede', 'url' => '/paginas/sede-delegacias'],
                    ['label' => 'Identidade Visual do CRN-9', 'url' => '/paginas/identidade-visual-do-crn-9'],
                ],
            ],
            [
                'label' => 'Serviços',
                'children' => [
                    ['label' => 'Nutricionistas', 'url' => '/paginas/servicos-nutricionistas'],
                    ['label' => 'Técnicos em Nutrição e Dietética', 'url' => '/paginas/servicos-tnd'],
                    ['label' => 'Pessoa Jurídica', 'url' => '/paginas/servicos-pessoa-juridica'],
                ],
            ],
            [
                'label' => 'Acontece no CRN-9',
                'children' => [
                    ['label' => 'Notícias', 'url' => '/noticias'],
                    ['label' => 'Eventos', 'url' => '/agenda'],
                    ['label' => 'Revista Online', 'url' => '/revistas'],
                    ['label' => 'CRN-9 Divulga', 'url' => '/paginas/crn9-divulga'],
                    ['label' => 'Projetos de lei em andamento', 'url' => '/paginas/projetos-de-lei-em-andamento'],
                    [
                        // Filhos deste item são geridos automaticamente pelo
                        // CampaignObserver (App\Observers\CampaignObserver)
                        // sempre que uma campanha é criada/editada/removida
                        // pelo painel admin — ver seedCampaigns() abaixo.
                        'label' => 'Campanhas',
                        'children' => [],
                    ],
                ],
            ],
            [
                'label' => 'Biblioteca Virtual',
                'url' => '/biblioteca',
            ],
            [
                'label' => 'Nutrição em Minas',
                'url' => '/nutricao-em-minas',
            ],
            [
                'label' => 'Fiscalização',
                'children' => [
                    ['label' => 'O que é Fiscalização', 'url' => '/paginas/o-que-e-fiscalizacao'],
                    ['label' => 'Como Funciona (Atividades da Fiscalização)', 'url' => '/paginas/atividades-da-fiscalizacao'],
                    ['label' => 'Áreas de Atuação Fiscalizadas', 'url' => '/paginas/areas-de-atuacao-fiscalizadas'],
                    ['label' => 'Visita Fiscal (Recebi uma Fiscalização)', 'url' => '/fiscalizacao/recebi-uma-fiscalizacao'],
                    ['label' => 'Responsabilidade Técnica', 'url' => '/paginas/responsabilidade-tecnica'],
                    ['label' => 'Quadro Técnico', 'url' => '/fiscalizacao'],
                    ['label' => 'Exercício Ilegal da Profissão', 'url' => '/paginas/exercicio-ilegal-da-profissao'],
                    ['label' => 'Denúncias', 'url' => '/paginas/denuncia'],
                    ['label' => 'Perguntas Frequentes (Fiscalização)', 'url' => '/paginas/duvidas-frequentes-fiscalizacao'],
                    ['label' => 'Materiais Orientativos', 'url' => '/paginas/orientacoes-online'],
                    ['label' => 'Relatórios da Fiscalização', 'url' => '/paginas/relatorios-da-fiscalizacao'],
                    ['label' => 'Projetos Especiais', 'url' => '/paginas/projetos-especiais-fiscalizacao'],
                    ['label' => 'Fiscalização em Números', 'url' => '/fiscalizacao/em-numeros'],
                    ['label' => 'Processos em Andamento', 'url' => '/fiscalizacao/processos'],
                    ['label' => 'Política Nacional de Fiscalização', 'url' => '/paginas/politica-nacional-de-fiscalizacao'],
                    ['label' => 'Visitas Técnicas', 'url' => '/paginas/visitas-tecnicas'],
                ],
            ],
            [
                'label' => 'Orientação',
                'children' => [
                    ['label' => 'Guia do Recém-Formado', 'url' => '/orientacao/guia-do-recem-formado'],
                    ['label' => 'Legislação Regional', 'url' => 'https://crn-mg.implanta.net.br/portaltransparencia/#publico/inicio', 'external' => true],
                    ['label' => 'Legislação Federal', 'url' => 'https://cfn.org.br/legislacao/', 'external' => true],
                    ['label' => 'Links Importantes', 'url' => '/paginas/links-importantes'],
                    ['label' => 'Oportunidade de emprego', 'url' => '/vagas'],
                    ['label' => 'Perguntas Frequentes', 'url' => '/perguntas-frequentes'],
                    ['label' => 'Pode ou Não Pode?', 'url' => '/pode-ou-nao-pode'],
                    ['label' => 'Calculadoras de Dimensionamento', 'url' => '/ferramentas/calculadoras'],
                    ['label' => 'Repositório de Modelos Editáveis', 'url' => '/ferramentas/modelos'],
                ],
            ],
            [
                'label' => 'Profissionais',
                'children' => [
                    ['label' => 'Profissionais por Municípios', 'url' => '/profissionais-por-municipio'],
                    ['label' => 'Encontre um Nutricionista', 'url' => 'https://cnn.cfn.org.br/application/index/consulta-nacional', 'external' => true],
                    ['label' => 'Instituições de Ensino', 'url' => '/instituicoes-de-ensino'],
                ],
            ],
            [
                'label' => 'Outros',
                'children' => [
                    ['label' => 'Ouvidoria', 'url' => '/paginas/ouvidoria'],
                    ['label' => 'Contato', 'url' => '/paginas/fale-conosco'],
                    ['label' => 'Convênios', 'url' => '/paginas/convenios'],
                ],
            ],
        ];

        foreach ($groups as $groupIndex => $group) {
            $this->createMenuTreeItem($group, null, $groupIndex + 1);
        }
    }

    private function createMenuTreeItem(array $item, ?int $parentId, int $sortOrder): void
    {
        $isExternal = $item['external'] ?? false;

        $menuItem = MenuItem::updateOrCreate(
            ['label' => $item['label'], 'parent_id' => $parentId],
            [
                'url' => $item['url'] ?? '#',
                'sort_order' => $sortOrder,
                'is_external' => $isExternal,
                'opens_new_tab' => $isExternal,
            ]
        );

        foreach (($item['children'] ?? []) as $childIndex => $child) {
            $this->createMenuTreeItem($child, $menuItem->id, $childIndex + 1);
        }
    }

    /**
     * Campanhas em série (vídeos), agora geridas pelo painel admin em vez
     * de páginas estáticas. Cada campanha vira automaticamente um submenu
     * de Acontece no CRN-9 › Campanhas via CampaignObserver.
     */
    private function seedCampaigns(): void
    {
        $items = [
            [
                'title' => 'Pode x Não Pode',
                'slug' => 'pode-x-nao-pode',
                'intro' => '<p>A série "Pode x Não Pode" é baseada na cartilha sobre o exercício ilegal da profissão, elaborada pela Comissão de Formação Profissional do CRN-9 e destinada a acadêmicos de cursos de graduação em Nutrição.</p>',
                'episodes' => [
                    ['title' => 'Vídeo 1 – Dicas sobre a atuação nas redes sociais', 'youtube_url' => 'https://www.youtube.com/embed/bqBQuz1x_K8'],
                    ['title' => 'Vídeo 2 – Sobre grupos de emagrecimento no WhatsApp', 'youtube_url' => 'https://www.youtube.com/embed/9xuxWdX1OsQ'],
                    ['title' => 'Vídeo 3 – Sobre prescrição de planos alimentares para familiares', 'youtube_url' => 'https://www.youtube.com/embed/UrzCZaMuXRU'],
                    ['title' => 'Vídeo 4 – Sobre realização de palestras', 'youtube_url' => 'https://www.youtube.com/embed/f9j2n_voO6I'],
                    ['title' => 'Vídeo 5 – Sobre publicação de cálculos dietéticos', 'youtube_url' => 'https://www.youtube.com/embed/ftdEh6NbOGc'],
                    ['title' => 'Vídeo 6 – Sobre publicação de "antes x depois" nas redes sociais, vínculo c/ marcas de produtos, etc', 'youtube_url' => 'https://www.youtube.com/embed/b27iTYhFNvI'],
                    ['title' => 'Vídeo 7 – Sobre a realização de atendimentos antes da colação de grau', 'youtube_url' => 'https://www.youtube.com/embed/76NuApN1s3g'],
                    ['title' => 'Vídeo 8 – Sobre perfil com informações sobre composição nutricional e propriedades dos alimentos', 'youtube_url' => 'https://www.youtube.com/embed/UI-upE3k6kw'],
                    ['title' => 'Vídeo 9 – Sobre a prescrição de planos alimentares/dietas', 'youtube_url' => 'https://www.youtube.com/embed/46lZKmjSM4s'],
                    ['title' => 'Vídeo 10 – Sobre a publicização de planos alimentares feitos para si mesmos', 'youtube_url' => 'https://www.youtube.com/embed/XkkHn9wgaXo'],
                ],
            ],
            [
                'title' => 'Deu Ruim ou Tá de Boa?',
                'slug' => 'deu-ruim-ou-ta-de-boa',
                'intro' => '<p>Nesta série, o CRN-9 aborda o Código de Ética e Conduta dos Nutricionistas de forma lúdica e atrativa, utilizando o jeito "mineirês" de se comunicar. O objetivo é alertar os(as) profissionais sobre o que pode ou não ser realizado em suas atuações.</p>
<p>Os episódios são lançados nas redes sociais oficiais do CRN-9, quinzenalmente: <a href="http://instagram.com/crn9online" target="_blank" rel="noopener">instagram.com/crn9online</a>, <a href="http://facebook.com/crn9online" target="_blank" rel="noopener">facebook.com/crn9online</a> e <a href="http://youtube.com/crn9online" target="_blank" rel="noopener">youtube.com/crn9online</a>.</p>',
                'episodes' => [
                    ['title' => 'Episódio 1', 'youtube_url' => 'https://www.youtube.com/embed/hHcL-kSL-UU'],
                    ['title' => 'Episódio 2', 'youtube_url' => 'https://www.youtube.com/embed/upScENU2Bc8'],
                    ['title' => 'Episódio 3', 'youtube_url' => 'https://www.youtube.com/embed/lAz6HVa9NNs'],
                    ['title' => 'Episódio 4', 'youtube_url' => 'https://www.youtube.com/embed/mWWMDUsNwH0'],
                    ['title' => 'Episódio 5', 'youtube_url' => 'https://www.youtube.com/embed/-COB65cod7o'],
                    ['title' => 'Episódio 6', 'youtube_url' => 'https://www.youtube.com/embed/GGgflpYWGYI'],
                    ['title' => 'Episódio 7', 'youtube_url' => 'https://www.youtube.com/embed/0Npxs3jllOg'],
                    ['title' => 'Episódio 8', 'youtube_url' => 'https://www.youtube.com/embed/GbS_-1YLeKc'],
                ],
            ],
        ];

        foreach ($items as $index => $item) {
            $campaign = Campaign::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'intro' => $item['intro'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );

            foreach ($item['episodes'] as $episodeIndex => $episode) {
                CampaignEpisode::updateOrCreate(
                    ['campaign_id' => $campaign->id, 'title' => $episode['title']],
                    [
                        'campaign_id' => $campaign->id,
                        'title' => $episode['title'],
                        'youtube_url' => $episode['youtube_url'],
                        'sort_order' => $episodeIndex + 1,
                    ]
                );
            }
        }
    }

    private function seedNews(User $admin): void
    {
        $items = [
            ['title' => 'CRN-9 participa do Ganepão e apresenta estudo sobre a atuação do nutricionista em equipes de terapia nutricional', 'category' => 'Institucional', 'is_featured' => true, 'excerpt' => 'O Conselho Regional de Nutrição da 9ª Região (CRN-9) participa do Ganepão 2026, um dos mais importantes eventos científicos da área da Nutrição na América Latina. O congresso...', 'image' => 'ganepao.png', 'body' => '<p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) participa do Ganepão 2026, um dos mais importantes eventos científicos da área da Nutrição na América Latina. O congresso acontece entre os dias 10 e 12 de junho, no Centro de Convenções Frei Caneca, em São Paulo (SP), reunindo profissionais, pesquisadores e estudantes para debater os avanços e os desafios da profissão. A delegação do CRN-9 é composta por conselheiras e nutricionistas fiscais.</p>
<p>Com o tema “Futuro da Nutrição: ciência, vida real, tecnologia e revolução no cuidado”, a edição deste ano promove discussões sobre inovação, produção científica e práticas que impactam diretamente a assistência nutricional.</p>
<p>Representando o CRN-9, as nutricionistas fiscais Rayane Lemos e Cleisiane Ruthe apresentam o trabalho “Diagnóstico da atuação do nutricionista em Equipe Multidisciplinar de Terapia Nutricional (EMTN)”. O estudo foi desenvolvido a partir dos dados obtidos durante as ações de fiscalização realizadas pelo Conselho em 2025, evidenciando o papel estratégico do nutricionista nas equipes responsáveis pela terapia nutricional em serviços de saúde.</p>
<p>Segundo Rayane Lemos, a participação no congresso fortalece a disseminação do conhecimento técnico e científico produzido a partir da atuação fiscalizatória do CRN-9. “A apresentação deste trabalho contribui para ampliar o conhecimento sobre a atuação do nutricionista nas EMTNs e reforça a importância desse profissional na promoção da segurança e da qualidade da assistência nutricional. O estudo também evidencia o compromisso da fiscalização com a produção de conhecimento, a valorização profissional e o fortalecimento da Nutrição nos serviços de saúde”, destaca.</p>
<p>Produção científica e qualificação profissional</p>
<p>Além do trabalho desenvolvido no âmbito da fiscalização, a nutricionista fiscal Cleisiane Ruthe também apresenta a pesquisa vinculada ao curso de mestrado que realiza na Universidade Federal de Ouro Preto (UFOP). O estudo tem como tema “Tempo de tela de estudantes de escolas públicas municipais de Mariana e Ouro Preto” e integra as atividades do Programa de Pós-Graduação em Saúde e Nutrição da instituição.</p>
<p>A participação da profissional reforça o compromisso do CRN-9 com a qualificação contínua de sua equipe técnica e com o incentivo à produção científica voltada para a promoção da saúde e da qualidade de vida da população.</p>
<p>Delegação do CRN-9 no Ganepão 2026</p>
<p>A delegação do CRN-9 no Ganepão 2026 é composta pela diretora-financeira Maria Gonçalves Soares; pelas conselheiras Ana Cláudia Alves Freire Ribeiro, Deise Lima Santos e Laisa Rodrigues Cavalcante; e pelas nutricionistas fiscais Cleisiane Ruthe e Rayane Lemos.</p>
<p>A presença institucional no congresso reafirma o compromisso do Conselho com o fortalecimento da profissão, a valorização da atuação do nutricionista e o incentivo à produção e à difusão do conhecimento científico na área da Nutrição.</p>'],
            ['title' => 'Evento sobre ILPIs traça panorama e aponta caminhos do cuidado nutricional para idosos', 'category' => 'Eventos', 'is_featured' => false, 'excerpt' => 'Em evento transmitido, ao vivo, no dia 9 de março, o CRN-9 apresentou os dados parciais do projeto “Aprimoramento da atuação da(o) Nutricionista em Instituições de Longa...', 'image' => 'ilpis.png', 'body' => '<p>Em evento transmitido, ao vivo, no dia 9 de março, o CRN-9 apresentou os dados parciais do projeto “Aprimoramento da atuação da(o) Nutricionista em Instituições de Longa Permanência para Idosos (ILPI)”, promovido pela Unidade de Fiscalização do Conselho. A transmissão foi encerrada com a palestra “A prática da(o) Nutricionista no cuidado nutricional do idoso”, ministrada pela Nutricionista Camila Dias.</p>
<p>Iniciado em 2022, o projeto, apresentado pela supervisora da Unidade de Fiscalização, Eliane Azevedo Barros, visou conhecer o perfil de atendimento dos nutricionistas em ILPIs de Minas Gerais, estreitar a relação dos profissionais com a equipe de fiscalização, além de incentivar a melhoria na qualidade da assistência nutricional prestada ao público assistido por esses profissionais.</p>
<p>Entre setembro de 2022 e fevereiro de 2023, foram aplicados 136 roteiros com Nutricionistas, por meio de visitas técnicas ou videoconferência. No total foram levantadas a existência de 721 ILPI’s em Minas.</p>
<p>Os levantamentos demonstraram as características das instituições e dos profissionais que atuam nessa área e trouxeram o descritivo detalhado das atividades obrigatórias na área de nutrição clínica e alimentação coletiva, apurado durante a aplicação do roteiro.</p>
<p>Os dados podem ser conferidos aqui:</p>
<p>Para que o projeto vá além do levantamento de dados e provoque mudanças práticas na atuação das(os) Nutricionistas e no atendimento nutricional aos idosos, o CRN-9 apresentou a iniciativa à Vigilância Sanitária de Minas Gerais, em reunião on-line realizada em setembro de 2022. Também foi encaminhado ofício à VISA-MG, em fevereiro de 2023, para propor colaboração em apresentar às unidades regionais de saúde, bem como às vigilâncias sanitárias municipais, as legislações que embasam a exigência de Nutricionistas nas ILPIs.</p>
<p>Após a divulgação do projeto, o CRN-9 recebeu a mestre em Nutrição e Saúde (UFMG), doutoranda em Ciências Aplicadas à Saúde do Adulto (UFMG), professora e residente em Saúde do Idoso (HRTN), Camila Dias. A profissional abordou na palestra “A prática do nutricionista no cuidado nutricional do idoso”, questões nutricionais, legais e dados demográficos nacionais que demonstram a condição das pessoas que têm 60 anos de idade ou mais.</p>
<p>A palestra pode ser assistida no Canal CRN9Online, no You Tube. Clique aqui .</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN-9 aborda Alimentação Saudável em Fórum de Agroecologia e Agricultura Orgânica', 'category' => 'Eventos', 'is_featured' => false, 'excerpt' => 'O CRN-9 esteve presente no Fórum de Agroecologia e Agricultura Orgânica realizado em Teófilo Otoni, no dia 23 de  maio, representado pela nutricionista e Diretora Tesoureira do...', 'image' => 'agroecologia.jpeg', 'body' => '<p>O CRN-9 esteve presente no Fórum de Agroecologia e Agricultura Orgânica realizado em Teófilo Otoni, no dia 23 de  maio, representado pela nutricionista e Diretora Tesoureira do Conselho, Daniela Corrêa Ferreira,</p>
<p>Daniela falou a centenas de pessoas sobre “A Importância da Alimentação Saudável” e reforçou a proposta disseminar informações importantes à população sobre a Agroecologia – uma forma de agricultura sustentável. Um conjunto de práticas que unem questões sociais, políticas, culturais e éticas.</p>
<p>O evento, sediado no Centro de Convenções Expominas, termina nesta sexta-feira, 27, mas ao longo da semana ofereceu, aos presentes, palestras, dia de campo, shows, espaço para comercialização e praça de alimentação.</p>
<p>Em sua apresentação, Daniela enfatizou a importância da alimentação que contenha alimentos “in natura”, produzidos pela agricultura familiar e sem agrotóxicos. Sua abordagem enfatizou também que o consumo destes alimentos está relacionado  com a qualidade de vida, redução de doenças crônicas não transmissíveis como diabetes, hipertensão e lipidemias. Ela ainda reforçou que esta prática está alinhada com as diretrizes da Alimentação Saudável preconizada  pelo Guia Alimentar para a População Brasileira.</p>
<p>De acordo com Daniela, a participação do Conselho como convidado do evento mostra um CRN-9 alinhado e comprometido com as diretrizes de atuação dos profissionais de Nutrição de todo o Estado.</p>
<p>“Endossa toda a dedicação e trabalho de qualidade que são prestados diariamente por nutricionistas de Minas Gerais. Este evento foi importante para ampliar discussões que levem à implementação de políticas públicas de saúde que tenham a Nutrição como foco”, explicou.</p>
<p>Segundo Padre Honório José de Siqueira, um dos organizadores, ao longo dos dias foram realizadas 35 oficinas, com temas diversas, seis palestras e 11 temas discutidos em grupos de trabalho de campo.</p>
<p>Ao longo da semana passaram por lá autoridades de diversos municípios do Vale do Mucuri, além de representantes do Governo de Minas.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Sarcopenia é tema de palestra presencial em Juiz de Fora', 'category' => 'Eventos', 'is_featured' => false, 'excerpt' => 'As inscrições para o evento presencial “O papel do Nutricionista na triagem e diagnóstico de Sarcopenia” promovido pelo Conselho Regional de Nutricionistas da 9ª Região (CRN-9)...', 'image' => 'sarcopenia.png', 'body' => '<p>As inscrições para o evento presencial “O papel do Nutricionista na triagem e diagnóstico de Sarcopenia” promovido pelo Conselho Regional de Nutricionistas da 9ª Região (CRN-9) Juiz de Fora estão no fim.</p>
<p>Não perca tempo e se inscreva logo AQUI!</p>
<p>A palestra, gratuita e com emissão de certificado , é direcionada a profissionais e estudantes de Nutrição.</p>
<p>A Sarcopenia é caracterizada pela perda progressiva e generalizada de massa muscular esquelética e força muscular do indivíduo, e com isso pode impactar negativamente na qualidade de vida destas pessoas, tem sido cada vez mais alvo de estudos.</p>
<p>De acordo com a nutricionista e professora da UFJF, Daniela Corrêa Ferreira, estudos apontam que a Sarcopenia pode ocorrer a partir da 4ª década de vida e/ou em decorrência de doenças como câncer e Covid-19, por exemplo, e pode estar associada à má qualidade da alimentação.</p>
<p>Desta forma, durante a apresentação que acontece nesta quinta, às 19h, a especialista vai abordar temas como o que realmente é a sarcopenia, quando ela ocorre, quais são os fatores de risco, como é feito o diagnóstico e a prevenção, entre outros.</p>
<p>De acordo com a palestrante, o evento que também é aberto ao público em geral é de extrema importância para garantir maior capacitação dos profissionais de Nutrição sobre um tema que é novo e precisa de muita atenção. “A proposta é garantir que nutricionistas possam contribuir para evitar o desenvolvimento e até mesmo reversão desse quadro”, finaliza Daniela.</p>
<p>O encontro ocorre na quinta-feira, 21/07, às 19h, no Auditório do Centro Universitário Estácio Juiz de Fora- Avenida Presidente Goulart nº 600 – Bairro Cruzeiro do Sul (ao lado do Carrefour).</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>2 respostas para “Sarcopenia é tema de palestra presencial em Juiz de Fora”</h3>'],
            ['title' => 'Mês de conscientização da saúde mental e emocional', 'category' => 'Campanhas', 'is_featured' => false, 'excerpt' => 'Janeiro é o mês da conscientização sobre a saúde mental. Inspirado no recomeço que o novo ano traz, o Janeiro Branco nos convida a refletir sobre nosso bem-estar emocional,...', 'image' => 'saude-mental.png', 'body' => '<p>Janeiro é o mês da conscientização sobre a saúde mental. Inspirado no recomeço que o novo ano traz, o Janeiro Branco nos convida a refletir sobre nosso bem-estar emocional, nossos relacionamentos e a qualidade de vida.</p>
<p>A saúde mental é tão importante quanto a física! Assim como cuidamos da alimentação para nutrir nosso corpo, também precisamos cultivar hábitos que fortaleçam a mente. Práticas como manter uma alimentação equilibrada, realizar atividades físicas regularmente e reservar momentos para o autocuidado são pilares fundamentais para uma mente saudável.</p>
<p>🌟 Lembre-se: Procure suporte profissional adequado se sentir que precisa!</p>
<p>Vamos transformar este mês no ponto de partida para um ano de mais equilíbrio, saúde e autocuidado? 💚</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'ATENÇÃO, PROFISSIONAIS!', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'O Conselho Regional de Nutrição da 9ª Região (CRN-9) informa que alguns e-mails enviados pelo Conselho podem estar sendo direcionados automaticamente para a caixa de spam, lixo...', 'image' => null, 'body' => '<p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) informa que alguns e-mails enviados pelo Conselho podem estar sendo direcionados automaticamente para a caixa de spam, lixo eletrônico ou promoções.</p>
<p>Para evitar atrasos na tramitação de processos, como inscrições, registros, atualizações cadastrais e demais solicitações, orientamos que os profissionais:</p>
<ul><li>Verifiquem regularmente as pastas Spam, Lixo Eletrônico e Promoções;</li><li>Marquem os e-mails do CRN-9 como “Não é spam” ou adicionem os endereços eletrônicos do Conselho à lista de remetentes confiáveis;</li><li>Acompanhem periodicamente a caixa de entrada durante a análise de seus requerimentos.</li></ul>
<p>Essa medida contribui para que eventuais solicitações de complementação de documentos ou comunicações do CRN-9 sejam visualizadas em tempo hábil, evitando atrasos na conclusão dos processos.</p>
<p>Contamos com a colaboração de todos.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN-9 abre Processo Seletivo Simplificado para Auxiliar Administrativo em Belo Horizonte', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'O Conselho Regional de Nutricionistas da 9ª Região (CRN-9) torna pública a abertura do Processo Seletivo Simplificado, regido pelo Edital nº 01/2026. A seleção é destinada ao...', 'image' => null, 'body' => '<p>O Conselho Regional de Nutricionistas da 9ª Região (CRN-9) torna pública a abertura do Processo Seletivo Simplificado, regido pelo Edital nº 01/2026. A seleção é destinada ao preenchimento imediato de vagas temporárias sob o regime da CLT, com atuação na Sede, em Belo Horizonte/MG.</p>
<p>As inscrições são totalmente gratuitas e deverão ser realizadas no período de 20 a 28 de julho de 2026, exclusivamente pelo site do CRN-9.</p>
<p>O cargo oferece salário inicial de R$ 2.563,75, acrescido de benefícios. A carga horária é de 40 horas semanais, podendo ser cumprida em formato presencial ou teletrabalho, conforme a necessidade do órgão.</p>
<p>Para conferir todos os requisitos, cronogramas e atribuições da vaga, acesse o documento oficial: Leia o Edital nº 01/2026 na íntegra</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Estudantes do último período de Nutrição podem se inscrever para a edição de junho do Boas-Vindas Universitário', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'Está na reta final da graduação em Nutrição?', 'image' => null, 'body' => '<p>Está na reta final da graduação em Nutrição?</p>
<p>Chegou o momento de se preparar para os próximos passos da sua trajetória profissional. O Conselho Regional de Nutrição da 9ª Região (CRN-9) convida estudantes do último período de Nutrição para participarem da edição de junho do Boas-Vindas Universitário, um encontro pensado para aproximar as (os) futuras (os) nutricionistas do Conselho e esclarecer dúvidas sobre o início da vida profissional.</p>
<p>📅 29 de junho ⏰ 17h 💻 Transmissão ao vivo pelo Google Meet 📜 Certificado digital de participação</p>
<p>As inscrições são gratuitas e devem ser realizadas antecipadamente pela plataforma Sympla ou clicando aqui!</p>
<p>Não perca a oportunidade de esclarecer dúvidas, conhecer melhor o papel do Conselho e se preparar para essa nova etapa da sua carreira.</p>
<p>Inscreva-se e participe!</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN-9 participa da Cerimônia do Jaleco de estudantes de Nutrição do Centro Universitário UNA', 'category' => 'Eventos', 'is_featured' => false, 'excerpt' => 'O Conselho Regional de Nutrição da 9ª Região (CRN-9) prestigiou a 1ª Cerimônia do Jaleco do curso de Nutrição do Centro Universitário UNA Barreiro. Ao todo, 14 estudantes...', 'image' => null, 'body' => '<p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) prestigiou a 1ª Cerimônia do Jaleco do curso de Nutrição do Centro Universitário UNA Barreiro. Ao todo, 14 estudantes participaram do momento de celebração, um marco na jornada de formação acadêmica das futuras nutricionistas. A diretora-financeira do CRN-9, Maria Gonçalves Soares, representou o Conselho no evento, realizado no último sábado, 27, em Belo Horizonte.</p>
<p>Maria Gonçalves Soares destacou que é uma honra participar deste momento especial na trajetória das acadêmicas. Segundo a diretora do CRN-9, receber o jaleco branco simboliza o início de uma caminhada marcada pelo conhecimento, pela responsabilidade e pelo compromisso com a saúde das pessoas. “Mais do que um símbolo da profissão, o jaleco é também um equipamento de proteção individual, que deverá ser utilizado com consciência, ética e respeito às normas de cada ambiente de atuação”, afirmou.</p>
<p>Em um momento de grande emoção para as participantes, as acadêmicas proferiram o Juramento do Jaleco. A nutricionista Eunice Barros, responsável técnica da Clínica Integrada da instituição de ensino, desejou sucesso às estudantes e destacou a importância da ocasião. “Que esta seja a primeira cerimônia de muitas histórias que ainda serão escritas por vocês. Tenho certeza disso”, afirmou.</p>
<p>Trajetória na Nutrição</p>
<p>A diretora do CRN-9 também ressaltou que a Nutrição oferece inúmeras possibilidades de atuação e que, em todas elas, há um propósito em comum: promover a saúde, garantir o Direito Humano à Alimentação Adequada e contribuir para uma sociedade mais saudável. “Que este momento represente o compromisso de buscar uma formação sólida, pautada na ética, na responsabilidade e no cuidado com cada pessoa que cruzar o caminho profissional de vocês”, concluiu.</p>
<p>O CRN-9 deseja muito sucesso a todas as acadêmicas e que esta seja apenas a primeira de muitas conquistas em uma trajetória marcada pela dedicação, humanidade e excelência na profissão que escolheram. Parabéns!</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN-9 participa da Jornada de Nutrição da UFU e reforça compromisso com a formação ética dos estudantes', 'category' => 'Eventos', 'is_featured' => false, 'excerpt' => 'O Conselho Regional de Nutrição da 9ª Região (CRN-9) esteve presente, na noite da última terça-feira, 23, na Jornada de Nutrição da Universidade Federal de Uberlândia (UFU). A...', 'image' => null, 'body' => '<p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) esteve presente, na noite da última terça-feira, 23, na Jornada de Nutrição da Universidade Federal de Uberlândia (UFU). A ação reforça o compromisso do Conselho com a formação ética e responsável dos futuros nutricionistas.</p>
<p>Na ocasião, a presidente do CRN-9, Deyrilucy Ferreira, ministrou a palestra “Postura Ética do Estudante de Nutrição”, promovendo reflexões sobre responsabilidade profissional, conduta ética, uso consciente das mídias sociais e os desafios da construção da carreira desde a graduação.</p>
<p>A presidente destaca que ações como essa são fundamentais para aproximar o Conselho dos estudantes, contribuir para a formação de profissionais mais preparados e fortalecer a valorização da Nutrição junto à sociedade. “Investir na educação ética hoje é construir uma profissão ainda mais forte, respeitada e comprometida com a saúde da população”, pontuou Deyrilucy Ferreira. Ao final do evento, a presidente do CRN-9 agradeceu o convite e a oportunidade de dialogar com os estudantes, reafirmando o compromisso do Conselho com a educação, a ética e a valorização da Nutrição em Minas Gerais.</p>
<p>CRN-9 nas universidades</p>
<p>O CRN-9 tem se colocado à disposição das instituições de ensino para participar de iniciativas que promovam a aproximação entre o Conselho e os futuros profissionais. A iniciativa busca contribuir para o enriquecimento do conhecimento, o fortalecimento da identidade profissional e a formação de nutricionistas cada vez mais conscientes de seu papel na sociedade.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN-9 suspende temporariamente atendimentos presenciais nas Delegacias de Ipatinga e Juiz de Fora devido a reformas', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'O Conselho Regional de Nutrição da 9ª Região (CRN-9) informa que os atendimentos presenciais nas Delegacias de Ipatinga e Juiz de Fora estão temporariamente suspensos a partir...', 'image' => null, 'body' => '<p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) informa que os atendimentos presenciais nas Delegacias de Ipatinga e Juiz de Fora estão temporariamente suspensos a partir desta quarta-feira, 24 de junho de 2026. A medida ocorre em razão do início das obras de reforma nas duas unidades.</p>
<p>Durante o período de execução dos serviços, as atividades administrativas e técnicas continuarão sendo realizadas normalmente. Os colaboradores das delegacias atuarão em regime de teletrabalho, garantindo a continuidade dos serviços prestados pelo Conselho aos nutricionistas, técnicos em Nutrição e Dietética, instituições e à sociedade.</p>
<p>Os atendimentos por telefone e e-mail permanecerão disponíveis, sem alterações, permitindo que os profissionais e demais públicos mantenham contato com o CRN-9 para esclarecimento de dúvidas, solicitações e demais demandas.</p>
<p>O CRN-9 agradece a compreensão de todos durante o período das obras e reforça que permanece à disposição por meio de seus canais oficiais de comunicação.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN-9 Divulga: ASBRAN abre inscrições para nova edição do Título de Especialista em Nutrição', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'A Associação Brasileira de Nutrição (ASBRAN) está com inscrições abertas para mais uma edição do Título de Especialista em Nutrição (TEN), uma importante certificação que...', 'image' => null, 'body' => '<p>A Associação Brasileira de Nutrição (ASBRAN) está com inscrições abertas para mais uma edição do Título de Especialista em Nutrição (TEN), uma importante certificação que reconhece a qualificação e a expertise dos nutricionistas em áreas específicas de atuação. Os interessados têm até o dia 3 de agosto de 2026 para realizar a inscrição. Nesta edição, o processo contempla as áreas de Nutrição Clínica em Gastroenterologia, Nutrição Clínica em Gerontologia, Nutrição Clínica em Nefrologia, Nutrição Clínica em Terapia Intensiva, Nutrição e Fitoterapia e Nutrição em Produção de Refeições Comerciais. O Título de Especialista em Nutrição representa um diferencial na carreira profissional, valorizando o currículo e reconhecendo formalmente a experiência e os conhecimentos técnicos dos nutricionistas.</p>
<p>O processo de concessão do título é composto por três etapas eliminatórias: inscrição (com envio online da documentação e pagamento da taxa), prova teórica e avaliação de títulos. Para aprovação, os candidatos devem alcançar a pontuação mínima exigida na prova teórica. Podem participar nutricionistas que possuam, no mínimo, dois anos de inscrição ativa em um Conselho Regional de Nutrição (CRN). A prova teórica será realizada em 23 de outubro de 2026 e ocorrerá nas cidades de Belém (PA), Brasília (DF), Campinas (SP), Campo Grande (MS), Curitiba (PR), Florianópolis (SC), João Pessoa (PB), Maceió (AL), Palmas (TO), Porto Alegre (RS), Recife (PE), Rio de Janeiro (RJ), Salvador (BA), São Luís (MA), São Paulo (SP) e Vitória (ES). O local de realização será informado aos candidatos com antecedência mínima de cinco dias úteis por meio do e-mail cadastrado na inscrição.</p>
<p>A ASBRAN reforça que a prova teórica é obrigatória e eliminatória para todos os candidatos que tiverem a inscrição deferida. O edital completo está disponível no site da ASBRAN. As inscrições podem ser realizadas pelo sistema online do Título de Especialista em Nutrição – www.asbran.org.br Mais informações e inscrições: https://asbrantitulo.com.br</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN-9 informa participação da categoria em consultas públicas que discutem o futuro da Nutrição', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'O Conselho Regional de Nutrição da 9ª Região (CRN-9) e demais Regionais, participaram, nesta segunda-feira, 15, da reunião promovida pelo Conselho Federal de Nutrição (CFN)...', 'image' => null, 'body' => '<p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) e demais Regionais, participaram, nesta segunda-feira, 15, da reunião promovida pelo Conselho Federal de Nutrição (CFN) para apresentação dos resultados preliminares das consultas públicas referentes a normativas que regulamentam a profissão e das contribuições encaminhadas pelos Conselhos Regionais de Nutrição referentes ao Código de Ética e Conduta da (o) Nutricionista (CECN).</p>
<p>O CRN-9 busca tratar com transparência, para os profissionais e para a sociedade, as atualizações sobre os temas relacionados ao exercício profissional. Para Deyrilucy Ferreira, Presidente do CRN9, a ação do CFN, de convidar os Regionais para essa reunião, logo após a finalização das consultas públicas, foi muito importante. “Eles trouxeram quais foram as contribuições e quais serão os próximos passos”, destacou.</p>
<p>Contribuições enviadas pelos regionais</p>
<p>Durante a reunião, o CFN apresentou o consolidado das contribuições encaminhadas pelos Conselhos Regionais, com destaque para os artigos 69 e 74 do Código de Ética e Conduta da(o) Nutricionista. O CRN-9 registrou 114 contribuições.</p>
<p>O CFN garantiu que todas as informações recebidas serão utilizadas para subsidiar as discussões técnicas e institucionais que poderão resultar na atualização do Código de Ética e Conduta da (o) Nutricionista.</p>
<p>Código de Ética, próximos passos</p>
<p>Encerrada em 13 de junho, a consulta pública referente ao CECN recebeu 3.969 contribuições, sendo 3.355 enviadas por nutricionistas e 614 pela sociedade civil.</p>
<p>O processo seguirá agora para a etapa de validação das informações, incluindo a conferência dos registros profissionais e dos dados dos participantes, além da exclusão de contribuições duplicadas. Na sequência, serão realizadas a análise técnica das sugestões recebidas, a revisão do texto normativo e a elaboração de materiais orientativos. Posteriormente, a proposta será submetida à aprovação, publicação e divulgação.</p>
<p>O CFN informou ainda que a publicação da atualização normativa não será cancelada, mas terá seu prazo de efetivação ampliado. Um cronograma detalhado para as próximas etapas deverá ser apresentado durante a plenária da autarquia federal prevista para o dia 21 de junho.</p>
<p>Revisão das áreas de atuação profissional</p>'],
            ['title' => 'NOTA DE POSICIONAMENTO –  Morte de uma criança indígena da etnia Warao', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'O Conselho Regional de Nutrição da 9ª Região (CRN-9) manifesta profunda indignação e pesar diante da morte de uma criança indígena da etnia Warao, em Minas Gerais, em contexto...', 'image' => null, 'body' => '<p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) manifesta profunda indignação e pesar diante da morte de uma criança indígena da etnia Warao, em Minas Gerais, em contexto associado à desnutrição e à desidratação.</p>
<p>Mais do que uma tragédia individual, este episódio expõe uma realidade que persiste em nosso país: a fome, a insegurança alimentar e nutricional e as profundas desigualdades que atingem, de forma desproporcional, povos indígenas, populações migrantes, refugiadas e outros grupos historicamente vulnerabilizados.</p>
<p>A alimentação adequada é um direito humano fundamental e sua garantia constitui dever do Estado e responsabilidade coletiva da sociedade. Quando uma criança perde a vida em decorrência de condições relacionadas à desnutrição, evidencia-se uma falha grave na proteção social, no acesso aos serviços essenciais e na efetivação de direitos básicos.</p>
<p>O CRN-9 reafirma que o enfrentamento da fome e da desnutrição exige ações estruturantes e permanentes, articulando saúde, assistência social, educação, segurança alimentar e nutricional, habitação e proteção dos direitos humanos. É indispensável que populações indígenas, migrantes e refugiadas tenham acesso oportuno e culturalmente adequado às políticas públicas, respeitando suas especificidades e modos de vida.</p>
<p>Também reiteramos o papel estratégico das nutricionistas e dos nutricionistas na vigilância alimentar e nutricional, na atenção à saúde, na promoção da alimentação adequada e saudável e na construção de respostas efetivas para a prevenção da desnutrição e de todas as formas de má nutrição.</p>
<p>O CRN-9 se solidariza com a família, com a comunidade Warao e com todos os povos indígenas que enfrentam cotidianamente barreiras ao acesso a direitos fundamentais.</p>
<p>Nenhuma criança deveria morrer de fome ou desnutrição em um país capaz de produzir alimentos para sua população. Que este caso mobilize autoridades e sociedade para que situações como essa jamais se repitam.</p>
<p>CRN-9 – Conselho Regional de Nutrição da 9ª Região</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Durante evento, CRN-9 promove reflexão sobre os riscos da alimentação em frente às telas', 'category' => 'Eventos', 'is_featured' => false, 'excerpt' => 'No último sábado, 30, aconteceu na Praça da Liberdade, em Belo Horizonte, o evento Juventude Segura na Praça, uma ação do Conselho Regional de Medicina do Estado de Minas...', 'image' => null, 'body' => '<p>No último sábado, 30, aconteceu na Praça da Liberdade, em Belo Horizonte, o evento Juventude Segura na Praça, uma ação do Conselho Regional de Medicina do Estado de Minas Gerais (CRM-MG), que tem o apoio do Conselho Regional de Nutrição da 9ª Região (CRN-9). Na oportunidade, a nutricionista Maria Gonçalves Soares, Diretora-tesoureira do CRN-9, falou sobre os riscos da alimentação em frente às telas (celulares, computadores e TVs).</p>
<p>Maria Soares falou que, em 2025, diversas pesquisas mostraram uma associação entre o tempo de exposição em frente às telas com a obesidade em crianças e adolescentes. “Por que isso acontece? Porque a gente perde a percepção de fome e saciedade e vai consumindo alimento”, disse. Ela ainda completa que a escolha dos alimentos também fica prejudicada. “E o pior, a gente não escolhe adequadamente, a gente consome principalmente os açucarados, os fast-foods e os ultraprocessados”, explicou.</p>
<p>Para a Diretora do CRN-9, o caminho passa pela conscientização e educação de crianças, adolescentes e, principalmente, dos adultos e responsáveis. “Saber a hora certa de fazer cada coisa é essencial. Lógico que, hoje, nós não vamos conseguir parar totalmente, então é educar mesmo”, concluiu.</p>
<p>Juventude Segura na Praça Além desse importante debate sobre o uso saudável das tecnologias digitais, o evento proporcionou para os participantes uma manhã de atividades ao ar livre. A programação contou com brinquedos infláveis, atividades lúdicas, distribuição de gibis e panfletos informativos, além de momentos de interação e lazer para toda a família.</p>
<p>A Dra. Nutri também esteve presente no evento e fez a alegria da criançada. A personagem do CRN-9 interagiu com o público, ajudou na divulgação de materiais educativos, participou das brincadeiras e tirou fotos.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Projeto Portas Abertas reúne 165 acadêmicos de Nutrição de nove instituições de ensino de Minas Gerais', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'O Conselho Regional de Nutrição da 9ª Região (CRN-9) realizou, na noite desta quinta-feira (28), a última edição do primeiro semestre do Projeto Portas Abertas. O evento...', 'image' => null, 'body' => '<p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) realizou, na noite desta quinta-feira (28), a última edição do primeiro semestre do Projeto Portas Abertas. O evento reuniu, de forma virtual, 165 acadêmicos de Nutrição de nove instituições de ensino superior de Minas Gerais.</p>
<p>Promovida pela Comissão de Formação Profissional, com apoio das Unidades Técnica e de Fiscalização, a iniciativa tem como objetivo fortalecer a aproximação entre o CRN-9, as Instituições de Ensino Superior (IES) e os estudantes de Nutrição do estado. A proposta é ampliar o diálogo institucional e contribuir para a qualificação da formação dos futuros nutricionistas.</p>
<p>Durante o encontro, os participantes conheceram mais sobre o papel do Sistema CFN/CRN, as atribuições do nutricionista e a importância de uma atuação ética, responsável e comprometida com a sociedade. Realizado em formato on-line, o Projeto Portas Abertas possibilita a participação de instituições de diferentes regiões de Minas Gerais.</p>
<p>Ao final da atividade, os estudantes avaliaram positivamente a apresentação, destacando a clareza das informações e a oportunidade de esclarecer dúvidas sobre a profissão e o exercício profissional. “A palestra foi bem interessante. É um assunto super importante para todos os estudantes”, ressaltou a acadêmica Mayra Rodrigues.</p>
<p>Inscrições para o segundo semestre</p>
<p>As inscrições para as próximas edições do Projeto Portas Abertas devem ser realizadas exclusivamente por coordenadores(as) e docentes dos cursos de Nutrição. A agenda do segundo semestre será divulgada no mês agosto e as vagas são limitadas.</p>
<p>Mais informações podem ser obtidas junto à Unidade Técnica pelo e-mail: ut@crn9.org.br . O CRN-9 reforça o convite às instituições de ensino para participarem da iniciativa e fortalecerem a integração entre a formação acadêmica e o exercício profissional.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Belo Horizonte: pontos de arrecadação de doações para o RS', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'O Rio Grande do Sul enfrenta um dos piores desastres ambientais da sua história. Chuvas intensas, inundações, mortes, pessoas desaparecidas, famílias desabrigadas, pessoas e...', 'image' => null, 'body' => '<p>O Rio Grande do Sul enfrenta um dos piores desastres ambientais da sua história. Chuvas intensas, inundações, mortes, pessoas desaparecidas, famílias desabrigadas, pessoas e animais em condições precárias. O estado está em situação de calamidade.</p>
<p>Neste momento, o país inteiro está se unindo para arrecadar donativos como água potável, alimentos não perecíveis, roupas, produtos de higiene pessoal, dentre outros materiais .</p>
<p>O CRN9 lamenta profundamente pela catástrofe ambiental e se solidariza com as milhares de famílias desabrigadas, pelas vidas perdidas e também pelas famílias dos colegas do Conselho Regional de Nutricionistas da 2ª Região – Rio Grande do Sul, que foram atingidas pela enchente.</p>
<p>Em Belo Horizonte, vários pontos estão recebendo os donativos que serão enviados ao estado do Rio Grande do Sul. Se você que é de BH e região e deseja fazer doações, confira os pontos de coleta:</p>
<p>A maioria dos donativos vão ser destinados a entidades como Correios, Cruz Vermelha de Minas Gerais e Serviço Social Autônomo (Servas), que estão responsáveis pelo envio dos insumos.</p>
<p>– Aeroporto da Pampulha</p>
<p>Praça Bagatelle, 204 – São Luiz, Belo Horizonte</p>
<p>– Aeroporto de Confins</p>
<p>LMG-800, 76 – Rodoviário, Confins</p>
<p>Avenida Cristóvão Colombo, 683, no bairro Funcionários</p>'],
            ['title' => 'Alterações nas regras para inscrição de Nutricionistas e TNDs no CRN-9 durante a pandemia de Covid-19', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'Os documentos exigidos para inscrição serão aceitos somente se recebidos eletronicamente (digitalizados em PDF ou imagem/foto) pelo e-mail crn9@crn9.org.br ou via sistema...', 'image' => null, 'body' => '<p>Os documentos exigidos para inscrição serão aceitos somente se recebidos eletronicamente (digitalizados em PDF ou imagem/foto) pelo e-mail crn9@crn9.org.br ou via sistema virtual constante aqui no nosso site no menu “Atendimento on-line” . Junto com o requerimento e os documentos exigidos, o profissional deverá enviar a “Declaração de Veracidade” das informações prestadas (modelo do Conselho disponível neste site), sob pena de responder criminalmente por falsidades.</p>
<p>A inscrição será ativada em até 10 dias úteis após a quitação do boleto e o profissional será comunicado por e-mail. Neste momento, no lugar da Carteira de Identidade Profissional física (cartão plástico), quem se inscrever no CRN-9 receberá como comprovante de sua inscrição uma “Declaração Digital de Inscrição” com validade até 6 meses, a partir da data de emissão. Importante ressaltar que esta declaração tem o mesmo valor documental da carteira física.</p>
<p>Devido à pandemia, houve um acúmulo de demandas no setor de atendimento, mas estamos trabalhando para providenciar a entrega o mais breve possível. Não há previsão para a entrega das carteiras físicas.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Inscrições abertas: IV Simpósio Internacional Einstein de Pacientes Graves', 'category' => 'Eventos', 'is_featured' => false, 'excerpt' => 'Estão abertas as inscrições para o IV Simpósio Internacional Einstein de Pacientes Graves | XXXI Simpósio Internacional de Ventilação Mecânica do Hospital Israelita Albert...', 'image' => null, 'body' => '<p>Estão abertas as inscrições para o IV Simpósio Internacional Einstein de Pacientes Graves | XXXI Simpósio Internacional de Ventilação Mecânica do Hospital Israelita Albert Einstein , que será realizado entre os dias 14, 15 e 16 de agosto de 2024.</p>
<p>Teremos grandes nomes da medicina intensiva, palestrantes e pesquisadores nacionais e internacionais que estarão reunidos, abordando diversos temas relacionados aos cuidados de pacientes graves.</p>
<p>POR QUE PARTICIPAR? Com a presença de palestrantes nacionais e internacionais de renome e neste encontro trará atualizações diversos temas relacionados aos cuidados de pacientes graves.</p>
<p>– EXPERTS NACIONAIS E INTERNACIONAIS Interaja com os maiores experts da Medicina Intensiva.</p>
<p>– REVEJA O CONTEÚDO Reveja o conteúdo gratuitamente por um mês após o evento.</p>
<p>– PROGRAMAÇÃO SIMULTÂNEA Organize sua agenda com os temas de seu interesse.</p>
<p>– TRADUÇÃO SIMULTÂNEA O evento contará com tradução simultânea para o idioma inglês.</p>
<p>Não perca a oportunidade de estar conosco e participar!</p>
<p>CLIQUE AQUI para saber mais e se inscrever.</p>
<p>Gostou? Compartilhe nas suas redes!</p>'],
            ['title' => 'CRN-9 e CMS-Pouso Alegre divulgam o resultado do chamamento público para a seleção de representante efetiva(o) e suplente', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'O Conselho Regional de Nutricionistas da 9ª Região (CRN-9) divulgou nesta segunda-feira, 12 de setembro , a lista de aprovações do processo seletivo para escolha de...', 'image' => null, 'body' => '<p>O Conselho Regional de Nutricionistas da 9ª Região (CRN-9) divulgou nesta segunda-feira, 12 de setembro , a lista de aprovações do processo seletivo para escolha de representantes do CRN-9 no Conselho Municipal de Saúde de Pouso Alegre.</p>
<p>Confira a lista de aprovadas(os):</p>
<p>Representante Efetiva – Thaila Romanelli Mokarzel de Mello – CRN-9 11107</p>
<p>Representante Suplente – Érika Cristina Mariano Lima – CRN-9 4992</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Projeto “CRN-9 – Portas Abertas” é voltado para as IES de Nutrição – Inscreva-se!', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'A Coordenação da Fiscalização e Unidade Técnica juntamente com a Comissão de Formação Profissional do CRN-9, com o objetivo de aproximar das Instituições de Ensino Superior...', 'image' => null, 'body' => '<p>A Coordenação da Fiscalização e Unidade Técnica juntamente com a Comissão de Formação Profissional do CRN-9, com o objetivo de aproximar das Instituições de Ensino Superior (IES) e apresentar a constituição e o funcionamento do Conselho, implementa o projeto “CRN9 – Portas Abertas”.</p>
<p>É papel dos Conselhos Regionais de Nutricionistas colaborar com as IES para a melhoria da qualificação profissional.</p>
<p>Antes da pandemia de Covid-19, as visitas eram realizadas na sede e delegacias do CRN-9. Atualmente, é feito um encontro virtual, com palestra sobre o funcionamento do Conselho, fiscalização e ética profissional. A duração aproximada é de 1h30.</p>
<p>Os coordenadores de cursos de Nutrição devem solicitar a participação no Projeto por meio do formulário constante AQUI.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Convocação para audiência pública na ALMG', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'No próximo dia 29 de agosto, às 8h30, a Comissão de Defesa dos Direitos da Mulher da Assembleia Legislativa de Minas Gerais (ALMG) irá realizar, em razão do Dia da(o)...', 'image' => null, 'body' => '<p>No próximo dia 29 de agosto, às 8h30, a Comissão de Defesa dos Direitos da Mulher da Assembleia Legislativa de Minas Gerais (ALMG) irá realizar, em razão do Dia da(o) Nutricionista, celebrado em 31 de agosto, audiência pública para debater a importância do papel da(o) nutricionista para a promoção da saúde e da educação alimentar e nutricional da população, bem como para o combate à insegurança alimentar no Estado.</p>
<p>A ocasião representa oportunidade única para levar ao Parlamento Mineiro as reivindicações das(os) nutricionistas expressos pela luta por melhores condições de trabalho, valorização salarial e regulamentação de normas e leis que afetam a atuação funcional da categoria.</p>
<p>Destacamos a necessidade, em âmbito estadual, de Regulamentação da Lei nº 15.072, de 05 de abril de 2004, que dispõe sobre a promoção da educação alimentar e nutricional nas escolas públicas e privadas do sistema estadual de ensino, do aumento do número de nutricionistas nos quadros da Secretaria Estadual de Educação para atender o PNAE e Res CFN 465/2010 e do aumento do número de nutricionistas nos quadros da Secretaria de Saúde para atender a Res CFN 600/2018.</p>
<p>Além das questões legislativas, a audiência pública terá como função despertar a população para a grave crise de fome que atinge o Brasil e Minas Gerais. No Estado, de acordo com dados da Secretaria de Estado de Desenvolvimento Social (Sedese), 3,4 milhões de mineiros estão em situação de extrema pobreza. Na esfera nacional, o 2º Inquérito Nacional sobre Insegurança Alimentar no Contexto da Pandemia da Covid-19 no Brasil, feito pela Rede Penssan (Rede Brasileira de Pesquisa em Soberania e Segurança Alimentar e Nutricional), apontou que 33 milhões de pessoas passam fome.</p>
<p>Com o propósito de unificar a luta das(os) profissionais de Nutrição, Técnicas(os) em Nutrição e Dietética e estudantes, o Conselho Regional de Nutricionistas da 9ª Região (CRN-9) convoca todas(os) para acompanhar a audiência pública, presencialmente, na Casa do Povo.</p>
<p>Motivo: Audiência Pública</p>
<p>Local: Assembleia Legislativa de Minas Gerais – Rua Rodrigues Caldas, 30</p>
<p>Santo Agostinho – BH</p>
<p>Data: 29 de agosto, às 8h30</p>
<p>Quem não puder comparecer, poderá acompanhar a reunião nos canais oficiais da ALMG: www.almg.gov.br</p>'],
            ['title' => 'Dossiê 2022 da Revista de Segurança Alimentar (SAN) abre chamada para publicação de artigos; veja como participar', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => '“FOME: Os diferentes cenários no Brasil” é o tema do Dossiê 2022 da Revista Segurança Alimentar e Nutricional ( SAN ) que abriu chamada para apresentação de artigos.', 'image' => null, 'body' => '<p>“FOME: Os diferentes cenários no Brasil” é o tema do Dossiê 2022 da Revista Segurança Alimentar e Nutricional ( SAN ) que abriu chamada para apresentação de artigos.</p>
<p>De caráter multidisciplinar, a revista se dedica à publicação de artigos da comunidade científica nacional e internacional que investiguem questões de interesse do campo da Segurança Alimentar e Nutricional e áreas afins.</p>
<p>Para participar são convidados pesquisadoras e pesquisadores dos diferentes campos do conhecimento e com distintas abordagens de pesquisa para submeter seus artigos.</p>
<p>São aceitas contribuições científicas originais , revisões , discussões e debates sobre a temática da segurança alimentar e nutricional (incluindo aspectos socioeconômicos, tecnológicos e de gestão relevantes para área de forma geral).</p>
<p>Como linguagem de redação, podem ser enviados artigos redigidos em português, inglês ou espanhol.</p>
<p>Esta chamada direcionada à comunidade científica tem como foco apresentar artigos originais que tragam análises e reflexões sobre as questões relativas à fome no Brasil , englobando seus diferentes cenários.</p>
<p>A publicação científica eletrônica foi criada em 2005 pelo Núcleo de Estudos e Pesquisas em Alimentação (do NEPA) da Universidade Estadual de Campinas (UNICAMP), que adota sistema de publicação contínua e atende a uma política editorial definida.</p>
<p>A partir de 2019, a Revista SAN e a Rede Brasileira de Pesquisa em Soberania e Segurança Alimentar e Nutricional (Rede Penssan) estabeleceram parceria voltada para o fortalecimento da publicação.</p>
<p>A submissão de manuscritos vai até 14 de agosto de 2022 . A avaliação dos artigos ocorrerá até 1º de novembro. A previsão é de que a revista seja publicada em dezembro deste ano.</p>
<p>A elaboração do texto dos artigos originais e submissão devem seguir os trâmites e orientações descritas no site da Revista SAN .</p>'],
            ['title' => 'Orientações para Preparação dos Documentos', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'É possível assinar digitalmente pelo portal gov.br: CLIQUE AQUI Toda pessoa com conta prata ou ouro pode fazer assinatura digital gratuitamente;', 'image' => null, 'body' => '<h3>ASSINATURA DIGITAL – FICHA DE INSCRIÇÃO</h3>
<p>É possível assinar digitalmente pelo portal gov.br: CLIQUE AQUI Toda pessoa com conta prata ou ouro pode fazer assinatura digital gratuitamente;</p>
<p>Em caso de dúvidas para assinar pela opção acima, veja as orientações a seguir.</p>
<ul><li>Alterar ou verificar o nível da conta (é necessário ser prata ou ouro): CLIQUE AQUI</li><li>Tutorial para assinar o documento: CLIQUE AQUI</li></ul>
<h3>IMPRESSÃO DIGITAL DO POLEGAR DIREITO</h3>'],
            ['title' => 'Em mais um encontro do projeto, profissionais esclarecem dúvidas junto à diretoria do CRN-9', 'category' => 'Eventos', 'is_featured' => false, 'excerpt' => 'Anuidade 2022, criação do Sindicato dos Nutricionistas, cursos para Técnicos em Nutrição e Dietética (TNDs), apoio a esta categoria e diferenças nas atribuições de TNDs e...', 'image' => null, 'body' => '<p>Anuidade 2022, criação do Sindicato dos Nutricionistas, cursos para Técnicos em Nutrição e Dietética (TNDs), apoio a esta categoria e diferenças nas atribuições de TNDs e Nutricionistas. Estes foram os assuntos abordados por cerca de 13 profissionais com o presidente do CRN-9, Luiz Carlos Gomes Júnior, a vice-presidente, Érika Carvalho, a diretora-tesoureira, Regina Oliveira, e o superintendente, Jackson Ferreira.</p>
<p>O bate-papo, realizado na última sexta-feira, dia 28, fez parte do projeto “Um dedo de prosa: momentos de franco diálogo com o Conselho”, estabelecido pela gestão Nutre este ano com o intuito de unir a categoria na busca de soluções para as críticas relativas ao trabalho do CRN-9 e, sobretudo, colocando-se em vista uma Nutrição ética e respeitada.</p>
<p>A periodicidade do projeto é quinzenal (toda segunda e quarta semana do mês).</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN9 realiza primeiro Conectanutri de 2025 com foco em Empreendedorismo na Nutrição', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'No último sábado, o Conselho Regional de Nutrição da 9ª Região (CRN9) promoveu o primeiro evento do Conectanutri 2025 , trazendo o tema “Empreendedorismo na Nutrição” . A...', 'image' => null, 'body' => '<p>No último sábado, o Conselho Regional de Nutrição da 9ª Região (CRN9) promoveu o primeiro evento do Conectanutri 2025 , trazendo o tema “Empreendedorismo na Nutrição” . A iniciativa reuniu dezenas de nutricionistas, tanto as que já atuam no mercado quanto aquelas interessadas em ingressar no mundo do empreendedorismo.</p>
<p>O encontro contou com a presença da conselheira Ivania Moutinho , idealizadora do projeto, que compartilhou experiências, dicas práticas e conduziu dinâmicas interativas para estimular o aprendizado e a troca de conhecimento entre as participantes.</p>
<p>Além dos conteúdos enriquecedores, as nutricionistas receberam o Manual Prático de Telenutrição , desenvolvido pelo Grupo de Trabalho de Teleconsulta de Nutrição do CFN. O evento também teve sorteios de materiais institucionais e planners da Emporium da Nutrição , gentilmente doados pela conselheira Ivania.</p>
<p>Outro destaque foi a participação de nutricionistas que já empreendem na área, que compartilharam suas trajetórias e estratégias inovadoras para se destacar no mercado de trabalho, inspirando as presentes.</p>
<p>O CRN9 agradece a participação de todas e destaca a presença especial da nutricionista Paula Cristina , de Urucânia, município a mais de 200 km de Belo Horizonte. Interessada em empreender, Paula saiu do evento motivada a dar novos passos em sua carreira. “Façam como eu: participem! Vocês que moram em Belo Horizonte e têm a oportunidade de estar mais próximos, venham aos eventos do CRN9. Estou saindo daqui com uma nova mentalidade, mais conhecimento e também tive a chance de conhecer toda a estrutura e os serviços oferecidos pelo Conselho” , declarou.</p>
<p>O sucesso do Conectanutri 2025 reforça o compromisso do CRN9 em promover eventos que impulsionam o crescimento profissional e fortalecem a atuação dos nutricionistas no mercado. Fique atento à programação e participe das próximas edições!</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Projeto de lei que regulamenta técnicos em Nutrição é aprovado na CCJ do Senado Federal', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'uma reprodução de: Conselho Federal de Nutricionistas (CFN)', 'image' => null, 'body' => '<p>uma reprodução de: Conselho Federal de Nutricionistas (CFN)</p>
<p>Matéria será finalizada pela Comissão de Assuntos Sociais (CAS).</p>
<p>A Comissão de Constituição, Justiça e Cidadania (CCJ) aprovou nesta quarta-feira (24) o projeto de lei (PL) 4.147/2023, que regula a profissão de técnico em Nutrição e Dietética. O projeto de autoria da deputada federal Erika Kokay (PT-DF) recebeu relatório favorável do senador Efraim Filho (União-PB) – lido pelo ad hoc (escolhido para esta finalidade) senador Marcos Rogério (PL-RO) – e segue para Comissão de Assuntos Sociais (CAS), finalizando sua tramitação no Senado Federal.</p>
<p>“A aprovação desse projeto de lei representa um avanço na valorização e reconhecimento desses profissionais. E também uma conquista significativa para área da saúde e Nutrição no Brasil”, destacou a diretora do CFN, Manuela Dolinsky, que a acompanhou a votação.</p>
<p>Pelo texto, os técnicos devem atuar no treinamento de pessoal em serviços de alimentação, no acompanhamento da produção de alimentos e na supervisão do trabalho do pessoal de cozinha. Eles também podem integrar equipes destinadas à pesquisa na área, bem como equipes de acompanhamento da produção e industrialização de alimentos.</p>
<p>O projeto estabelece que a designação e o exercício da profissão são privativos dos portadores de diploma expedido por escolas de nível médio, oficiais ou reconhecidas, registrado no órgão de ensino competente. Os técnicos também devem estar inscritos no Conselho Regional de Nutricionistas (CRN) do respectivo território onde atua.</p>
<p>A inscrição só pode ser feita mediante comprovação de conclusão de ensino médio ou equivalente, ou de curso profissionalizante de técnico em nutrição e dietética. O exercício profissional dos técnicos deve ter supervisão de um nutricionista.</p>
<p>O projeto também altera a Lei 6.583, de 1978, que trata dos conselhos federal e regionais de nutricionistas. Eles passam a ser designados conselhos federal e regionais de Nutrição. A anuidade dos técnicos no Conselho será a metade do valor da taxa para os nutricionistas.</p>
<p>“Com a regulamentação, os Técnicos em Nutrição terão seus direitos e deveres profissionalmente definidos, o que contribuirá para a melhoria das condições de trabalho e para o aprimoramento da qualidade dos serviços prestados. Essa conquista é um passo importante para o fortalecimento da área da Nutrição no Brasil e para a construção de um país mais saudável e com menos desigualdades.” opinou o relator.</p>
<p>Agora, o próximo passo é acompanhar a tramitação do projeto de lei na última comissão do Senado e em seguida sua sanção presidencial, para que a regulamentação dos técnicos em nutrição seja efetivamente implementada.</p>'],
            ['title' => 'Conheça as duas chapas inscritas no Processo Eleitoral para a gestão 2023/2026', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'No dia 12 de dezembro, o Conselho Regional de Nutricionistas da 9ª Região (CRN-9) divulgou as chapas inscritas para a eleição que definirá o plenário do triênio 2023/2026. Os...', 'image' => null, 'body' => '<p>No dia 12 de dezembro, o Conselho Regional de Nutricionistas da 9ª Região (CRN-9) divulgou as chapas inscritas para a eleição que definirá o plenário do triênio 2023/2026. Os números das chapas seguem a ordem de recebimento das inscrições junto ao CRN-9. Confira os nomes que participam do pleito:</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN9 troca conhecimentos e experiências em encontros com estudantes de nutrição', 'category' => 'Eventos', 'is_featured' => false, 'excerpt' => 'Nesses últimos dias, o Conselho Regional de Nutrição da 9ª Região – Minas Gerais (CRN9) realizou uma série de ações e palestras voltadas para estudantes de nutrição de diversas...', 'image' => null, 'body' => '<p>Nesses últimos dias, o Conselho Regional de Nutrição da 9ª Região – Minas Gerais (CRN9) realizou uma série de ações e palestras voltadas para estudantes de nutrição de diversas instituições de ensino em Minas Gerais. Esses encontros foram fundamentais para promover debates entre os futuros profissionais e fortalecer os laços entre o Conselho e os estudantes.</p>
<p>A programação teve início no dia 31 de agosto, com a participação da delegada Alvanice Lemos, que palestrou no evento em comemoração ao Dia do Nutricionista, promovido pela Universidade Pitágoras Unopar Anhanguera, em Viçosa. Essa ocasião foi uma excelente oportunidade para estreitar relações com os estudantes da instituição.</p>
<p>No dia 2 de setembro, a conselheira Izabela Montezano ministrou uma palestra sobre ética em nutrição e atendimentos online para os alunos da FAMINAS, em Muriaé. O encontro, também em comemoração ao Dia do Nutricionista, teve como objetivo proporcionar um espaço de reflexão e debate sobre questões éticas essenciais para a prática profissional dos futuros nutricionistas.</p>
<p>Já no dia 3 de setembro, a conselheira Angelina Lessa representou o Conselho em uma palestra online para os alunos da Universidade Federal do Triângulo Mineiro (UFTM). Durante o evento, ela abordou o exercício da profissão e outros temas relevantes para a formação dos nutricionistas.</p>
<p>Na quarta-feira, dia 4 de setembro, a delegada Débora Mesquita participou do evento “Dia do Nutricionista: O Impacto da Nutrição em Diversos Aspectos da Saúde”, promovido pela faculdade Anhanguera, em Uberlândia. Durante o evento, palestrantes abordaram temas importantes para a atuação dos nutricionistas, como estresse alimentar, a importância da saúde digestiva, a terapia nutricional em pacientes pediátricos graves e a jornada nutricional do paciente oncológico.</p>
<p>Além disso, durante os dias 4, 5 e 6 deste mês, o Programa de Pós-Graduação em Nutrição e Longevidade (PPGNL) da Universidade Federal de Alfenas (UNIFAL-MG) convidou o Conselho a participar do II Congresso Nacional de Nutrição e Longevidade (II CNNL), a delegada de Pouso Alegre, Karla Ferreira, representou o CRN9 na ocasião. O evento discutiu sobre os diferentes determinantes da longevidade, além de pesquisas relacionadas à nutrição, saúde e envelhecimento, temas essenciais para a promoção da saúde e prevenção de doenças ao longo da vida.</p>
<p>A troca de conhecimentos e experiências contribui de forma significativa para o desenvolvimento ético e técnico dos estudantes, preparando-os para os desafios da prática profissional.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN-9 participa de audiência com deputado Enes Cândido sobre Cuidados Paliativos', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'O CRN-9, representado pela presidenta Erika Simone Coelho Carvalho, participou, juntamente aos conselhos profissionais da área da saúde, de discussões sobre a importância de...', 'image' => null, 'body' => '<p>O CRN-9, representado pela presidenta Erika Simone Coelho Carvalho, participou, juntamente aos conselhos profissionais da área da saúde, de discussões sobre a importância de políticas públicas de cuidados paliativos no estado.</p>
<p>Na ocasião, foi debatida a construção de proposta para alterar a Lei Estadual nº 23.938/21, que estabelece princípios, diretrizes e objetivos para as ações do estado voltadas para os cuidados paliativos.</p>
<p>A proposta tem como objetivo definir a responsabilidade do estado na criação e estruturação dessa modalidade de assistência nos hospitais estaduais. Também participaram do encontro: Isabella Bicalho, presidenta do Conselho Regional de Fonoaudiologia 6ª Região, Evellyn Aparecida Almeida do Conselho Regional de Fisioterapia e Terapia Ocupacional (CREFITO-4), Patrícia Castoria Faria, integrante da Comissão de Cuidados Paliativos do Conselho Regional de Enfermagem de Minas Gerais (COREN-MG), Daniela Charnizon, integrante da Câmara Técnica de Cuidados Paliativos do Conselho Regional de Medicina do Estado de Minas Gerais (CRM-MG) e Cássio Rocha Braga, assessor de relações institucionais e governamentais do Conselho Regional de Odontologia (CRO/MG).</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Uma resposta para “CRN-9 participa de audiência com deputado Enes Cândido sobre Cuidados Paliativos”</h3>
<p>[…] CRN-9 participa de audiência com deputado Enes Cândido sobre Cuidados Paliativos […]</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Dia da Criação do SUS: Saúde para todos!', 'category' => 'Campanhas', 'is_featured' => false, 'excerpt' => 'Hoje (19/9), celebramos os 34 anos do Sistema Único de Saúde (SUS), um dos mais complexos sistemas de saúde pública do mundo.', 'image' => null, 'body' => '<p>Hoje (19/9), celebramos os 34 anos do Sistema Único de Saúde (SUS), um dos mais complexos sistemas de saúde pública do mundo.</p>
<p>A Lei nº 8.080, sancionada em 1990, transformou a história da saúde pública brasileira ao estabelecer um sistema de saúde igualitário e universal para todos os cidadãos. Atualmente, o SUS atende mais de 200 milhões de brasileiros, oferecendo não apenas cuidados médico-hospitalares, mas também serviços de prevenção e promoção da saúde.</p>
<p>O SUS, funciona de maneira colaborativa entre a União, os estados e os municípios e é dividido em três níveis de assistência: primária, secundária e terciária. Assim, promovendo um acompanhamento completo, atendendo casos de diversos níveis de complexidade em todo o território nacional.</p>
<p>Além disso, o SUS é responsável por uma série de serviços essenciais, como o Serviço de Atendimento Móvel de Urgência (SAMU), programas de transplante de órgãos e tecidos, vigilância sanitária e muitos outros setores fundamentais para a sociedade.</p>
<p>Pela saúde igualitária e universal, precisamos acreditar e defender o SUS!</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'Escolhida possível representante do CRN-9 no CAE-BH', 'category' => 'Institucional', 'is_featured' => false, 'excerpt' => 'Como resultado do chamamento público para representatividade do CRN-9 junto ao Conselho de Alimentação Escolar de Belo Horizonte (CAE-BH), foi escolhida a nutricionista Larissa...', 'image' => null, 'body' => '<p>Como resultado do chamamento público para representatividade do CRN-9 junto ao Conselho de Alimentação Escolar de Belo Horizonte (CAE-BH), foi escolhida a nutricionista Larissa Fernanda Fonseca Guedes – CRN9 11111.</p>
<p>A profissional será indicada pelo CRN-9 em eleição que ocorrerá em novembro, para cumprimento do restante do mandato do quadriênio 2019-2023, cujo término é 02 de março de 2023.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
            ['title' => 'CRN-9 conclui programação do Dia Mundial da Alimentação em Belo Horizonte', 'category' => 'Campanhas', 'is_featured' => false, 'excerpt' => 'O Conselho Regional de Nutricionistas da 9ª Região (CRN-9) concluiu, nesta terça-feira, 11 de outubro, a segunda parte da celebração do Dia Mundial da Alimentação em Belo...', 'image' => null, 'body' => '<p>O Conselho Regional de Nutricionistas da 9ª Região (CRN-9) concluiu, nesta terça-feira, 11 de outubro, a segunda parte da celebração do Dia Mundial da Alimentação em Belo Horizonte. Na ocasião, foram entregues 600 mudas de temperos para as(os) usuárias(os) do Restaurante Popular Josué de Castro (Santa Efigênia).</p>
<p>Assim como foi feito no primeiro dia de evento, os frequentadores do restaurante popular foram presenteados com mudas de salsinha, cebolinha, hortelã, manjericão, orégano e pimenta, acompanhadas de cartão com descritivo dos benefícios do consumo das espécies. A ação educativa recebeu o reforço da artista circense Lud Benquerer e do Palhaço Chouriço Feitiço, que entregaram sorrisos e alegria aos que estavam na fila do refeitório.</p>
<p>“Ninguém é deixado para trás”</p>
<p>A partir do tema do Dia Mundial da Alimentação de 2022, o CRN-9 organizou ação popular para sensibilizar os cidadãos da capital sobre o combate à fome, insegurança alimentar e nutricional no Brasil. Atualmente, 33 milhões de brasileiros estão em situação de fome, como demonstrou o 2º Inquérito Nacional sobre Insegurança Alimentar no Contexto da Pandemia da Covid-19 no Brasil, feito pela Rede Penssan (Rede Brasileira de Pesquisa em Soberania e Segurança Alimentar e Nutricional).</p>
<p>Os eventos do Dia Mundial da Alimentação seguem nas delegacias do CRN-9 e vão até o dia 21 de outubro. Confira a programação abaixo: 16/10 – Feira do Bairro Aparecida – Avenida Monsenhor Eduardo – Uberlândia 17/10 – Praça Doutor João Penido (mais conhecida como Praça da Estação) – Juiz de Fora 17/10 – Policlínica Municipal – R. Joaquim Nabuco, 370, Cidade Nobre – Ipatinga 21/10 – Praça da Matriz – Montes Claros</p>
<p>Celebrado no dia 16 de outubro em mais de 150 países, o Dia Mundial da Alimentação foi oficializado em 1981 para rememorar a fundação, em 1945, da Organização das Nações Unidas para Alimentação e Agricultura (FAO). Neste ano, a FAO lançou seu marco estratégico para 2022-2031. As diretrizes foram desenvolvidas no contexto dos principais desafios globais e regionais em áreas dentro do mandato da FAO, incluindo a pandemia de COVID-19, e apresentam quatro eixos temáticos: melhor produção, melhor nutrição, um melhor ambiente e uma vida melhor.</p>
<p>Gostou? Compartilhe nas suas redes!</p>
<h3>Deixe um comentário Cancelar resposta</h3>'],
        ];

        foreach ($items as $index => $item) {
            $coverImage = $item['image'] ? $this->seedImage('news/'.$item['image'], 'news/'.$item['image']) : null;

            News::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'body' => $item['body'],
                    'cover_image' => $coverImage,
                    'category' => $item['category'],
                    'is_featured' => $item['is_featured'],
                    'published_at' => now()->subDays($index * 4 + random_int(1, 3)),
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
            [
                'title' => '2º Congresso Mineiro de Nutrição Plena',
                'location' => 'UniBH – Belo Horizonte, MG',
                'starts_at' => '2026-08-15 08:00:00',
                'is_featured' => true,
                'external_url' => 'https://www.sympla.com.br/evento/2-congresso-mineiro-de-nutricao-plena/3420595',
                'description' => '<p>Evento completo voltado para profissionais e estudantes de saúde, com foco em conhecimento de ponta e networking.</p><p>Ingressos: lote promocional a partir de R$ 297,00.</p>',
            ],
            [
                'title' => 'Nutrição Brasil (Imersão Belo Horizonte)',
                'location' => 'Belo Horizonte, MG',
                'starts_at' => '2026-08-01 08:00:00',
                'is_featured' => false,
                'external_url' => 'https://www.instagram.com/nutricaobrasil.expo/',
                'description' => '<p>Imersão de um dia com foco nas discussões do "Novo Corpo" (metabolismo, mente e músculos) impactado por medicamentos, estética e ciência.</p><p>Data exata dentro de agosto de 2026 a confirmar pelos organizadores.</p>',
            ],
            [
                'title' => 'Simpósio Mineiro de Nutrologia 2026',
                'location' => null,
                'starts_at' => '2026-10-16 08:00:00',
                'ends_at' => '2026-10-17 18:00:00',
                'is_featured' => false,
                'external_url' => 'https://www.instagram.com/p/DXfudfBEWTy/',
                'description' => '<p>Atualização científica em obesidade, nutrição hospitalar, oncologia, comportamento alimentar e medicina de precisão.</p>',
            ],
            [
                'title' => '5º Congresso Nutrita de Nutrição Clínica e Esportiva',
                'location' => 'Associação Médica de Minas Gerais – Belo Horizonte, MG',
                'starts_at' => '2026-10-31 08:00:00',
                'ends_at' => '2026-10-31 18:00:00',
                'is_featured' => true,
                'external_url' => 'https://www.sympla.com.br/evento/5-congresso-nutrita-de-nutricao-clinica-e-esportiva/3251704',
                'description' => '<p>Saúde da mulher (estética à menopausa, fertilidade), atualizações em GLP-1, saúde do sono e wearables aplicados ao esporte.</p><p>Ingressos: segundo lote disponível por R$ 305,78.</p>',
            ],
        ];

        foreach ($items as $item) {
            EventItem::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'description' => $item['description'] ?? '<p>Descrição do evento a ser detalhada pela equipe de comunicação do CRN-9.</p>',
                    'location' => $item['location'],
                    'starts_at' => $item['starts_at'],
                    'ends_at' => $item['ends_at'] ?? null,
                    'external_url' => $item['external_url'] ?? null,
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
                .'<rect width="1200" height="400" fill="#5C5E2B"/>'
                .'<text x="50%" y="50%" font-family="sans-serif" font-size="42" fill="#ffffff" text-anchor="middle" dominant-baseline="middle">'
                .'CRN-9 &#183; Banner de campanha</text></svg>'
            );
        }

        if (! Storage::disk('public')->exists('banners/faq-illustrative.svg')) {
            Storage::disk('public')->put(
                'banners/faq-illustrative.svg',
                <<<'SVG'
                <svg xmlns="http://www.w3.org/2000/svg" width="1200" height="400" viewBox="0 0 1200 400">
                    <defs>
                        <linearGradient id="faqBg" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#5C5E2B"/>
                            <stop offset="100%" stop-color="#727347"/>
                        </linearGradient>
                    </defs>
                    <rect width="1200" height="400" fill="url(#faqBg)"/>
                    <circle cx="900" cy="200" r="190" fill="#ffffff" opacity="0.06"/>
                    <circle cx="900" cy="200" r="120" fill="#F58C4A" opacity="0.9"/>
                    <text x="900" y="205" font-family="sans-serif" font-size="150" font-weight="700" fill="#ffffff" text-anchor="middle" dominant-baseline="middle">?</text>
                    <circle cx="230" cy="90" r="10" fill="#A3A64A"/>
                    <circle cx="270" cy="130" r="6" fill="#85B0FF"/>
                </svg>
                SVG
            );
        }


        if (! Storage::disk('public')->exists('banners/denuncia-illustrative.svg')) {
            Storage::disk('public')->put(
                'banners/denuncia-illustrative.svg',
                <<<'SVG'
                <svg xmlns="http://www.w3.org/2000/svg" width="1200" height="400" viewBox="0 0 1200 400">
                    <defs>
                        <linearGradient id="denunciaBg" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#3A1F16"/>
                            <stop offset="100%" stop-color="#5C5E2B"/>
                        </linearGradient>
                    </defs>
                    <rect width="1200" height="400" fill="url(#denunciaBg)"/>
                    <circle cx="900" cy="200" r="190" fill="#F58C4A" opacity="0.08"/>
                    <path d="M900 95 L1005 285 L795 285 Z" fill="none" stroke="#F58C4A" stroke-width="14" stroke-linejoin="round" stroke-linecap="round"/>
                    <rect x="892" y="165" width="16" height="70" rx="8" fill="#F58C4A"/>
                    <circle cx="900" cy="260" r="10" fill="#F58C4A"/>
                    <circle cx="230" cy="90" r="10" fill="#A3A64A"/>
                    <circle cx="270" cy="130" r="6" fill="#85B0FF"/>
                </svg>
                SVG
            );
        }

        if (! Storage::disk('public')->exists('banners/manifesto-illustrative.svg')) {
            Storage::disk('public')->put(
                'banners/manifesto-illustrative.svg',
                <<<'SVG'
                <svg xmlns="http://www.w3.org/2000/svg" width="1200" height="400" viewBox="0 0 1200 400">
                    <defs>
                        <linearGradient id="manifestoBg" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#2E2F14"/>
                            <stop offset="55%" stop-color="#5C5E2B"/>
                            <stop offset="100%" stop-color="#7C6A33"/>
                        </linearGradient>
                        <radialGradient id="manifestoGlow" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#F58C4A" stop-opacity="0.35"/>
                            <stop offset="100%" stop-color="#F58C4A" stop-opacity="0"/>
                        </radialGradient>
                    </defs>
                    <rect width="1200" height="400" fill="url(#manifestoBg)"/>
                    <circle cx="930" cy="200" r="230" fill="url(#manifestoGlow)"/>
                    <circle cx="930" cy="200" r="175" fill="#ffffff" opacity="0.05"/>

                    <!-- radiating accent lines -->
                    <g stroke="#A3A64A" stroke-width="3" opacity="0.5" stroke-linecap="round">
                        <line x1="930" y1="20" x2="930" y2="55"/>
                        <line x1="1080" y1="70" x2="1055" y2="95"/>
                        <line x1="1130" y1="200" x2="1095" y2="200"/>
                        <line x1="1080" y1="330" x2="1055" y2="305"/>
                        <line x1="780" y1="70" x2="805" y2="95"/>
                    </g>

                    <!-- shield -->
                    <path d="M930 70 L1035 108 L1035 205 Q1035 300 930 350 Q825 300 825 205 L825 108 Z"
                          fill="#ffffff" opacity="0.97"/>
                    <path d="M930 70 L1035 108 L1035 205 Q1035 300 930 350 Q825 300 825 205 L825 108 Z"
                          fill="none" stroke="#F58C4A" stroke-width="6"/>

                    <!-- leaf / sprout inside shield -->
                    <path d="M930 130 C975 140 992 180 985 222 C978 262 948 285 930 292 C930 240 930 185 930 130 Z"
                          fill="#5C5E2B"/>
                    <path d="M930 130 C885 140 868 180 875 222 C882 262 912 285 930 292 C930 240 930 185 930 130 Z"
                          fill="#85B0FF"/>
                    <line x1="930" y1="150" x2="930" y2="288" stroke="#ffffff" stroke-width="3" opacity="0.6"/>

                    <!-- decorative dots (bottom-left, matches other illustrative banners) -->
                    <circle cx="230" cy="90" r="10" fill="#A3A64A"/>
                    <circle cx="270" cy="130" r="6" fill="#85B0FF"/>
                    <circle cx="200" cy="330" r="8" fill="#F58C4A" opacity="0.7"/>
                </svg>
                SVG
            );
        }

        if (! Storage::disk('public')->exists('banners/denuncia-illustrative.svg')) {
            Storage::disk('public')->put(
                'banners/denuncia-illustrative.svg',
                <<<'SVG'
                <svg xmlns="http://www.w3.org/2000/svg" width="1200" height="400" viewBox="0 0 1200 400">
                    <defs>
                        <linearGradient id="denunciaBg" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#3A1F16"/>
                            <stop offset="100%" stop-color="#5C5E2B"/>
                        </linearGradient>
                    </defs>
                    <rect width="1200" height="400" fill="url(#denunciaBg)"/>
                    <circle cx="900" cy="200" r="190" fill="#F58C4A" opacity="0.08"/>
                    <path d="M900 95 L1005 285 L795 285 Z" fill="none" stroke="#F58C4A" stroke-width="14" stroke-linejoin="round" stroke-linecap="round"/>
                    <rect x="892" y="165" width="16" height="70" rx="8" fill="#F58C4A"/>
                    <circle cx="900" cy="260" r="10" fill="#F58C4A"/>
                    <circle cx="230" cy="90" r="10" fill="#A3A64A"/>
                    <circle cx="270" cy="130" r="6" fill="#85B0FF"/>
                </svg>
                SVG
            );
        }

        $items = [
            ['title' => 'Nutrição é profissão. Saúde é direito.', 'subtitle' => 'O CRN9 orienta, disciplina e fiscaliza o exercício profissional em Minas Gerais.', 'placement' => 'home_hero', 'sort_order' => 1, 'link' => '/paginas/o-que-e-fiscalizacao', 'image' => null, 'illustrative' => 'manifesto-illustrative.svg'],
            ['title' => 'Denúncias e fiscalização', 'placement' => 'home_secondary', 'sort_order' => 1, 'link' => '/paginas/denuncia', 'image' => null, 'illustrative' => 'denuncia-illustrative.svg'],
            ['title' => 'Perguntas Frequentes', 'placement' => 'home_secondary', 'sort_order' => 2, 'link' => '/perguntas-frequentes', 'image' => null, 'illustrative' => 'faq-illustrative.svg'],
        ];

        foreach ($items as $item) {
            $image = $item['image']
                ? $this->seedImage('banners/'.$item['image'], 'banners/'.$item['image'])
                : ($item['illustrative'] ?? null ? 'banners/'.$item['illustrative'] : 'banners/placeholder.svg');

            Banner::updateOrCreate(
                ['title' => $item['title']],
                [
                    'title' => $item['title'],
                    'subtitle' => $item['subtitle'] ?? null,
                    'image' => $image,
                    'link_url' => $item['link'],
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
            JobListing::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'company' => $item['company'],
                    'description' => 'Descrição completa da vaga a ser fornecida pelo contratante. Vagas reais devem ser cadastradas pela Secretaria do CRN-9 via painel administrativo, como cortesia às empresas e instituições parceiras.',
                    'location' => $item['location'],
                    'contract_type' => $item['contract_type'],
                    'published_at' => now()->subDays(random_int(1, 10)),
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * Edições reais da Revista CRN-9 identificadas no site oficial.
     * Como os arquivos originais (flipbook/PDF) permanecem hospedados em
     * crn9.org.br, cada edição aponta para a URL original via external_url.
     */
    private function seedMagazines(): void
    {
        $items = [
            ['title' => 'Revista Digital do CRN-9', 'edition' => '2023', 'year' => 2023, 'url' => 'https://crn9.org.br/revista/9936/'],
            ['title' => 'Revista CRN9 10 anos', 'edition' => 'Edição comemorativa', 'year' => 2021, 'url' => 'https://crn9.org.br/revista/revista-crn9-10-anos/'],
            ['title' => 'Revista CRN9', 'edition' => '2019', 'year' => 2019, 'url' => 'https://crn9.org.br/revista/revista-crn9-2019/'],
            ['title' => 'Revista CRN9', 'edition' => '2018', 'year' => 2018, 'url' => 'https://crn9.org.br/revista/revista-crn9-2018/'],
            ['title' => 'Revista CRN9', 'edition' => '2016', 'year' => 2016, 'url' => 'https://crn9.org.br/revista/revista-crn9-2016/'],
        ];

        foreach ($items as $item) {
            Magazine::updateOrCreate(
                ['title' => $item['title'], 'year' => $item['year']],
                [
                    'title' => $item['title'],
                    'edition' => $item['edition'],
                    'year' => $item['year'],
                    'external_url' => $item['url'],
                    'published_at' => now()->setYear($item['year'])->startOfYear(),
                ]
            );
        }
    }

    /**
     * Equipe de Fiscalização real, migrada de
     * https://crn9.org.br/fiscalizacao/equipe-de-fiscalizacao/ (24/07/2026).
     */
    private function seedInspectors(): void
    {
        $items = [
            ['name' => 'Eliane Azevedo Barros', 'role' => 'Coordenadora da Fiscalização', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => 'CRN9 2130', 'email' => 'coordenacaodafiscalizacao@crn9.org.br', 'duty_notes' => null],
            ['name' => 'Jordana dos Santos Jorge Machado', 'role' => 'Supervisora da Fiscalização', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => 'CRN9 2092', 'email' => 'supervisaodafiscalizacao@crn9.org.br', 'duty_notes' => null],
            ['name' => 'Débora Barbosa', 'role' => 'Nutricionista Fiscal', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => 'CRN9 5949', 'email' => 'deborabarbosa.fiscal@crn9.org.br', 'duty_notes' => 'Plantão às segundas-feiras.'],
            ['name' => 'Gabriela Paim de Alcântara e Silva', 'role' => 'Nutricionista Fiscal', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => 'CRN9 8229', 'email' => 'gabrielafiscal@crn9.org.br', 'duty_notes' => 'Plantão às quartas-feiras e quintas-feiras.'],
            ['name' => 'Geana Paula Aparecida dos Santos', 'role' => 'Nutricionista Fiscal', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => null, 'email' => 'geana.fiscal@crn9.org.br', 'duty_notes' => null],
            ['name' => 'Juliana de Oliveira Sales', 'role' => 'Nutricionista Fiscal', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => null, 'email' => 'juliana_fiscal@crn9.org.br', 'duty_notes' => 'Plantão às terças e quartas-feiras.'],
            ['name' => 'Karen Priscilla dos Santos', 'role' => 'Assistente Técnico em Nutrição e Dietética', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => 'CRN9 T-2431', 'email' => 'karen.santos@crn9.org.br', 'duty_notes' => null],
            ['name' => 'Josiane Magalhães', 'role' => 'Assistente Técnico em Nutrição e Dietética', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => null, 'email' => 'josiane.magalhaes@crn9.org.br', 'duty_notes' => null],
            ['name' => 'Arlete Rodrigues', 'role' => 'Assistente Técnico em Nutrição e Dietética', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => null, 'email' => 'arlete.rodrigues@crn9.org.br', 'duty_notes' => null],
            ['name' => 'Israel Soares', 'role' => 'Assistente Administrativo', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => null, 'email' => 'israel.soares@crn9.org.br', 'duty_notes' => null],
            ['name' => 'Marcela Rodrigues Viveiros', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Ipatinga', 'registration_number' => 'CRN9 21809', 'email' => 'marcela.fiscal@crn9.org.br', 'duty_notes' => 'Plantão às sextas-feiras.'],
            ['name' => 'Nicelle Julia Corrêa Lopes', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Juiz de Fora', 'registration_number' => 'CRN9 19118', 'email' => 'nicelle.fiscal@crn9.org.br', 'duty_notes' => 'Plantão às terças-feiras.'],
            ['name' => 'Caroline Caldeira Pereira', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Montes Claros', 'registration_number' => 'CRN9 14249', 'email' => 'carolinefiscal@crn9.org.br', 'duty_notes' => null],
            ['name' => 'Flávia Junqueira de Souza Morais', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Pouso Alegre', 'registration_number' => 'CRN9 2168', 'email' => 'flaviafiscal@crn9.org.br', 'duty_notes' => 'Plantão às quartas-feiras.'],
            ['name' => 'Silvia Aparecida de Cássia Ferreira Romero', 'role' => 'Assistente Técnico em Nutrição e Dietética', 'region' => 'Delegacia de Pouso Alegre', 'registration_number' => 'CRN9 T-1949', 'email' => 'silvia@crn9.org.br', 'duty_notes' => null],
            ['name' => 'Barbara Virginia Caixeta Crepaldi', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Uberlândia', 'registration_number' => null, 'email' => null, 'duty_notes' => null],
            ['name' => 'Nilda Pereira de Melo Zumpano', 'role' => 'Assistente Técnico em Nutrição e Dietética', 'region' => 'Delegacia de Uberlândia', 'registration_number' => 'CRN9 2671-T', 'email' => 'nilda.zumpano@crn9.org.br', 'duty_notes' => null],
            ['name' => 'Pâmela Cristina de Andrade', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Uberlândia', 'registration_number' => null, 'email' => 'pamela.fiscal@crn9.org.br', 'duty_notes' => 'Plantão às segundas e sextas-feiras.'],
            ['name' => 'Andresa Carolina da Silva Costa', 'role' => 'Nutricionista Fiscal', 'region' => 'Barbacena', 'registration_number' => 'CRN9 23119', 'email' => null, 'duty_notes' => null],
        ];

        foreach ($items as $index => $item) {
            Inspector::updateOrCreate(
                ['name' => $item['name']],
                [
                    'name' => $item['name'],
                    'role' => $item['role'],
                    'region' => $item['region'],
                    'registration_number' => $item['registration_number'],
                    'email' => $item['email'],
                    'duty_notes' => $item['duty_notes'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedMunicipalityCounts(): void
    {
        // Fonte: planilha pública do CRN-9 ("Quantitativo Inscritos Ativos por
        // município - PF e PJ"), embutida via Google Sheets na página
        // /profissionais-por-municipios/ do site original. Referência: 01/08/2024.
        $path = __DIR__.'/data/municipios_mg.json';
        $items = json_decode(file_get_contents($path), true);

        foreach ($items as $item) {
            $municipality = ucwords(mb_strtolower($item['municipality']));

            MunicipalityProfessionalCount::updateOrCreate(
                ['municipality' => $municipality, 'state' => 'MG'],
                [
                    'municipality' => $municipality,
                    'state' => 'MG',
                    'nutritionists_count' => $item['nutricionistas'],
                    'technicians_count' => $item['tnd'],
                    'legal_entities_count' => $item['pj'],
                    'total_count' => $item['total'],
                    'reference_date' => '2024-08-01',
                ]
            );
        }
    }

    /**
     * Plenário do CRN-9 (Diretoria, Comissões, Câmaras Técnicas), migrado de
     * https://crn9.org.br/plenario/ (27/07/2026). As Câmaras Técnicas VI a IX
     * estão sem membros designados também no site de origem.
     */
    private function seedCouncil(): void
    {
        $path = __DIR__.'/data/council_plenario.json';
        $groups = json_decode(file_get_contents($path), true);

        foreach ($groups as $group) {
            $councilGroup = CouncilGroup::updateOrCreate(
                ['name' => $group['group']],
                [
                    'name' => $group['group'],
                    'kind' => $group['kind'],
                    'contact_email' => $group['contact_email'],
                    'sort_order' => $group['sort_order'],
                    'is_active' => true,
                ]
            );

            foreach ($group['members'] as $member) {
                CouncilMember::updateOrCreate(
                    ['council_group_id' => $councilGroup->id, 'name' => $member['name']],
                    [
                        'council_group_id' => $councilGroup->id,
                        'name' => $member['name'],
                        'role' => $member['role'],
                        'registration_number' => $member['registration_number'],
                        'bio' => $member['bio'],
                        'sort_order' => $member['sort_order'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    /**
     * Processos licitatórios do CRN-9, migrados de https://crn9.org.br/licitacao/
     * (listagem principal + arquivos por ano de 2019 a 2022), com todos os
     * documentos anexos (Edital, Anexos, Homologação...) preservados como
     * links diretos para os arquivos originais.
     */
    private function seedLicitacoes(): void
    {
        $path = __DIR__.'/data/licitacoes.json';
        $items = json_decode(file_get_contents($path), true);

        foreach ($items as $index => $item) {
            $licitacao = Licitacao::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'modality' => $item['modality'],
                    'number' => $item['number'],
                    'year' => $item['year'],
                    'description' => $item['description'],
                    'status' => $item['status'],
                    'published_at' => $item['published_at'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );

            foreach ($item['documents'] as $docIndex => $document) {
                LicitacaoDocument::updateOrCreate(
                    ['licitacao_id' => $licitacao->id, 'label' => $document['label']],
                    [
                        'licitacao_id' => $licitacao->id,
                        'label' => $document['label'],
                        'external_url' => $document['url'],
                        'sort_order' => $docIndex + 1,
                    ]
                );
            }
        }
    }

    /**
     * Instituições de Ensino (cursos de graduação em Nutrição em Minas
     * Gerais) fornecidas pelo CRN-9 em planilha (IES - Minas Gerais).
     * Este mesmo layout de planilha pode ser reenviado pelo painel
     * administrativo para atualizar a base.
     */
    private function seedEducationInstitutions(): void
    {
        $path = __DIR__.'/data/education_institutions.json';
        $items = json_decode(file_get_contents($path), true);

        foreach ($items as $index => $item) {
            EducationInstitution::updateOrCreate(
                ['name_key' => EducationInstitution::normalizeKey($item['nome'])],
                [
                    'name' => $item['nome'],
                    'address' => $item['endereco'] ?: null,
                    'city' => $item['cidade'] ?: null,
                    'phone' => $item['telefone'] ?: null,
                    'email' => $item['email'] ?: null,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * Biblioteca Virtual do CRN-9: todos os 31 documentos publicados em
     * https://crn9.org.br/biblioteca/, localizados via wp-sitemap-posts-
     * documento-1.xml (a listagem só mostra 12 por vez atrás do botão
     * "Carregar mais"), cada um com o link real do arquivo original.
     */
    private function seedLibraryDocuments(): void
    {
        $path = __DIR__.'/data/library_documents.json';
        $items = json_decode(file_get_contents($path), true);

        foreach ($items as $index => $item) {
            $document = LibraryDocument::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'description' => $item['description'],
                    'published_at' => now()->subDays($index),
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );

            foreach ($item['documents'] as $docIndex => $file) {
                LibraryDocumentFile::updateOrCreate(
                    ['library_document_id' => $document->id, 'label' => $file['label']],
                    [
                        'library_document_id' => $document->id,
                        'label' => $file['label'],
                        'external_url' => $file['url'],
                        'sort_order' => $docIndex + 1,
                    ]
                );
            }
        }
    }

    /**
     * Perguntas Frequentes gerais, migradas de crn9.org.br/perguntas-frequentes/
     * (conteúdo real da própria página do CRN-9, agora editável pelo painel
     * admin em vez de ser uma página estática).
     */
    private function seedFaqs(): void
    {
        $items = [
            // Inscrição e Registro
            ['category' => 'Inscrição e Registro', 'question' => 'Acabei de me formar. Como faço a inscrição provisória?', 'answer' => "A primeira inscrição do profissional poderá ser provisória ou definitiva, dependendo da documentação acadêmica. A Inscrição Provisória tem validade de 2 (dois) anos e é destinada a quem possui certificado ou declaração de conclusão de curso, com a data de colação de grau, de curso reconhecido pelo MEC.\n\nValor: anuidade do ano corrente (R\$ 595,66) proporcional, com desconto de 50% na primeira anuidade para recém-formados. O prazo de ativação é de até 30 (trinta) dias úteis após a análise da documentação."],
            ['category' => 'Inscrição e Registro', 'question' => 'Minha inscrição é provisória. Como torná-la definitiva?', 'answer' => "Envie a Ficha de Inscrição preenchida e assinada, cópia do diploma (frente e verso) devidamente registrado, comprovante de endereço atual e, se houve alteração de nome, certidão de casamento ou averbação de divórcio.\n\nA inscrição será ativada em até 30 (trinta) dias úteis após a análise da documentação."],
            ['category' => 'Inscrição e Registro', 'question' => 'Vou atuar em outro estado. Preciso de inscrição secundária?', 'answer' => "Sim, se for exercer atividades presenciais em jurisdição diferente da sua inscrição principal por mais de 90 dias (consecutivos ou alternados) no mesmo ano civil, conforme a Resolução CFN nº 795/2024.\n\nValor: anuidade de inscrição secundária do ano corrente (R\$ 119,13) proporcional. É necessária certidão de regularidade emitida pelo CRN de origem."],
            ['category' => 'Inscrição e Registro', 'question' => 'Minha inscrição provisória vai vencer. Posso prorrogar?', 'answer' => "Sim, durante o período de vigência da inscrição provisória, preferencialmente com 15 dias de antecedência do vencimento. Inscrições provisórias já vencidas não podem ser prorrogadas — nesse caso é necessário requerer uma nova inscrição definitiva."],
            ['category' => 'Inscrição e Registro', 'question' => 'Mudei de estado. Como faço a transferência de inscrição?', 'answer' => "Envie Ficha de Inscrição, documento de identificação, foto 3×4, diploma registrado, certidão de regularidade emitida pelo CRN de origem (emitida há até 30 dias) e comprovante de endereço.\n\nA carteira profissional do CRN de origem deve ser devolvida pessoalmente ou pelos Correios à sede ou às delegacias do CRN-9. A inscrição será ativada em até 30 (trinta) dias úteis."],

            // Situação da Inscrição
            ['category' => 'Situação da Inscrição', 'question' => 'Vou parar de atuar por um tempo. Como solicitar baixa temporária?', 'answer' => "A baixa temporária é concedida quando o nutricionista não estiver exercendo atividades previstas nos arts. 3º e 4º da Lei Federal nº 8.234/1991. É preciso devolver a Carteira de Identidade Profissional original e enviar o formulário de solicitação, com documentação que comprove a não atuação.\n\nSe solicitada até 31 de março, o profissional fica isento do pagamento da anuidade do ano em exercício. A baixa temporária pode durar até 5 anos e ser prorrogada uma vez."],
            ['category' => 'Situação da Inscrição', 'question' => 'Como funciona a reativação de inscrição?', 'answer' => "A inscrição pode ser reativada a qualquer momento durante o período de vigência da baixa temporária, mediante formulário de reativação e comprovante de endereço atual. Inscrições canceladas não podem ser reativadas — é necessário requerer uma nova inscrição definitiva.\n\nValor: anuidade do ano corrente (R\$ 566,32) proporcional."],
            ['category' => 'Situação da Inscrição', 'question' => 'Não vou mais atuar como nutricionista. Como cancelar minha inscrição?', 'answer' => "O cancelamento é concedido quando o profissional não estiver exercendo atividades previstas nos arts. 3º e 4º da Lei Federal nº 8.234/1991. Devolva a Carteira de Identidade Profissional e envie o formulário de cancelamento.\n\nSe solicitado até 31 de março, o profissional fica isento da anuidade do ano em exercício. O cancelamento pode ser solicitado mesmo com débitos em aberto, que continuam sendo cobrados."],

            // Financeiro
            ['category' => 'Financeiro', 'question' => 'Quanto custa a anuidade e como pagar?', 'answer' => "A anuidade do nutricionista é de R\$ 595,66, podendo ser paga em cota única até 10/07 ou em até 10 parcelas mensais (fevereiro a novembro). Com desconto de 15% para pagamento em cota única até 10/02, o valor cai para R\$ 506,31.\n\nO pagamento da anuidade do ano corrente não quita débitos anteriores. Consulte a Resolução CFN nº 829/2025, que trata das normas gerais de anuidades."],

            // Documentos e Certidões
            ['category' => 'Documentos e Certidões', 'question' => 'Onde emitir a certidão de regularidade?', 'answer' => "A solicitação pode ser feita pelo Autoatendimento. Acesse com seus dados de acesso o menu \"Acesse sua Inscrição\", escolha a opção \"Emissão de Certidão\" e selecione o documento desejado."],
            ['category' => 'Documentos e Certidões', 'question' => 'Perdi minha carteira profissional. Como solicitar a segunda via?', 'answer' => "Envie o formulário de solicitação de 2ª via, uma foto 3×4 recente e assinatura digitalizada. Em caso de perda, roubo ou extravio, anexe também o boletim de ocorrência.\n\nO profissional não pode ter débitos vencidos para receber o novo documento, e a carteira substituída deve ser descartada após o recebimento da nova."],
            ['category' => 'Documentos e Certidões', 'question' => 'Como registrar meu título de especialista no CRN-9?', 'answer' => "É preciso ter pelo menos 3 anos de inscrição ativa no CRN-9 (ou 2 anos com certificado de residência na especialidade), e apresentar o título de especialista emitido pela ASBRAN ou entidade chancelada pelo CFN.\n\nTaxa: R\$ 44,22 (Resolução CFN nº 833/2025). O nutricionista pode registrar quantos títulos desejar."],

            // Atuação Profissional
            ['category' => 'Atuação Profissional', 'question' => 'Como solicitar anotação de responsabilidade (ART ou ARAAN)?', 'answer' => "Conforme a Resolução CFN nº 795/2024, a Anotação de Responsabilidade Técnica (ART) ou pelas Atividades de Alimentação e Nutrição Humana (ARAAN) deve ser solicitada pelo nutricionista mediante formulário próprio, enviado exclusivamente pelo JOTFORM, junto com o Termo de Compromisso e o dimensionamento correspondente ao serviço.\n\nO nutricionista precisa estar em situação cadastral regular e sem pendência financeira. O CRN anota até 5 responsabilidades técnicas por profissional."],
            ['category' => 'Atuação Profissional', 'question' => 'Como cadastrar minha atuação como autônomo no CRN-9?', 'answer' => "Preencha o Requerimento de Cadastro da Atuação do Nutricionista como Profissional Liberal Autônomo e, se desejar, solicite a emissão da Certidão de Cadastro do Autônomo (CCA). Todos os documentos devem ser enviados exclusivamente pelo formulário oficial.\n\nDúvidas podem ser esclarecidas com o setor de fiscalização (fiscalizacao@crn9.org.br)."],
        ];

        foreach ($items as $index => $item) {
            Faq::updateOrCreate(
                ['category' => $item['category'], 'question' => $item['question']],
                [
                    'category' => $item['category'],
                    'question' => $item['question'],
                    'answer' => $item['answer'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * Ferramenta "Pode ou Não Pode?": respostas diretas sobre o exercício
     * profissional, fundamentadas em Resoluções do CFN, confirmadas em
     * cfn.org.br/perguntas-frequentes/.
     */
    private function seedPodeNaoPode(): void
    {
        $items = [
            [
                'category' => 'Fitoterapia e PICS',
                'question' => 'Nutricionista sem pós-graduação em fitoterapia, pode prescrever fitoterápico?',
                'answer' => 'O profissional não habilitado em fitoterapia pode prescrever apenas infusão, decocção e maceração em água, além de drogas vegetais e óleos fixos classificados como alimentos ou suplementos alimentares. Para prescrever medicamentos fitoterápicos, produtos tradicionais fitoterápicos ou preparações magistrais de fitoterápicos, é exigido certificado de pós-graduação em Fitoterapia (mínimo 200h específicas) ou título de especialista na área.',
                'resolution_reference' => 'Resolução CFN nº 680/2021',
            ],
            [
                'category' => 'Fitoterapia e PICS',
                'question' => 'Todos os produtos da Medicina Tradicional Chinesa podem ser prescritos pelo nutricionista?',
                'answer' => 'Sim, desde que regulamentados pela Anvisa e não sujeitos a prescrição médica. Para adotar a dietoterapia/fitoterapia da Medicina Tradicional Chinesa, do ayurveda ou da antroposofia, o nutricionista precisa atender aos requisitos específicos de habilitação e registrar a documentação no Sistema de Cadastro de PICS e Fitoterapia do CFN.',
                'resolution_reference' => 'Resolução CFN nº 679/2021',
            ],
            [
                'category' => 'Fitoterapia e PICS',
                'question' => 'O nutricionista pode adotar as Práticas Integrativas e Complementares (PICS) de forma isolada, sem uma consulta nutricional?',
                'answer' => 'Não. As PICS não podem ser utilizadas de forma isolada, salvo em protocolos estabelecidos no âmbito do SUS. Elas só podem ser adotadas como parte da assistência nutricional e dietoterápica e da educação nutricional a indivíduos ou coletividades, sadios ou enfermos.',
                'resolution_reference' => 'Resolução CFN nº 679/2021',
            ],
            [
                'category' => 'Prescrição e Suplementos',
                'question' => 'O nutricionista pode prescrever suplementos alimentares?',
                'answer' => 'Sim. A prescrição dietética de suplementos alimentares inclui nutrientes, substâncias bioativas, enzimas, prebióticos, probióticos, produtos apícolas (mel, própolis, geleia real, pólen), novos alimentos e ingredientes autorizados pela Anvisa, além de medicamentos isentos de prescrição à base de vitaminas, minerais, aminoácidos e/ou proteínas isolados ou associados entre si.',
                'resolution_reference' => 'Lei nº 8.234/1991 e Resolução CFN nº 656/2020',
            ],
            [
                'category' => 'Prescrição e Suplementos',
                'question' => 'O que não pode ser prescrito pelo nutricionista, em nenhuma hipótese?',
                'answer' => "Não pode ser prescrito o que não está regulamentado pelo CFN para a profissão. Exemplos: medicamentos sujeitos a prescrição médica; medicamentos isentos de prescrição (MIP) que não sejam à base de vitaminas, minerais, aminoácidos ou proteínas isolados/associados, nem MIPs fitoterápicos, homeopáticos ou antroposóficos habilitados; paraprobióticos, pós-bióticos e apitoxina, entre outros não regulamentados.",
                'resolution_reference' => 'Resoluções CFN nº 656/2020, 680/2021 e 679/2021',
            ],
            [
                'category' => 'Exames e Prontuário',
                'question' => 'O nutricionista pode solicitar exames laboratoriais?',
                'answer' => "Sim. A solicitação de exames laboratoriais necessários ao acompanhamento dietoterápico é requisito essencial da consulta nutricional, inclusive para a prescrição dietética — complementa a anamnese, a antropometria e o exame clínico-nutricional. Não se trata de diagnóstico, tratamento ou procedimento, e não é solicitação de exame para diagnóstico de doenças (nosológico).",
                'resolution_reference' => 'Lei Federal nº 8.234/1991, art. 4º, inciso VIII',
            ],
            [
                'category' => 'Exames e Prontuário',
                'question' => 'O que deve constar no carimbo do prontuário/documentos assinados pelo nutricionista?',
                'answer' => 'Todo documento produzido pelo nutricionista no exercício profissional (prontuário, laudos, prescrições) deve identificar claramente o profissional responsável: nome completo e número de inscrição no CRN-9. O modelo oficial abaixo está disponível para copiar com 1 clique.',
                'resolution_reference' => null,
                'template_label' => 'Copiar modelo do carimbo',
                'template_text' => "[Nome completo do profissional]\nNutricionista – CRN9 nº [número de inscrição]",
            ],
            [
                'category' => 'Responsabilidade Técnica',
                'question' => 'Quais são as atribuições de um Responsável Técnico (RT)? Como se tornar um?',
                'answer' => 'O Nutricionista RT assume o compromisso profissional e legal na execução das atividades de alimentação e nutrição de uma empresa ou instituição, cumprindo e fazendo cumprir os dispositivos legais do exercício profissional, com direção técnica, chefia e supervisão da equipe quando houver. A Responsabilidade Técnica é concedida pelo CRN mediante solicitação e análise de documentação.',
                'resolution_reference' => 'Resolução CFN nº 576/2016',
            ],
        ];

        foreach ($items as $index => $item) {
            PodeNaoPodeQuestion::updateOrCreate(
                ['category' => $item['category'], 'question' => $item['question']],
                [
                    'category' => $item['category'],
                    'question' => $item['question'],
                    'answer' => $item['answer'],
                    'resolution_reference' => $item['resolution_reference'] ?? null,
                    'template_label' => $item['template_label'] ?? null,
                    'template_text' => $item['template_text'] ?? null,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * "Nutrição em Minas": histórias reais de nutricionistas e técnicos
     * atuando nas diferentes áreas da profissão pelo estado, para mostrar
     * o valor da Nutrição além do papel fiscalizador do CRN-9. Os itens
     * abaixo são exemplos ilustrativos de estrutura/tom, a serem
     * substituídos por histórias reais levantadas pela equipe de
     * comunicação do CRN-9 (ou indicadas pelo público via /nutricao-em-minas/indicar).
     */
    private function seedNutritionStories(): void
    {
        $items = [
            [
                'title' => 'Exemplo: Nutrição na rede municipal de saúde',
                'area' => 'Saúde Pública',
                'region' => 'Belo Horizonte/MG',
                'role' => 'Nutricionista da Atenção Primária à Saúde',
                'summary' => 'Como o acompanhamento nutricional em unidades básicas de saúde previne doenças crônicas e melhora a qualidade de vida da população.',
                'body' => "Substituir por uma história real: como é o dia a dia de um(a) nutricionista atuando na Atenção Primária à Saúde, os desafios enfrentados, o impacto na comunidade atendida e por que esse trabalho importa para a sociedade.\n\nSugestão de estrutura: contexto do serviço, um caso ou conquista concreta, e uma reflexão sobre o valor da Nutrição na saúde pública.",
            ],
            [
                'title' => 'Exemplo: Alimentação Escolar que transforma',
                'area' => 'Alimentação Escolar',
                'region' => 'Uberlândia/MG',
                'role' => 'Nutricionista Responsável Técnica pelo PNAE',
                'summary' => 'A responsabilidade técnica pelo Programa Nacional de Alimentação Escolar garante refeições seguras e nutritivas para milhares de estudantes.',
                'body' => "Substituir por uma história real de um(a) profissional responsável técnico pela alimentação escolar em um município mineiro: como planeja cardápios, garante segurança alimentar e contribui para a aprendizagem dos estudantes.",
            ],
            [
                'title' => 'Exemplo: Pesquisa que gera política pública',
                'area' => 'Universidades e Pesquisa',
                'region' => 'Juiz de Fora/MG',
                'role' => 'Nutricionista pesquisadora',
                'summary' => 'Pesquisas desenvolvidas em universidades mineiras têm influenciado diretrizes de segurança alimentar e nutricional no estado.',
                'body' => "Substituir por uma história real sobre uma pesquisa acadêmica conduzida por nutricionista em Minas Gerais e seu impacto prático — por exemplo, em políticas públicas, diretrizes clínicas ou programas de segurança alimentar.",
            ],
            [
                'title' => 'Exemplo: Cuidado nutricional hospitalar',
                'area' => 'Hospitais',
                'region' => 'Montes Claros/MG',
                'role' => 'Nutricionista Clínica',
                'summary' => 'A atuação da equipe de nutrição em ambiente hospitalar é decisiva para a recuperação de pacientes em estado grave.',
                'body' => "Substituir por uma história real de um(a) nutricionista clínico(a) hospitalar, destacando um caso (sem identificar pacientes) em que a intervenção nutricional fez diferença concreta na recuperação.",
            ],
        ];

        foreach ($items as $index => $item) {
            NutritionStory::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'slug' => Str::slug($item['title']),
                    'area' => $item['area'],
                    'region' => $item['region'],
                    'role' => $item['role'],
                    'summary' => $item['summary'],
                    'body' => $item['body'],
                    'status' => 'published',
                    'is_active' => true,
                    'is_featured' => $index === 0,
                    'sort_order' => $index + 1,
                    'published_at' => now()->subDays($index),
                ]
            );
        }
    }

    private function seedDocumentTemplates(): void
    {
        $tcle = <<<'RTF'
        {\rtf1\ansi\ansicpg1252\deff0{\fonttbl{\f0 Arial;}}\f0\fs22
        {\b TERMO DE CONSENTIMENTO LIVRE E ESCLARECIDO (TCLE) \line ATENDIMENTO NUTRICIONAL}\par\par
        Eu, [nome completo do paciente/cliente], CPF [n\'famero do CPF], declaro que fui informado(a) de forma clara pelo(a) nutricionista [nome completo do profissional], CRN9 n\'ba [n\'famero de inscri\'e7\'e3o], sobre o atendimento nutricional a ser realizado, e manifesto meu consentimento livre e esclarecido nos termos abaixo.\par\par
        {\b 1. Natureza do atendimento}\par
        ( ) Presencial, em [endere\'e7o/unidade].\par
        ( ) Por telenutri\'e7\'e3o (teleatendimento), nos termos da Resolu\'e7\'e3o CFN n\'ba 760/2023, mediante uso de tecnologias de informa\'e7\'e3o e comunica\'e7\'e3o, com garantia de sigilo e confidencialidade das informa\'e7\'f5es transmitidas.\par\par
        {\b 2. Objetivo do atendimento}\par
        [Descrever objetivo: avalia\'e7\'e3o nutricional, acompanhamento cl\'ednico, orienta\'e7\'e3o alimentar, entre outros].\par\par
        {\b 3. Procedimentos}\par
        O atendimento poder\'e1 incluir anamnese alimentar e cl\'ednica, avalia\'e7\'e3o antropom\'e9trica, an\'e1lise de exames complementares (quando fornecidos pelo paciente/cliente) e elabora\'e7\'e3o de progn\'f3stico e conduta nutricional, conforme o C\'f3digo de \'c9tica e Conduta do(a) Nutricionista (Resolu\'e7\'e3o CFN n\'ba 599/2018).\par\par
        {\b 4. Confidencialidade e prote\'e7\'e3o de dados}\par
        As informa\'e7\'f5es pessoais e de sa\'fade coletadas ser\'e3o tratadas com sigilo profissional e em conformidade com a Lei Geral de Prote\'e7\'e3o de Dados (Lei n\'ba 13.709/2018 \'96 LGPD), sendo utilizadas exclusivamente para fins do atendimento nutricional, salvo autoriza\'e7\'e3o expressa em contr\'e1rio ou obriga\'e7\'e3o legal.\par\par
        {\b 5. Direitos do paciente/cliente}\par
        Fica assegurado o direito de recusar, interromper ou revogar este consentimento a qualquer momento, sem preju\'edzo ao atendimento, bem como o direito de solicitar esclarecimentos adicionais sobre a conduta nutricional proposta.\par\par
        {\b 6. Declara\'e7\'e3o de consentimento}\par
        Declaro estar ciente das informa\'e7\'f5es acima e concordo, de forma livre e esclarecida, com a realiza\'e7\'e3o do atendimento nutricional descrito.\par\par
        [Local], [data].\par\par
        _______________________________________\par
        Assinatura do paciente/cliente ou respons\'e1vel legal\par\par
        _______________________________________\par
        [Nome completo do profissional] \'96 Nutricionista \'96 CRN9 n\'ba [n\'famero de inscri\'e7\'e3o]\par
        }
        RTF;

        $laudo = <<<'RTF'
        {\rtf1\ansi\ansicpg1252\deff0{\fonttbl{\f0 Arial;}}\f0\fs22
        {\b LAUDO DE NOTIFICA\'c7\'c3O DE IRREGULARIDADES / FALTA DE INSUMOS}\par
        {\i Uso em hospitais, servi\'e7os de sa\'fade e unidades de alimenta\'e7\'e3o e nutri\'e7\'e3o (UAN)}\par\par
        {\b 1. Identifica\'e7\'e3o da unidade/servi\'e7o}\par
        Institui\'e7\'e3o/empresa: [nome]\par
        Unidade/setor: [unidade ou setor]\par
        Endere\'e7o: [endere\'e7o completo]\par\par
        {\b 2. Identifica\'e7\'e3o do nutricionista respons\'e1vel t\'e9cnico}\par
        Nome: [nome completo do profissional]\par
        CRN9 n\'ba: [n\'famero de inscri\'e7\'e3o]\par
        Data e hora da constata\'e7\'e3o: [data] \'e0s [hor\'e1rio]\par\par
        {\b 3. Descri\'e7\'e3o da irregularidade / falta de insumo}\par
        [Descrever objetivamente o fato constatado: falta de g\'eaneros aliment\'edcios, quebra da cadeia de frio, condi\'e7\'e3o inadequada de instala\'e7\'f5es, equipamento com defeito, descumprimento de Procedimento Operacional Padronizado (POP), entre outros].\par\par
        {\b 4. Risco identificado}\par
        [Descrever o risco \'e0 sa\'fade dos clientes/pacientes/coletividade e/ou \'e0 seguran\'e7a alimentar decorrente da irregularidade].\par\par
        {\b 5. Medidas corretivas solicitadas}\par
        [Descrever as medidas solicitadas e o prazo para regulariza\'e7\'e3o].\par\par
        {\b 6. Encaminhamento}\par
        Nos termos do item 1.1.18 do Anexo II da Resolu\'e7\'e3o CFN n\'ba 380/2005, este laudo \'e9 encaminhado ao hier\'e1rquico superior e, quando aplic\'e1vel, \'e0s autoridades sanit\'e1rias e/ou ao CRN9, para as provid\'eancias cab\'edveis.\par\par
        [Local], [data].\par\par
        _______________________________________\par
        [Nome completo do profissional] \'96 Nutricionista \'96 CRN9 n\'ba [n\'famero de inscri\'e7\'e3o]\par\par
        _______________________________________\par
        Ci\'eancia do respons\'e1vel pela unidade/institui\'e7\'e3o\par
        }
        RTF;

        $prontuario = <<<'RTF'
        {\rtf1\ansi\ansicpg1252\deff0{\fonttbl{\f0 Arial;}}\f0\fs22
        {\b MODELO DE PRONTU\'c1RIO NUTRICIONAL PADR\'c3O}\par\par
        {\b 1. Identifica\'e7\'e3o}\par
        Nome: [nome completo] \'96 Data de nascimento: [data] \'96 Sexo: [sexo]\par
        Data do atendimento: [data] \'96 Tipo de consulta: ( ) Inicial ( ) Retorno/reconsulta\par\par
        {\b 2. Anamnese alimentar e cl\'ednica}\par
        Queixa principal: [descrever]\par
        Hist\'f3rico cl\'ednico e patologias associadas: [descrever]\par
        H\'e1bitos alimentares e recorda\'e7\'e3o de 24h: [descrever]\par\par
        {\b 3. Avalia\'e7\'e3o antropom\'e9trica}\par
        Peso atual: [ ] kg \'96 Estatura: [ ] cm \'96 IMC: [ ]\par
        Circunfer\'eancias e demais medidas (quando aplic\'e1vel): [descrever]\par\par
        {\b 4. Dados bioqu\'edmicos (quando dispon\'edveis)}\par
        [Listar exames e valores de refer\'eancia]\par\par
        {\b 5. Diagn\'f3stico nutricional}\par
        [Descrever com base nos dados cl\'ednicos, bioqu\'edmicos, antropom\'e9tricos e diet\'e9ticos, conforme Resolu\'e7\'e3o CFN n\'ba 380/2005, Anexo II]\par\par
        {\b 6. Prescri\'e7\'e3o diet\'e9tica / conduta}\par
        [Descrever plano alimentar, orienta\'e7\'f5es e, quando necess\'e1rio, suplementos nutricionais prescritos em conformidade com a legisla\'e7\'e3o vigente]\par\par
        {\b 7. Evolu\'e7\'e3o nutricional (retornos)}\par
        [Data] \'96 [Registro da evolu\'e7\'e3o e ajustes de conduta]\par\par
        {\b 8. Identifica\'e7\'e3o do profissional}\par
        [Nome completo do profissional]\par
        Nutricionista \'96 CRN9 n\'ba [n\'famero de inscri\'e7\'e3o]\par
        }
        RTF;

        $items = [
            [
                'title' => 'Modelo de Termo de Consentimento Livre e Esclarecido (TCLE)',
                'category' => 'Atendimento Clínico',
                'description' => 'Modelo de TCLE para uso em teleatendimento (telenutrição) e em consultas presenciais, com referência à Resolução CFN nº 760/2023 e à LGPD (Lei nº 13.709/2018).',
                'file' => 'modelos-editaveis/tcle-atendimento-nutricional.rtf',
                'content' => $tcle,
            ],
            [
                'title' => 'Laudo de Notificação de Irregularidades / Falta de Insumos',
                'category' => 'Alimentação Coletiva e Serviços de Saúde',
                'description' => 'Modelo de laudo para uso em hospitais e unidades de alimentação e nutrição (UAN), para notificação formal de irregularidades ou falta de insumos ao hierárquico superior e às autoridades competentes.',
                'file' => 'modelos-editaveis/laudo-notificacao-irregularidades.rtf',
                'content' => $laudo,
            ],
            [
                'title' => 'Modelo de Prontuário Nutricional Padrão',
                'category' => 'Atendimento Clínico',
                'description' => 'Estrutura padrão de prontuário nutricional (identificação, anamnese, avaliação antropométrica, diagnóstico, prescrição e evolução), ajustada às exigências normativas do CFN/CRN.',
                'file' => 'modelos-editaveis/prontuario-nutricional-padrao.rtf',
                'content' => $prontuario,
            ],
        ];

        foreach ($items as $index => $item) {
            if (! Storage::disk('public')->exists($item['file'])) {
                Storage::disk('public')->put($item['file'], mb_convert_encoding($item['content'], 'Windows-1252', 'UTF-8'));
            }

            $template = DocumentTemplate::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'slug' => Str::slug($item['title']),
                    'category' => $item['category'],
                    'description' => $item['description'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );

            DocumentTemplateFile::updateOrCreate(
                ['document_template_id' => $template->id, 'label' => 'Baixar modelo (Word/RTF)'],
                ['file' => $item['file'], 'sort_order' => 1]
            );
        }
    }

    private function seedFiscalizacaoStats(): void
    {
        $stats = [
            ['label' => 'Visitas realizadas', 'value' => '420 (exemplo)'],
            ['label' => 'Profissionais fiscalizados', 'value' => '310 (exemplo)'],
            ['label' => 'Pessoas jurídicas fiscalizadas', 'value' => '95 (exemplo)'],
            ['label' => 'Orientações realizadas', 'value' => '540 (exemplo)'],
            ['label' => 'Denúncias recebidas', 'value' => '48 (exemplo)'],
            ['label' => 'Denúncias encaminhadas', 'value' => '31 (exemplo)'],
            ['label' => 'Municípios alcançados', 'value' => '112 (exemplo)'],
        ];

        foreach ($stats as $index => $stat) {
            FiscalizacaoStat::updateOrCreate(
                ['label' => $stat['label']],
                [
                    'value' => $stat['value'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedFiscalizacaoProcesses(): void
    {
        $processes = [
            ['category' => 'Ética: conduta inadequada', 'code' => 'A12', 'subject' => 'ILPI', 'started_at' => '2024-01-01', 'status' => 'No jurídico'],
            ['category' => 'Fiscalização: exercício sem inscrição', 'code' => 'B07', 'subject' => 'Alimentação Coletiva', 'started_at' => '2025-03-01', 'status' => 'Em andamento'],
            ['category' => 'Fiscalização: irregularidade de RT', 'code' => 'B12', 'subject' => 'Hospitalar', 'started_at' => '2025-08-01', 'status' => 'Aguardando defesa'],
        ];

        foreach ($processes as $index => $process) {
            FiscalizacaoProcess::updateOrCreate(
                ['code' => $process['code']],
                [
                    'category' => $process['category'],
                    'subject' => $process['subject'],
                    'started_at' => $process['started_at'],
                    'status' => $process['status'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedFiscalizacaoRegionStats(): void
    {
        $regions = [
            ['region' => 'Sede (Belo Horizonte)', 'visits_count' => 180],
            ['region' => 'Delegacia de Uberlândia', 'visits_count' => 65],
            ['region' => 'Delegacia de Juiz de Fora', 'visits_count' => 55],
            ['region' => 'Delegacia de Montes Claros', 'visits_count' => 40],
            ['region' => 'Delegacia de Pouso Alegre', 'visits_count' => 38],
            ['region' => 'Delegacia de Ipatinga', 'visits_count' => 32],
            ['region' => 'Barbacena', 'visits_count' => 10],
        ];

        foreach ($regions as $index => $region) {
            FiscalizacaoRegionStat::updateOrCreate(
                ['region' => $region['region']],
                [
                    'visits_count' => $region['visits_count'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
