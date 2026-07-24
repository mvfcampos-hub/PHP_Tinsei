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
            [
                'title' => 'Identidade Visual do CRN-9',
                'slug' => 'identidade-visual-do-crn-9',
                'content' => <<<'HTML'
                    <p>O Conselho Regional de Nutrição da 9ª Região (CRN-9) é o órgão público responsável por garantir e desenvolver a qualidade dos serviços prestados pelos profissionais de Nutrição (Nutricionistas e Técnicos em Nutrição e Dietética). Em 2020, após um processo elaborado "a muitas mãos", o CRN-9 lançou sua identidade visual, mantida como referência oficial da marca neste novo site.</p>
                    <h2>Paleta de cores</h2>
                    <p>O estudo de cores da marca busca equilibrar jovialidade, credibilidade, proximidade e seriedade:</p>
                    <ul>
                        <li><strong>Verde jovial</strong> #A3A64A — contraponto entre jovialidade e credibilidade.</li>
                        <li><strong>Verde sóbrio</strong> #5C5E2B — tom mais sóbrio, reforça a credibilidade.</li>
                        <li><strong>Laranja</strong> #F58C4A — referência ao humano, trabalha a proximidade com o público.</li>
                        <li><strong>Azul luminoso</strong> #85B0FF — traz seriedade e credibilidade, em tom luminoso.</li>
                    </ul>
                    <h2>Construção da marca</h2>
                    <p>A marca do CRN-9 foi construída visando trazer, em seu símbolo, os conceitos de proximidade, simplicidade e fluidez. O símbolo gráfico apresenta formas orgânicas e fluidas dispostas de modo a compor uma paisagem natural aconchegante. A tipografia construída para a marca apresenta desenho geométrico e amplo, traçado fino e quinas arredondadas para trazer proximidade.</p>
                    <h2>Tipografia</h2>
                    <p>O site institucional utiliza a família <strong>Poppins</strong> para títulos e destaques, e <strong>Open Sans</strong> para textos correntes — mantendo a leveza e a legibilidade da identidade original.</p>
                    HTML,
            ],
            [
                'title' => 'Links Importantes',
                'slug' => 'links-importantes',
                'content' => <<<'HTML'
                    <p>Página em atualização. No site oficial anterior, esta seção reunia links de referência da categoria (legislação, portais parceiros e sistemas do CFN/CRN).</p>
                    <p>Nota técnica: no momento da migração de conteúdo, a página equivalente em crn9.org.br retornava erro interno (HTTP 500). Assim que o time de comunicação do CRN-9 disponibilizar a lista atualizada de links, ela deve ser cadastrada aqui pelo painel administrativo.</p>
                    HTML,
            ],
            ['title' => 'O CRN-9', 'slug' => 'o-crn-9', 'content' => '<p>O CONSELHO REGIONAL DE NUTRIÇÃO DA 9ª REGIÃO é uma autarquia sem fins lucrativos, de interesse público, com poder delegado pela União para orientar, disciplinar e fiscalizar o exercício e as atividades da profissão de Nutricionista e Técnico em Nutrição e Dietética no estado de Minas Gerais, em defesa da sociedade. É um órgão do Sistema Conselho Federal de Nutrição/Conselhos Regionais de Nutrição (CFN/CRN).</p>
<p>O Sistema CFN/CRN tem como órgão central o Conselho Federal de Nutrição (CFN) e é integrado, atualmente, por onze Conselhos Regionais de Nutrição que representam os diversos Estados brasileiros. O Sistema se mantém com a arrecadação proveniente de anuidades, taxas, multas e emolumentos (taxa cobrada pela expedição de um documento), recolhidos por pessoas físicas (nutricionistas e técnicos) e jurídicas (empresas e instituições). Do montante de recursos arrecadados em todos os onze regionais, 20% é destinado ao CFN.</p>
<p>O CRN-9 atua em Minas Gerais, tendo sua sede em Belo Horizonte e cinco delegacias, nas cidades de Juiz de Fora, Montes Claros, Pouso Alegre, Uberlândia e Ipatinga.</p>'],
            ['title' => 'Plenário', 'slug' => 'plenario', 'content' => '<p>Vice-presidente</p>
<p>Diretora Secretária</p>
<p>Diretora Tesoureira</p>
<p>Conteúdo complementar (composição completa da diretoria e conselheiros) a ser detalhado pela equipe de comunicação do CRN-9.</p>'],
            ['title' => 'Política de Ingresso', 'slug' => 'politica-de-ingresso', 'content' => '<ul><li>Projeto "Comida de Verdade na Escola – A importância da Nutrição e da Agricultura Familiar no Programa Nacional de Alimentação Escolar – PNAE"</li></ul>
<ul><li>Etapa Seleção de Bolsistas</li><li>Seleção de Bolsistas – Chamamento para entrevista</li><li>Resultado da seleção de Bolsistas</li><li>Cronograma de seleção de bolsistas</li><li>Resultado homologado após o prazo recursal</li></ul>'],
            ['title' => 'Concurso Público', 'slug' => 'concurso-publico', 'content' => '<p>O CRN9 é uma Autarquia Federal e, dessa forma, parte integrante da Administração Pública Indireta. Conforme o art. 37, II, da Constituição Federal, a investidura em cargo ou emprego público depende de aprovação prévia em concurso público de provas ou de provas e títulos, ressalvadas as nomeações para cargo em comissão declarado em lei de livre nomeação e exoneração.</p>
<p>Os candidatos aprovados serão convocados conforme a necessidade do órgão, durante o período de vigência do concurso.</p>
<p>O cadastro de reserva, ou banco de aprovados, é utilizado para contratações futuras do órgão, quando a Administração Pública não tem certeza de quantos servidores serão necessários para seu quadro de pessoal, ou quantas vagas vão surgir durante a validade do concurso. O cadastro de reserva funciona como uma "fila de espera".</p>
<p>As convocações são feitas por meio de publicação no Diário Oficial da União (DOU) e envio de correspondência e/ou e-mail para o candidato. Para isso, é importante que o mesmo mantenha seus dados atualizados junto ao CRN9 pelo endereço eletrônico crn9@crn9.org.br.</p>
<p>Acompanhe editais e resultados no Portal de Transparência do CRN9.</p>'],
            ['title' => 'Licitações', 'slug' => 'licitacoes', 'content' => '<h3>Pregão Eletrônico Nº 90005/2024</h3>
<p>Contratação de consultoria especializada em segurança da informação. Edital, anexos e esclarecimentos disponíveis para consulta.</p>
<h3>Pregão Eletrônico nº 90003/2024</h3>
<p>Objeto: Contratação de pessoa jurídica para o fornecimento de ramais de telefonia VOIP.</p>
<h3>Pregão Eletrônico nº 90002/2024</h3>
<p>Aquisição de materiais de limpeza conforme condições, quantidades e exigências estabelecidas no Edital.</p>
<h3>Pregão Eletrônico nº 1/2024</h3>
<p>Contratação de pessoa jurídica para prestação de serviço SaaS (Software as a Service).</p>
<h3>Pregão Eletrônico nº 1/2023</h3>
<h3>Pregão Eletrônico nº 3/2023</h3>
<p>Objeto: contratação de pessoa jurídica para prestação de serviço de auditoria governamental independente.</p>
<h3>Chamamento Público 01/2023</h3>
<p>Objeto: selecionar e credenciar pessoas jurídicas de direito privado prestadoras de serviços de interesse do CRN-9.</p>
<h3>Edital da Tomada de Preços nº 1/2022</h3>'],
            ['title' => 'Sede e Delegacias', 'slug' => 'sede-delegacias', 'content' => '<h3>Sede CRN-9 – Belo Horizonte</h3><p>Edifício Celta — R. Maranhão, 310, 4º Andar, Santa Efigênia, Belo Horizonte/MG — CEP: 30150-330</p>
<h3>Delegacia de Ipatinga</h3><p>Edifício Horto Office — R. Vinhático, 15, Sala 707, Horto, Ipatinga/MG — CEP: 35160-317</p>
<h3>Delegacia de Juiz de Fora</h3><p>Edifício Bancantil — R. Halfed, 651, Sala 1406, Centro, Juiz de Fora/MG — CEP: 36010-902</p>
<h3>Delegacia de Montes Claros</h3><p>Edifício Premier Center — R. Correia Machado, 1025, Salas 1305 e 1306, Centro, Montes Claros/MG — CEP: 39400-090</p>
<h3>Delegacia de Pouso Alegre</h3><p>Edifício Pouso Alegre Shopping Center — R. Coronel Otávio Meyer, 160, Salas 224 e 225, Centro, Pouso Alegre/MG — CEP: 37550-068</p>
<h3>Delegacia de Uberlândia</h3><p>Edifício Executivo — R. Coronel Antônio Alves Pereira, 400, Sala 915, Centro, Uberlândia/MG — CEP: 38400-104</p>'],
            ['title' => 'Perguntas Frequentes', 'slug' => 'perguntas-frequentes', 'content' => '<p>Encontre aqui respostas rápidas sobre inscrição, anuidade, transferências, documentos e demais serviços do CRN-9.</p>
<h3>Tipo de inscrição</h3>
<p>A primeira inscrição do profissional poderá ser provisória ou definitiva, dependendo da documentação acadêmica.</p>
<p><strong>Inscrição Provisória</strong> – validade de 2 (dois) anos. Destinada ao profissional que possui certificado ou declaração de conclusão de curso, com a data de colação de grau, de curso reconhecido pelo MEC; ou ao portador de diploma emitido por instituição de ensino superior em processo de reconhecimento regular.</p>
<p><strong>Inscrição Definitiva</strong> – validade indeterminada. Destinada ao portador de diploma registrado no órgão competente, obtido em instituição com curso reconhecido pelo MEC.</p>
<h3>Documentos necessários</h3>
<ul><li>Ficha de Inscrição devidamente preenchida e assinada (manualmente ou eletronicamente pela conta gov.br);</li><li>Documento oficial de identificação com foto e CPF ou CIN, válido em todo o território nacional, expedido há menos de 10 anos;</li><li>Uma foto 3×4 colorida e nítida, recente, com fundo branco e em postura formal;</li><li>Digital do polegar direito reproduzida em papel branco, sem pauta, com tinta preta;</li><li>Assinatura digitalizada em formato .png;</li><li>Declaração de Conclusão de Curso, constando a data de colação de grau;</li><li>Cópia de comprovante de endereço atual;</li><li>Cópia de certidão de casamento ou averbação de divórcio, se houve alteração de nome.</li></ul>
<p>Atenção: prossiga com o requerimento apenas se pretende atuar na jurisdição do CRN-9 (Minas Gerais). Caso contrário, acesse o site do CRN da sua jurisdição.</p>'],
            ['title' => 'Fale Conosco', 'slug' => 'fale-conosco', 'content' => '<p>Rua Maranhão, 310, 4º Andar, Santa Efigênia, Belo Horizonte/MG — CEP: 30150-330</p>
<p>Funcionamento: das 9h às 17h</p>
<p>Telefone: (31) 3226-8403</p>
<p>E-mail: crn9@crn9.org.br</p>'],
            ['title' => 'Ouvidoria', 'slug' => 'ouvidoria', 'content' => '<p>A Ouvidoria do CRN-9 é um canal exclusivo para o registro de sugestões, elogios, reclamações ou denúncias quanto aos serviços prestados pelo Conselho e que não tenham sido atendidos no prazo regulamentar pelos canais de atendimento.</p>
<p>Registre sua manifestação no sistema E-OUV do Governo Federal.</p>'],
            ['title' => 'Instituições de Ensino', 'slug' => 'instituicoes-de-ensino', 'content' => '<p>Confira a lista de Instituições de Ensino Superior que oferecem o Curso de Nutrição e as Instituições de Ensino que ofertam o curso de TND em Minas Gerais.</p>
<p>A lista completa (IES – Minas Gerais) está disponível para download junto à Secretaria do CRN-9.</p>'],
            ['title' => 'Convênios', 'slug' => 'convenios', 'content' => '<p>A Qualicorp trabalha em parceria com diversos órgãos públicos e entidades de classe para oferecer benefícios em saúde para os profissionais inscritos no CRN-9 e seus familiares.</p>
<p>Consulte as condições vigentes diretamente com a Qualicorp Saúde.</p>'],
            ['title' => 'Projetos de Lei em Andamento', 'slug' => 'projetos-de-lei-em-andamento', 'content' => '<p>Acompanhamento dos Projetos de Lei de interesse da categoria, monitorados pelo Conselho Federal de Nutricionistas (CFN) em conjunto com os Conselhos Regionais.</p>'],
            ['title' => 'Pode x Não Pode', 'slug' => 'pode-x-nao-pode', 'content' => '<p>A série "Pode x Não Pode" é baseada na cartilha sobre o exercício ilegal da profissão, elaborada pela Comissão de Formação Profissional do CRN-9 e destinada a acadêmicos de cursos de graduação em Nutrição.</p>
<ul>
<li>Dicas sobre a atuação nas redes sociais</li>
<li>Grupos de emagrecimento no WhatsApp</li>
<li>Prescrição de planos alimentares para familiares</li>
<li>Realização de palestras</li>
<li>Publicação de cálculos dietéticos</li>
<li>Publicação de "antes x depois" nas redes sociais e vínculo com marcas de produtos</li>
<li>Atendimentos antes da colação de grau</li>
<li>Perfis com informações sobre composição nutricional e propriedades dos alimentos</li>
<li>Prescrição de planos alimentares/dietas</li>
<li>Publicização de planos alimentares feitos para si mesmo</li>
</ul>'],
            ['title' => 'Deu Ruim ou Tá de Boa?', 'slug' => 'deu-ruim-ou-ta-de-boa', 'content' => '<p>Nesta série, o CRN-9 aborda o Código de Ética e Conduta dos Nutricionistas de forma lúdica e atrativa, utilizando o jeito "mineirês" de se comunicar. O objetivo é alertar os(as) profissionais sobre o que pode ou não ser realizado em suas atuações.</p>
<p>Os episódios são lançados nas redes sociais oficiais do CRN-9, quinzenalmente.</p>'],
            ['title' => 'CRN-9 Divulga', 'slug' => 'crn9-divulga', 'content' => '<h3>Hábitos de consumo de alimentos, leitura de rótulos e compras on-line durante a pandemia de COVID-19</h3>
<h3>Utilização das Tecnologias de Informação e Comunicação (TICs) nas diferentes áreas de atuação do nutricionista</h3>
<h3>Pesquisa sobre o perfil dos consumidores de produtos de origem animal no Brasil e sua percepção sobre impacto ambiental, bem-estar, qualidade e saúde</h3>'],
            ['title' => 'Eleições CRN-9 2026/2029', 'slug' => 'eleicoes-crn-9-2026-2029', 'content' => '<p>Está em andamento o processo eleitoral do Conselho Regional de Nutrição da 9ª Região (CRN-9), que definirá a gestão responsável por conduzir as atividades do Conselho no triênio 2026–2029.</p>
<p>Confira as chapas inscritas nas páginas de Material de Campanha, o cronograma do processo eleitoral e as orientações para votação (geração de senha e regularização de situação cadastral).</p>'],
            ['title' => 'Material de Campanha – Chapa 1', 'slug' => 'chapa-1-eleicoes-2026-2029', 'content' => '<p>Materiais de campanha da Chapa 1 – Conectar Nutrição, inscrita no processo eleitoral do CRN-9 para a gestão 2026/2029.</p>'],
            ['title' => 'Material de Campanha – Chapa 2', 'slug' => 'chapa-2-eleicoes-2026-2029', 'content' => '<p>Materiais de campanha da Chapa 2 – Nova Rota, inscrita no processo eleitoral do CRN-9 para a gestão 2026/2029.</p>'],
            ['title' => 'Biblioteca Virtual do CRN-9', 'slug' => 'biblioteca-virtual', 'content' => '<p>Acervo de publicações técnicas, cartilhas, livros e artigos produzidos ou selecionados pelo CRN-9 e por suas Câmaras Técnicas, à disposição da categoria e da sociedade.</p>
<p>Parcerias com instituições como o Fórum Mineiro de Combate aos Agrotóxicos (FMCA) e o IDEC – Instituto de Defesa do Consumidor.</p>'],
            ['title' => 'Denúncia', 'slug' => 'denuncia', 'content' => '<p>O CRN-9 recebe e analisa denúncias contra Nutricionistas e Técnicos em Nutrição e Dietética inscritos neste Regional, contra Pessoas Jurídicas e contra o exercício ilegal da profissão.</p>
<p>Escolha o tipo de denúncia nas páginas específicas: Pessoa Física, Pessoa Jurídica ou Exercício Ilegal da Profissão.</p>'],
            ['title' => 'Denúncia – Pessoa Física', 'slug' => 'denuncia-pessoa-fisica', 'content' => '<p>O CRN-9 recebe e analisa denúncias contra Nutricionistas e Técnicos em Nutrição e Dietética inscritos neste Regional. Caso a apuração resulte na detecção de conduta com indícios de infração disciplinar, são tomadas providências para abertura de Processo Disciplinar, conforme a Resolução CFN nº 705/2021.</p>
<h3>A denúncia ético-disciplinar deverá indicar</h3>
<ul>
<li>Identificação completa do autor da denúncia: nome completo, documento oficial com foto, CPF, endereço, telefone e e-mail;</li>
<li>Descrição circunstanciada e objetiva dos fatos;</li>
<li>Nome, número de inscrição no CRN, qualificação e endereço do denunciado;</li>
<li>Elementos mínimos de prova;</li>
<li>Nome das testemunhas e suas qualificações, quando houver (até 3).</li>
</ul>
<p>O denunciante pode optar pela não divulgação dos seus dados, com sigilo garantido pelo Conselho.</p>'],
            ['title' => 'Denúncia – Pessoa Jurídica', 'slug' => 'denuncia-pessoa-juridica', 'content' => '<p>As denúncias contra Pessoas Jurídicas (empresas) deverão ser realizadas, preferencialmente, por meio do preenchimento do formulário próprio, enviado por correio, e-mail (crn9@crn9.org.br) ou entregue pessoalmente na sede ou nas delegacias do CRN9.</p>
<p>Campos obrigatórios: Razão Social, Endereço Completo e Motivo(s) da denúncia.</p>
<p>Após a apuração dos fatos, o denunciante será informado sobre a ação do Regional. Excepcionalmente serão aceitas denúncias anônimas contra empresas, dada a preocupação do CRN-9 com a saúde da população.</p>'],
            ['title' => 'Denúncia – Exercício Ilegal da Profissão', 'slug' => 'denuncia-exercicio-ilegal', 'content' => '<p>Denúncia contra exercício ilegal da profissão (leigos ou outros profissionais). Deverá conter, preferencialmente: nome completo, profissão, telefone e e-mail do denunciante; descrição circunstanciada do fato; possível legislação transgredida; indícios ou provas dos fatos.</p>
<p>Os atos processuais relativos à apuração de denúncia têm caráter sigiloso. Denúncias acolhidas serão previamente apuradas e, havendo indícios de exercício ilegal, poderão ser encaminhadas ao Ministério Público ou ao Conselho de Classe Profissional competente.</p>'],
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
            ['title' => 'Serviços para Nutricionistas', 'slug' => 'servicos-nutricionistas', 'content' => '<p>Serviços disponíveis para Nutricionistas inscritos no CRN-9: valores e datas da anuidade, inscrição provisória e definitiva, prorrogação e cancelamento de inscrição, baixa temporária, transferência, reativação de inscrição, registro do Título de Especialista e Anotação de Responsabilidade Técnica.</p>
<p>Consulte o serviço desejado e os documentos necessários com a Secretaria do CRN-9.</p>'],
            ['title' => 'Serviços para Técnicos em Nutrição e Dietética', 'slug' => 'servicos-tnd', 'content' => '<p>Serviços disponíveis para Técnicos em Nutrição e Dietética (TND) inscritos no CRN-9: valores e datas da anuidade, inscrição provisória e definitiva (validade de 12 meses), prorrogação e cancelamento de inscrição, baixa temporária, transferência e reativação de inscrição.</p>'],
            ['title' => 'Serviços para Pessoa Jurídica', 'slug' => 'servicos-pessoa-juridica', 'content' => '<p>Serviços disponíveis para empresas e instituições registradas no CRN-9, incluindo o pagamento da Anuidade 2026 Pessoa Jurídica e a emissão de certidões e atestados de responsabilidade técnica.</p>'],
            ['title' => 'Oportunidade de Emprego', 'slug' => 'oportunidade-de-emprego', 'content' => '<p>O CRN-9 divulga, como cortesia, oportunidades de emprego para Nutricionistas e Técnicos em Nutrição e Dietética enviadas por empresas e instituições.</p>
<p>Confira as vagas ativas no <a href="/vagas">Banco de Oportunidades</a> ou cadastre uma nova oportunidade entrando em contato com a Secretaria do CRN-9.</p>'],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page + ['is_published' => true]);
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
                    ['label' => 'Plenário', 'url' => '/paginas/plenario'],
                    ['label' => 'Política de ingresso', 'url' => '/paginas/politica-de-ingresso'],
                    ['label' => 'Concurso público', 'url' => '/paginas/concurso-publico'],
                    ['label' => 'Licitações', 'url' => '/paginas/licitacoes'],
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
                ],
            ],
            [
                'label' => 'Campanhas',
                'children' => [
                    ['label' => 'Pode x Não Pode', 'url' => '/paginas/pode-x-nao-pode'],
                    ['label' => 'Deu ruim ou Tá de boa?', 'url' => '/paginas/deu-ruim-ou-ta-de-boa'],
                    ['label' => 'CRN-9 Divulga', 'url' => '/paginas/crn9-divulga'],
                    ['label' => 'Projetos de lei em andamento', 'url' => '/paginas/projetos-de-lei-em-andamento'],
                    ['label' => 'Biblioteca Virtual do CRN-9', 'url' => '/paginas/biblioteca-virtual'],
                ],
            ],
            [
                'label' => 'Fiscalização',
                'children' => [
                    ['label' => 'Política Nacional de Fiscalização', 'url' => '/paginas/politica-nacional-de-fiscalizacao'],
                    ['label' => 'Equipe de Fiscalização', 'url' => '/fiscalizacao'],
                    ['label' => 'Atividades da Fiscalização', 'url' => '/paginas/atividades-da-fiscalizacao'],
                    ['label' => 'Visitas Técnicas', 'url' => '/paginas/visitas-tecnicas'],
                    ['label' => 'Orientações On-line', 'url' => '/paginas/orientacoes-online'],
                    ['label' => 'Dúvidas frequentes', 'url' => '/paginas/duvidas-frequentes-fiscalizacao'],
                ],
            ],
            [
                'label' => 'Orientação',
                'children' => [
                    ['label' => 'Legislação Regional', 'url' => 'https://crn-mg.implanta.net.br/portaltransparencia/#publico/inicio', 'external' => true],
                    ['label' => 'Legislação Federal', 'url' => 'http://resolucao.cfn.org.br/', 'external' => true],
                    ['label' => 'Links Importantes', 'url' => '/paginas/links-importantes'],
                    ['label' => 'Oportunidade de emprego', 'url' => '/paginas/oportunidade-de-emprego'],
                ],
            ],
            [
                'label' => 'Profissionais',
                'children' => [
                    ['label' => 'Profissionais por Municípios', 'url' => '/profissionais-por-municipio'],
                    ['label' => 'Ouvidoria', 'url' => '/paginas/ouvidoria'],
                    ['label' => 'Contato', 'url' => '/paginas/fale-conosco'],
                    ['label' => 'Convênios', 'url' => '/paginas/convenios'],
                    ['label' => 'Instituições de Ensino', 'url' => '/paginas/instituicoes-de-ensino'],
                    ['label' => 'Eleições CRN-9 2026/2029', 'url' => '/paginas/eleicoes-crn-9-2026-2029'],
                    ['label' => 'Material de Campanha – CHAPA 1', 'url' => '/paginas/chapa-1-eleicoes-2026-2029'],
                    ['label' => 'Material de Campanha – CHAPA 2', 'url' => '/paginas/chapa-2-eleicoes-2026-2029'],
                ],
            ],
        ];

        foreach ($groups as $groupIndex => $group) {
            $parent = MenuItem::updateOrCreate(
                ['label' => $group['label'], 'parent_id' => null],
                ['url' => '#', 'sort_order' => $groupIndex + 1, 'is_external' => false, 'opens_new_tab' => false]
            );

            foreach ($group['children'] as $childIndex => $child) {
                $isExternal = $child['external'] ?? false;

                MenuItem::updateOrCreate(
                    ['label' => $child['label'], 'parent_id' => $parent->id],
                    [
                        'url' => $child['url'],
                        'sort_order' => $childIndex + 1,
                        'is_external' => $isExternal,
                        'opens_new_tab' => $isExternal,
                    ]
                );
            }
        }
    }

    private function seedNews(User $admin): void
    {
        $items = [
            [
                'title' => 'CRN9 divulga cronograma do Processo Eleitoral para a Gestão 2026/2029',
                'category' => 'Institucional',
                'is_featured' => true,
                'excerpt' => 'Confira as datas e etapas do processo eleitoral que definirá a diretoria do CRN-9 para o triênio 2026/2029.',
            ],
            [
                'title' => 'CRN9 publica Aviso de Eleição para a Gestão 2026/2029',
                'category' => 'Institucional',
                'is_featured' => true,
                'excerpt' => 'Publicado o aviso oficial de abertura do processo eleitoral do Conselho para a próxima gestão.',
            ],
            [
                'title' => 'CRN-9 participa do Ganepão e apresenta estudo sobre a atuação do nutricionista em equipes de terapia nutricional',
                'category' => 'Institucional',
                'is_featured' => true,
                'excerpt' => 'Representantes do Conselho levaram estudo técnico a um dos maiores congressos de nutrição clínica do país.',
            ],
            [
                'title' => 'Evento sobre ILPIs traça panorama e aponta caminhos do cuidado nutricional para idosos',
                'category' => 'Eventos',
                'is_featured' => false,
                'excerpt' => 'Encontro reuniu profissionais para discutir o cuidado nutricional em Instituições de Longa Permanência para Idosos.',
            ],
            [
                'title' => 'CRN-9 aborda Alimentação Saudável em Fórum de Agroecologia e Agricultura Orgânica',
                'category' => 'Institucional',
                'is_featured' => false,
                'excerpt' => 'Participação do Conselho reforça o diálogo entre nutrição, agroecologia e segurança alimentar.',
            ],
            [
                'title' => 'Sarcopenia é tema de palestra presencial em Juiz de Fora',
                'category' => 'Eventos',
                'is_featured' => false,
                'excerpt' => 'Palestra gratuita discutiu classificação, diagnóstico e prevenção da sarcopenia em idosos.',
            ],
            [
                'title' => 'Regularize sua situação e participe da eleição 2026/2029 do CRN-9',
                'category' => 'Institucional',
                'is_featured' => false,
                'excerpt' => 'Profissionais inadimplentes têm prazo para regularizar a situação cadastral e votar no pleito.',
            ],
            [
                'title' => 'Mês de conscientização da saúde mental e emocional',
                'category' => 'Campanhas',
                'is_featured' => false,
                'excerpt' => 'CRN-9 reforça a importância do cuidado com a saúde mental dos profissionais de Nutrição.',
            ],
        ];

        foreach ($items as $item) {
            News::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'body' => "<p>{$item['excerpt']}</p><p>Matéria completa disponível no acervo de comunicação do CRN-9. Conteúdo integral a ser complementado pela equipe de comunicação via painel administrativo.</p>",
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
            EventItem::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
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
                .'<rect width="1200" height="400" fill="#5C5E2B"/>'
                .'<text x="50%" y="50%" font-family="sans-serif" font-size="42" fill="#ffffff" text-anchor="middle" dominant-baseline="middle">'
                .'CRN-9 &#183; Banner de campanha</text></svg>'
            );
        }

        $items = [
            ['title' => 'Eleições CRN-9 2026/2029: participe', 'placement' => 'home_hero', 'sort_order' => 1, 'link' => '/paginas/eleicoes-crn-9-2026-2029'],
            ['title' => 'Regularize sua situação e vote nas eleições', 'placement' => 'home_hero', 'sort_order' => 2, 'link' => '/paginas/eleicoes-crn-9-2026-2029'],
            ['title' => 'Denúncias e fiscalização', 'placement' => 'home_secondary', 'sort_order' => 1, 'link' => '/paginas/denuncia'],
            ['title' => 'Perguntas Frequentes', 'placement' => 'home_secondary', 'sort_order' => 2, 'link' => '/paginas/perguntas-frequentes'],
        ];

        foreach ($items as $item) {
            Banner::updateOrCreate(
                ['title' => $item['title']],
                [
                    'title' => $item['title'],
                    'image' => 'banners/placeholder.svg',
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
            ['name' => 'Eliane Azevedo Barros', 'role' => 'Coordenadora da Fiscalização', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => 'CRN9 2130', 'email' => 'coordenacaodafiscalizacao@crn9.org.br'],
            ['name' => 'Jordana dos Santos Jorge Machado', 'role' => 'Supervisora da Fiscalização', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => 'CRN9 2092', 'email' => 'supervisaodafiscalizacao@crn9.org.br'],
            ['name' => 'Débora Barbosa', 'role' => 'Nutricionista Fiscal', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => 'CRN9 5949', 'email' => 'deborabarbosa.fiscal@crn9.org.br'],
            ['name' => 'Gabriela Paim de Alcântara e Silva', 'role' => 'Nutricionista Fiscal', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => 'CRN9 8229', 'email' => 'gabrielafiscal@crn9.org.br'],
            ['name' => 'Geana Paula Aparecida dos Santos', 'role' => 'Nutricionista Fiscal', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => null, 'email' => 'geana.fiscal@crn9.org.br'],
            ['name' => 'Juliana de Oliveira Sales', 'role' => 'Nutricionista Fiscal', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => null, 'email' => 'juliana_fiscal@crn9.org.br'],
            ['name' => 'Karen Priscilla dos Santos', 'role' => 'Assistente Técnico em Nutrição e Dietética', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => 'CRN9 T-2431', 'email' => 'karen.santos@crn9.org.br'],
            ['name' => 'Josiane Magalhães', 'role' => 'Assistente Técnico em Nutrição e Dietética', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => null, 'email' => 'josiane.magalhaes@crn9.org.br'],
            ['name' => 'Arlete Rodrigues', 'role' => 'Assistente Técnico em Nutrição e Dietética', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => null, 'email' => 'arlete.rodrigues@crn9.org.br'],
            ['name' => 'Israel Soares', 'role' => 'Assistente Administrativo', 'region' => 'Sede (Belo Horizonte)', 'registration_number' => null, 'email' => 'israel.soares@crn9.org.br'],
            ['name' => 'Marcela Rodrigues Viveiros', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Ipatinga', 'registration_number' => 'CRN9 21809', 'email' => 'marcela.fiscal@crn9.org.br'],
            ['name' => 'Nicelle Julia Corrêa Lopes', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Juiz de Fora', 'registration_number' => 'CRN9 19118', 'email' => 'nicelle.fiscal@crn9.org.br'],
            ['name' => 'Caroline Caldeira Pereira', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Montes Claros', 'registration_number' => 'CRN9 14249', 'email' => 'carolinefiscal@crn9.org.br'],
            ['name' => 'Flávia Junqueira de Souza Morais', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Pouso Alegre', 'registration_number' => 'CRN9 2168', 'email' => 'flaviafiscal@crn9.org.br'],
            ['name' => 'Silvia Aparecida de Cássia Ferreira Romero', 'role' => 'Assistente Técnico em Nutrição e Dietética', 'region' => 'Delegacia de Pouso Alegre', 'registration_number' => 'CRN9 T-1949', 'email' => 'silvia@crn9.org.br'],
            ['name' => 'Barbara Virginia Caixeta Crepaldi', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Uberlândia', 'registration_number' => null, 'email' => null],
            ['name' => 'Nilda Pereira de Melo Zumpano', 'role' => 'Assistente Técnico em Nutrição e Dietética', 'region' => 'Delegacia de Uberlândia', 'registration_number' => 'CRN9 2671-T', 'email' => 'nilda.zumpano@crn9.org.br'],
            ['name' => 'Pâmela Cristina de Andrade', 'role' => 'Nutricionista Fiscal', 'region' => 'Delegacia de Uberlândia', 'registration_number' => null, 'email' => 'pamela.fiscal@crn9.org.br'],
            ['name' => 'Andresa Carolina da Silva Costa', 'role' => 'Nutricionista Fiscal', 'region' => 'Barbacena', 'registration_number' => 'CRN9 23119', 'email' => null],
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
            MunicipalityProfessionalCount::updateOrCreate(
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
