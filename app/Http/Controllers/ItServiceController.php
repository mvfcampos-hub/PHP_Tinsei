<?php

namespace App\Http\Controllers;

class ItServiceController extends Controller
{
    // Serviços de TI em destaque na vitrine (databit.com.br/servicos-ti/):
    // Databit MSP é exibido como banner principal na view; os demais aparecem
    // nesta grade, cada um levando à sua própria página, a um addon do MSP
    // ou ao WhatsApp.
    public const SERVICES = [
        ['name' => 'DataGateway+', 'icon' => 'heroicon-o-globe-alt', 'description' => 'Equipamento em comodato e gestão completa de rede: NAT, VPN, controle de conteúdo, análise de vulnerabilidades, monitoramento 24/7 e failover.', 'route' => 'datagateway.show'],
        ['name' => 'DataSecurity+', 'icon' => 'heroicon-o-shield-check', 'description' => 'Camada avançada de proteção: EDR, anti-phishing, MFA gerenciado, cofre de senhas e treinamento de conscientização.', 'anchor' => 'addon-datasecurity'],
        ['name' => 'DataBackup+', 'icon' => 'heroicon-o-cloud-arrow-up', 'description' => 'App e espaço em nuvem para backup de VMs, bancos de dados, Microsoft 365 e servidores físicos, com suporte especializado.', 'route' => 'databackup.show'],
        ['name' => 'Consultoria e Projetos de TI', 'icon' => 'heroicon-o-light-bulb', 'description' => 'Soluções especializadas para reestruturação, migração e segurança da infraestrutura tecnológica da sua empresa.', 'anchor' => null],
    ];

    public function __invoke()
    {
        return view('it-services.show', ['services' => self::SERVICES]);
    }
}
