<?php

namespace App\Http\Controllers;

class HardwareController extends Controller
{
    // Categorias reais de produtos de informática comercializados pela Databit
    // (databit.com.br/produtos/). Diferente dos Sistemas (software), aqui a
    // Databit apoia a escolha e a compra de equipamentos — por isso a página
    // é uma vitrine consultiva, sem cadastro individual por item no painel.
    public const CATEGORIES = [
        ['name' => 'Notebooks', 'icon' => 'heroicon-o-computer-desktop', 'description' => 'Equipamentos para o dia a dia da equipe, com configuração dimensionada para cada perfil de uso.'],
        ['name' => 'Computadores Desktop', 'icon' => 'heroicon-o-cpu-chip', 'description' => 'Estações de trabalho para escritório, operação e produção, com garantia e suporte especializado.'],
        ['name' => 'Servidores', 'icon' => 'heroicon-o-server-stack', 'description' => 'Servidores dimensionados para hospedar sistemas, bancos de dados e arquivos da sua operação.'],
        ['name' => 'Periféricos', 'icon' => 'heroicon-o-printer', 'description' => 'Impressoras, leitores, monitores e demais periféricos para equipar a sua empresa.'],
        ['name' => 'Celulares', 'icon' => 'heroicon-o-device-phone-mobile', 'description' => 'Smartphones corporativos prontos para uso com o DataMobile e demais sistemas Databit.'],
        ['name' => 'Firewall', 'icon' => 'heroicon-o-shield-check', 'description' => 'Equipamentos de segurança de perímetro para proteger a rede da sua empresa.'],
        ['name' => 'Soluções de Wi-Fi', 'icon' => 'heroicon-o-wifi', 'description' => 'Projetos de rede sem fio corporativa, com cobertura e desempenho para toda a operação.'],
        ['name' => 'Nobreak', 'icon' => 'heroicon-o-bolt', 'description' => 'Equipamentos de energia ininterrupta para proteger servidores e estações de trabalho.'],
        ['name' => 'Soluções de Monitoramento CFTV', 'icon' => 'heroicon-o-video-camera', 'description' => 'Câmeras e sistemas de monitoramento para a segurança do seu negócio.'],
    ];

    public function __invoke()
    {
        return view('hardware.index', ['categories' => self::CATEGORIES]);
    }
}
