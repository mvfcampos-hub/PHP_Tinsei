<?php
/**
 * Script de ATUALIZAÇÃO para hospedagem compartilhada sem SSH — use este
 * (e não o deploy.php) sempre que o site já estiver no ar com dados reais
 * e você só quiser subir novidades de código/conteúdo institucional.
 *
 * Diferença importante em relação ao deploy.php:
 *   - deploy.php roda "migrate:fresh", que APAGA todas as tabelas antes de
 *     recriar. Serve só para o primeiro deploy, com o banco ainda vazio.
 *   - update.php roda "migrate" (sem --fresh), que só aplica as migrations
 *     novas, preservando notícias, eventos, denúncias e tudo que já foi
 *     cadastrado. O "db:seed" deste projeto usa updateOrCreate em todas as
 *     tabelas que ele controla, então também é seguro rodar de novo: ele
 *     atualiza o conteúdo institucional (páginas, menu, etc.) para bater
 *     com a versão nova do código, sem duplicar nem apagar o que foi
 *     cadastrado manualmente pelo painel.
 *
 * COMO USAR:
 *   1. Suba os arquivos atualizados do projeto (veja
 *      DEPLOY_HOSTGATOR.md, seção "Como atualizar o site depois").
 *   2. Envie este arquivo para a MESMA pasta onde está o deploy.php
 *      original (o document root do site).
 *   3. Ajuste o $appPath abaixo do mesmo jeito que foi ajustado no
 *      deploy.php, se você estiver na Rota B.
 *   4. Acesse: https://seudominio.com.br/update.php?token=SEU_DEPLOY_SECRET
 *   5. Confira a saída de cada comando.
 *   6. APAGUE ESTE ARQUIVO imediatamente após o uso.
 */

// Mesma lógica do deploy.php — veja os comentários lá se tiver dúvida.
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

function run(string $label, string $command, array $parameters = []): void
{
    echo "\n=== {$label} ===\n";

    $exitCode = Illuminate\Support\Facades\Artisan::call($command, $parameters);
    echo Illuminate\Support\Facades\Artisan::output();
    echo $exitCode === 0 ? "[OK]\n" : "[FALHOU - código {$exitCode}]\n";
}

echo "Iniciando atualização...\n";

// Sem --fresh: só aplica migrations novas, preservando os dados existentes.
run('Rodando migrations novas', 'migrate', ['--force' => true]);

// Seguro rodar de novo: toda a seed usa updateOrCreate, então isso
// atualiza páginas/menu/etc. para a versão nova do código sem duplicar
// nem apagar dados cadastrados manualmente pelo painel.
run('Atualizando conteúdo institucional (db:seed)', 'db:seed', ['--force' => true]);

run('Limpando caches', 'optimize:clear');

echo "\n=== Link de storage (document root) ===\n";
$publicLink = __DIR__.'/storage';
$publicTarget = $appPath.'/storage/app/public';
if (file_exists($publicLink) || is_link($publicLink)) {
    echo "Já existe, pulando.\n[OK]\n";
} elseif (@symlink($publicTarget, $publicLink)) {
    echo "Criado em {$publicLink}\n[OK]\n";
} else {
    echo "Não foi possível criar automaticamente (a função symlink() pode estar desabilitada neste servidor).\n[AVISO]\n";
}

echo "\nAtualização concluída. Confira o site e, em seguida, APAGUE este arquivo (update.php) do servidor.\n";
