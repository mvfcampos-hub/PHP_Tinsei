<?php

namespace App\Http\Controllers;

class MspController extends Controller
{
    // Modelo de Serviços Gerenciados (MSP) da Databit — o principal modelo de
    // contratação de TI da empresa (mensalidade fixa, gestão completa do
    // ambiente). Conteúdo consultivo, sem cadastro individual no painel,
    // seguindo o mesmo padrão de HardwareController/ItServiceController.
    public const WORKSTATION_PRICING = [
        ['range' => '4 a 10', 'price' => 119.00],
        ['range' => '11 a 20', 'price' => 109.00],
        ['range' => '21 a 30', 'price' => 98.00],
        ['range' => 'Acima de 30', 'price' => 89.00],
    ];

    public const SERVER_PRICE = 250.00;

    public const MINIMUM_CONTRACT = 1390.00;

    public const INCLUDED = [
        [
            'title' => '1. Service Desk (Suporte ao Usuário)',
            'icon' => 'heroicon-o-lifebuoy',
            'items' => [
                'Suporte remoto ilimitado em horário comercial',
                'Sistema de tickets com SLA definido (abertura via WhatsApp ou e-mail)',
                'Atendimento presencial quando necessário (até 2 visitas/mês incluídas; visitas adicionais cobradas como hora técnica)',
                'Suporte a sistemas operacionais, aplicativos de escritório, e-mail, impressão',
                'Orientação e apoio ao usuário no dia a dia',
            ],
            'note' => 'Política de uso justo: o suporte remoto ilimitado é oferecido dentro de um padrão razoável de utilização. Ambientes com volume de chamados consistentemente acima da média serão avaliados em conjunto com o cliente para adequação do contrato.',
        ],
        [
            'title' => '2. Monitoramento (RMM)',
            'icon' => 'heroicon-o-signal',
            'items' => [
                'Monitoramento automatizado 24/7 de todas as workstations e servidores',
                'Alertas automáticos de saúde: CPU, memória, disco, temperatura',
                'Identificação e correção proativa de problemas antes que afetem o usuário',
                'Resposta a alertas críticos em horário comercial; fora do horário, conforme SLA emergencial',
            ],
        ],
        [
            'title' => '3. Segurança (Base)',
            'icon' => 'heroicon-o-shield-check',
            'items' => [
                'Antivírus gerenciado em todas as estações e servidores',
                'Hardening de estações — políticas de segurança, restrição de instalações não autorizadas',
                'Gestão de acessos — políticas de senha e recomendação de boas práticas de autenticação',
            ],
            'note' => 'Proteções avançadas de segurança (EDR, proteção de e-mail, MFA gerenciado, treinamento de conscientização) estão disponíveis como add-ons no pacote Databit Security+.',
        ],
        [
            'title' => '4. Gestão de Rede',
            'icon' => 'heroicon-o-wifi',
            'items' => [
                'Configuração e manutenção da rede',
                'Segregação de rede: separação entre rede corporativa, servidores e convidados (guest), com bloqueio de acesso a portas de gerenciamento (SSH, RDP etc.) entre segmentos',
                'Wi-Fi: configuração, segurança e otimização das redes sem fio',
                'Monitoramento de rede: disponibilidade de link, equipamentos e alertas de queda (via ferramenta de monitoramento remoto)',
            ],
            'note' => 'O serviço contempla configuração e monitoramento dos equipamentos de rede existentes do cliente (roteadores, switches, access points). Fornecimento de hardware não está incluído.',
        ],
        [
            'title' => '5. Gestão de Patches e Atualizações',
            'icon' => 'heroicon-o-arrow-path',
            'items' => [
                'Atualizações de sistema operacional (Windows Update) gerenciadas e programadas',
                'Atualização de drivers e firmwares',
                'Atualização de aplicativos críticos (navegadores, leitores de PDF, pacote Office)',
                'Política de patches com janela de manutenção para evitar impacto no horário de trabalho',
            ],
        ],
        [
            'title' => '6. Inventário e Gestão de Ativos',
            'icon' => 'heroicon-o-clipboard-document-list',
            'items' => [
                'Inventário completo e atualizado de todo o parque (hardware + software)',
                'Relatório de software instalado por estação (a responsabilidade pelo licenciamento é do cliente)',
                'Gestão do ciclo de vida dos equipamentos (quando trocar, quando fazer upgrade)',
            ],
        ],
        [
            'title' => '7. Onboarding e Offboarding de Colaboradores',
            'icon' => 'heroicon-o-user-plus',
            'items' => [
                'Entrada: preparação da estação de trabalho, criação de contas (e-mail, sistemas, acessos), configuração de perfil',
                'Saída: revogação de todos os acessos, devolução/reatribuição de equipamento',
                'Checklist padronizado para garantir que nada seja esquecido',
            ],
        ],
        [
            'title' => '8. Documentação',
            'icon' => 'heroicon-o-document-text',
            'items' => [
                'Documentação completa do ambiente de TI do cliente',
                'Diagramas de rede atualizados',
                'Procedimentos operacionais documentados',
            ],
        ],
        [
            'title' => '9. Consultoria e Planejamento (vCIO)',
            'icon' => 'heroicon-o-light-bulb',
            'items' => [
                'Reunião de revisão tecnológica trimestral',
                'Orientação para compra de equipamentos e software',
                'Recomendações de investimento e evolução do ambiente',
                'Análise de riscos e sugestões de melhoria',
                'Planejamento de orçamento de TI (CAPEX/OPEX)',
            ],
        ],
        [
            'title' => '10. Relatórios e Transparência',
            'icon' => 'heroicon-o-chart-bar',
            'items' => [
                'Relatório mensal executivo: chamados atendidos, incidentes, ações preventivas, saúde do ambiente',
                'KPIs de TI: tempo médio de atendimento, tickets resolvidos, uptime dos serviços',
            ],
        ],
    ];

    public const SLA = [
        ['priority' => 'Crítica', 'description' => 'Sistema parado, empresa sem operar', 'response' => '30 minutos', 'resolution' => '4 horas'],
        ['priority' => 'Alta', 'description' => 'Degradação severa, múltiplos usuários afetados', 'response' => '1 hora', 'resolution' => '8 horas'],
        ['priority' => 'Média', 'description' => 'Um usuário afetado, com alternativa disponível', 'response' => '2 horas', 'resolution' => '24 horas'],
        ['priority' => 'Baixa', 'description' => 'Dúvida, solicitação, melhoria', 'response' => '4 horas', 'resolution' => '48 horas'],
    ];

    public const NOT_INCLUDED = [
        'Armazenamento de backup em nuvem (cobrado por consumo)',
        'Compra de hardware e licenças de software (orientamos, cliente adquire)',
        'Projetos de infraestrutura (migração de servidor, reestruturação de rede, mudança de escritório)',
        'Implantação de sistemas novos (ERP, CRM etc.)',
        'Desenvolvimento de software',
        'Câmeras de segurança (CFTV)',
        'Telefonia (PABX/VoIP) — pode ser incluído como adicional',
        'Impressoras e multifuncionais — pode ser incluído como adicional',
        'Atendimento fora do horário comercial (cobrado como hora extra)',
    ];

    public const ADDONS = [
        [
            'name' => 'Databit Security+',
            'tagline' => 'Camada avançada de segurança, cobrada por usuário/mês',
            'icon' => 'heroicon-o-shield-check',
            'items' => [
                ['name' => 'EDR (Endpoint Detection & Response)', 'description' => 'Proteção avançada contra ameaças, resposta automatizada a incidentes'],
                ['name' => 'Proteção de e-mail', 'description' => 'Anti-spam, anti-phishing, anti-malware para caixas de e-mail'],
                ['name' => 'MFA gerenciado', 'description' => 'Implantação e gestão contínua de autenticação multifator'],
                ['name' => 'Treinamento de conscientização', 'description' => 'Campanhas periódicas de segurança e simulação de phishing'],
                ['name' => 'Cofre de senhas corporativo', 'description' => 'Gestão segura e centralizada de credenciais'],
            ],
        ],
        [
            'name' => 'Databit Gateway+',
            'tagline' => 'Gestão avançada de rede e segurança de perímetro',
            'icon' => 'heroicon-o-globe-alt',
            'items' => [
                ['name' => 'Firewall gerenciado', 'description' => 'Configuração completa de regras, inspeção de tráfego, atualizações de firmware e monitoramento contínuo'],
                ['name' => 'Load balancing e failover avançado', 'description' => 'Balanceamento inteligente entre múltiplos links com políticas de tráfego'],
                ['name' => 'Autenticação RADIUS', 'description' => 'Controle de acesso à rede com autenticação centralizada (802.1X)'],
                ['name' => 'VPN site-to-site e client-to-site', 'description' => 'Túneis seguros entre filiais e acessos remotos com políticas granulares'],
                ['name' => 'Configuração avançada de rede', 'description' => 'VLANs complexas, QoS, políticas de roteamento avançado'],
            ],
            'note' => 'Precificação sob consulta — varia conforme complexidade do ambiente, número de sites e equipamento utilizado. Premissa: cliente possui o equipamento (Mikrotik, Fortigate ou similar).',
        ],
        [
            'name' => 'Databit Backup+',
            'tagline' => 'Gestão completa de backup, cobrada por servidor/volume + consumo de nuvem',
            'icon' => 'heroicon-o-cloud-arrow-up',
            'items' => [
                ['name' => 'Backup diário automatizado', 'description' => 'Servidores e dados críticos'],
                ['name' => 'Backup local + nuvem', 'description' => 'Armazenamento em nuvem cobrado conforme consumo'],
                ['name' => 'Testes de restauração', 'description' => 'Testes periódicos com relatório documentado'],
                ['name' => 'Plano de recuperação de desastres', 'description' => 'Documentação e procedimento de DR'],
            ],
        ],
    ];

    public const SUMMARY_INCLUDED = [
        'Suporte ilimitado (remoto + presencial)',
        'Monitoramento automatizado 24/7',
        'Antivírus gerenciado em todas as máquinas',
        'Rede gerenciada (configuração, segmentação e monitoramento)',
        'Atualizações e patches gerenciados',
        'Inventário completo do parque',
        'Onboarding/offboarding de colaboradores',
        'Documentação do ambiente',
        'Consultoria estratégica trimestral',
        'Relatório mensal de tudo que foi feito',
        'Previsibilidade total de custo',
    ];

    public const CERTIFICATIONS = [
        ['area' => 'Gestão de serviços', 'detail' => 'ITIL (boas práticas de gestão de serviços de TI)'],
        ['area' => 'Produtividade e nuvem', 'detail' => 'Microsoft 365 — administração, migração e suporte'],
        ['area' => 'Servidores Windows', 'detail' => 'Windows Server, Active Directory, GPO, DNS, DHCP, File Server'],
        ['area' => 'Virtualização', 'detail' => 'VMware (ESXi/vSphere), Proxmox — ambientes on-premise e híbridos'],
        ['area' => 'Servidores Linux', 'detail' => 'Administração de servidores Linux em produção'],
        ['area' => 'Redes', 'detail' => 'Mikrotik (MTCNA, MTCRE) — roteamento, firewall, VPN, RADIUS'],
        ['area' => 'Segurança de perímetro', 'detail' => 'Fortigate — configuração e gestão de firewalls FortiOS'],
        ['area' => 'Segurança de endpoint', 'detail' => 'Bitdefender GravityZone — antivírus e EDR gerenciado'],
        ['area' => 'Backup e recuperação', 'detail' => 'Acronis Cyber Protect — backup, disaster recovery'],
        ['area' => 'Performance e segurança web', 'detail' => 'Cloudflare — DNS, WAF, CDN, Zero Trust'],
    ];

    public const COMPARISON = [
        ['feature' => 'Abordagem', 'msp' => 'Proativa. Resolvemos antes de quebrar (monitoramento 24/7).', 'ondemand' => 'Reativa. Só age quando o problema já aconteceu.', 'inhouse' => 'Mista. Geralmente sobrecarregada apagando incêndios.'],
        ['feature' => 'Previsibilidade', 'msp' => 'Alta. Mensalidade fixa, sem surpresas.', 'ondemand' => 'Baixa. Meses baratos, meses com rombos no orçamento.', 'inhouse' => 'Média. Salário fixo, mas a empresa precisa comprar ferramentas por fora.'],
        ['feature' => 'Indisponibilidade', 'msp' => 'Mínima. Monitoramento evita falhas; SLA garante rapidez.', 'ondemand' => 'Alta. Depende da agenda do técnico avulso.', 'inhouse' => 'Média. Depende da disponibilidade de uma única pessoa.'],
        ['feature' => 'Conhecimento', 'msp' => 'Equipe multidisciplinar, com especialistas em cada área.', 'ondemand' => 'Limitado. Depende do conhecimento de um único profissional.', 'inhouse' => 'Generalista. Um profissional dificilmente é especialista em tudo.'],
        ['feature' => 'Ferramentas', 'msp' => 'Inclusas. Antivírus, RMM, sistema de tickets.', 'ondemand' => 'Inexistentes. O ambiente fica desprotegido entre atendimentos.', 'inhouse' => 'Custo extra. A empresa precisa comprar as licenças separadamente.'],
        ['feature' => 'Disponibilidade', 'msp' => 'Contínua. Equipe não tira férias ao mesmo tempo.', 'ondemand' => 'Imprevisível, sob agenda.', 'inhouse' => 'Ponto único de falha. Férias e afastamentos afetam a empresa.'],
        ['feature' => 'Estratégia', 'msp' => 'Sim (vCIO). Reuniões trimestrais para planejar o futuro.', 'ondemand' => 'Não. Foco exclusivo no conserto do dia a dia.', 'inhouse' => 'Rara. Focada na operação diária.'],
    ];

    public function __invoke()
    {
        return view('msp.show', [
            'workstationPricing' => self::WORKSTATION_PRICING,
            'serverPrice' => self::SERVER_PRICE,
            'minimumContract' => self::MINIMUM_CONTRACT,
            'included' => self::INCLUDED,
            'sla' => self::SLA,
            'notIncluded' => self::NOT_INCLUDED,
            'addons' => self::ADDONS,
            'summaryIncluded' => self::SUMMARY_INCLUDED,
            'certifications' => self::CERTIFICATIONS,
            'comparison' => self::COMPARISON,
        ]);
    }
}
