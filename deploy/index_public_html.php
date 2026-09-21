<?php
/**
 * Variante do public/index.php para quando NÃO é possível apontar o
 * "Document Root" do domínio direto para a pasta public/ do projeto
 * (comum em planos compartilhados básicos da Hostgator).
 *
 * COMO USAR:
 *   1. Envie o projeto inteiro (exceto o conteúdo da pasta public/) para
 *      uma pasta FORA do public_html, ex.: /home/SEUUSUARIO/crn9-app
 *   2. Copie o CONTEÚDO de crn9-app/public/ (o .htaccess, o
 *      build/, e o index.php original) para dentro de public_html/
 *   3. Substitua o public_html/index.php pelo conteúdo deste arquivo,
 *      ajustando o valor de $appPath abaixo para o caminho real da
 *      pasta que você criou no passo 1.
 */

use Illuminate\Http\Request;

// Caminho ABSOLUTO da pasta do projeto (fora do public_html). Ajuste aqui:
$appPath = '/home/SEUUSUARIO/crn9-app';

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = $appPath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appPath.'/vendor/autoload.php';

(require_once $appPath.'/bootstrap/app.php')
    ->handleRequest(Request::capture());
