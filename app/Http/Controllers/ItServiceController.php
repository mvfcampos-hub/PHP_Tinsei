<?php

namespace App\Http\Controllers;

class ItServiceController extends Controller
{
    // Serviços de TI em destaque na vitrine (databit.com.br/servicos-ti/):
    // Databit MSP é exibido como banner principal na view; os demais aparecem
    // nesta grade, cada um levando ao respectivo addon do MSP ou ao WhatsApp.
    public const SERVICES = [
        ['name' => 'DataGateway+', 'icon' => 'heroicon-o-globe-alt', 'description' => 'Gestão avançada de rede e segurança de perímetro: firewall gerenciado, VPN, load balancing e autenticação RADIUS.', 'anchor' => 'addon-datagateway'],
        ['name' => 'DataSecurity+', 'icon' => 'heroicon-o-shield-check', 'description' => 'Camada avançada de proteção: EDR, anti-phishing, MFA gerenciado, cofre de senhas e treinamento de conscientização.', 'anchor' => 'addon-datasecurity'],
        ['name' => 'DataBackup+', 'icon' => 'heroicon-o-cloud-arrow-up', 'description' => 'Gestão completa de backup local e em nuvem, com testes de restauração e plano de recuperação de desastres.', 'anchor' => 'addon-databackup'],
        ['name' => 'Consultoria e Projetos de TI', 'icon' => 'heroicon-o-light-bulb', 'description' => 'Soluções especializadas para reestruturação, migração e segurança da infraestrutura tecnológica da sua empresa.', 'anchor' => null],
    ];

    public function __invoke()
    {
        return view('it-services.show', ['services' => self::SERVICES]);
    }
}
