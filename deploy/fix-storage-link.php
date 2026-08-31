<?php
/**
 * Script avulso de uso único: cria o link de storage no document root
 * correto quando o deploy.php já rodou (na Rota B) mas as imagens
 * enviadas pelo painel (banners, notícias etc.) continuam dando 404.
 * NÃO mexe no banco de dados — só cria o link.
 *
 * ONDE COLOCAR: na MESMA pasta onde está o index.php final do site
 * (o document root — public_html/ na Rota B).
 *
 * COMO USAR:
 *   1. Acesse: https://seudominio.com.br/fix-storage-link.php?token=SEU_DEPLOY_SECRET
 *      (o mesmo DEPLOY_SECRET que você já tem no .env)
 *   2. Confira a saída.
 *   3. APAGUE ESTE ARQUIVO imediatamente após o uso.
 */

// Caminho ABSOLUTO da pasta do projeto (o mesmo $appPath que você usou
// no index.php e no deploy.php). Ex.: '/home/SEUUSUARIO/crn9-app';
$appPath = dirname(__DIR__);

require $appPath.'/vendor/autoload.php';

$app = require_once $appPath.'/bootstrap/app.php';
/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/plain; charset=utf-8');

$expected = env('DEPLOY_SECRET');
$given = $_GET['token'] ?? '';

if (! $expected || ! hash_equals((string) $expected, (string) $given)) {
    http_response_code(403);
    echo "Acesso negado. Confirme se DEPLOY_SECRET está definido no .env e se o token na URL está correto.\n";
    exit;
}

echo "=== Link de storage (document root) ===\n";
$publicLink = __DIR__.'/storage';
$publicTarget = $appPath.'/storage/app/public';

if (file_exists($publicLink) || is_link($publicLink)) {
    echo "Já existe algo em {$publicLink}, nada foi alterado.\n[OK]\n";
} elseif (@symlink($publicTarget, $publicLink)) {
    echo "Criado em {$publicLink}, apontando para {$publicTarget}\n[OK]\n";
} else {
    echo "Não foi possível criar automaticamente (a função symlink() pode estar desabilitada neste servidor). Copie manualmente o conteúdo de {$publicTarget} para uma pasta 'storage' dentro de public_html/.\n[FALHOU]\n";
}

echo "\nConcluído. APAGUE este arquivo (fix-storage-link.php) do servidor agora.\n";
