<?php

namespace App\Http\Controllers;

class ItServiceController extends Controller
{
    // Serviços reais de TI oferecidos pela Databit (databit.com.br/servicos-ti/).
    // Assim como o hardware, é uma vitrine consultiva sem cadastro individual
    // por item no painel — o diferencial aqui é o modelo de contratação.
    public const SERVICES = [
        ['name' => 'Serviços Avulsos', 'icon' => 'heroicon-o-wrench', 'description' => 'Atendimentos pontuais para resolver demandas específicas de tecnologia, conforme a necessidade do cliente.'],
        ['name' => 'Contratos por Hora', 'icon' => 'heroicon-o-clock', 'description' => 'Franquia mensal de horas com flexibilidade de valores para empresas de diferentes portes.'],
        ['name' => 'Profissionais Especializados (Outsourcing)', 'icon' => 'heroicon-o-user-group', 'description' => 'Equipe dedicada para administração computacional, suporte HelpDesk e gerenciamento de servidores, com cumprimento de SLA.'],
        ['name' => 'Databit MSP — Serviços Gerenciados', 'icon' => 'heroicon-o-document-text', 'description' => 'Nosso principal modelo: mensalidade fixa para a administração completa do seu ambiente tecnológico.'],
        ['name' => 'Consultoria e Projetos de TI', 'icon' => 'heroicon-o-light-bulb', 'description' => 'Soluções especializadas para reestruturação e segurança da infraestrutura tecnológica.'],
        ['name' => 'Monitoramento de Redes, Servidores e Serviços', 'icon' => 'heroicon-o-signal', 'description' => 'Acompanhamento em tempo real para identificar problemas, prevenir falhas e otimizar recursos.'],
        ['name' => 'Monitoramento de Estação de Trabalho', 'icon' => 'heroicon-o-eye', 'description' => 'Supervisão de produtividade, segurança da informação e identificação de ameaças cibernéticas.'],
        ['name' => 'Migração para Microsoft 365', 'icon' => 'heroicon-o-envelope', 'description' => 'Hospedagem e gerenciamento de e-mails corporativos, com segurança e colaboração integrada.'],
        ['name' => 'Collocation', 'icon' => 'heroicon-o-cloud', 'description' => 'Máquinas virtuais (Windows/Linux) e serviços de backup em nuvem.'],
    ];

    public function __invoke()
    {
        return view('it-services.show', ['services' => self::SERVICES]);
    }
}
