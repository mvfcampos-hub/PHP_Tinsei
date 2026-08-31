<?php
/**
 * Script de deploy de uso único para hospedagem compartilhada sem SSH.
 *
 * ONDE COLOCAR: na MESMA pasta do index.php final do site (a pasta que o
 * domínio realmente serve — veja DEPLOY_HOSTGATOR.md para saber qual é).
 *
 * COMO USAR:
 *   1. Defina DEPLOY_SECRET no seu .env (uma string longa e aleatória).
 *   2. Acesse: https://seudominio.com.br/deploy.php?token=SEU_DEPLOY_SECRET
 *   3. Confira a saída de cada comando.
 *   4. APAGUE ESTE ARQUIVO imediatamente após o uso — ele nunca deve
 *      ficar publicado permanentemente.
 */

// Caminho ABSOLUTO da pasta do projeto (onde estão vendor/ e bootstrap/).
// - Rota A (Document Root aponta direto para public/): não precisa mexer,
//   dirname(__DIR__) já resolve certo, pois deploy.php fica dentro de public/.
// - Rota B (arquivos copiados para public_html/, deploy.php também foi
//   parar lá): troque a linha abaixo pelo caminho real do projeto, o
//   mesmo que você usou no $appPath de public_html/index.php. Ex.:
//   $appPath = '/home/SEUUSUARIO/crn9-app';
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

echo "Iniciando deploy...\n";

if (empty(config('app.key'))) {
    run('Gerando APP_KEY', 'key:generate', ['--force' => true]);
} else {
    echo "\n=== APP_KEY ===\nJá definida, pulando.\n";
}

// migrate:fresh (em vez de migrate) porque este script é de uso único
// para o PRIMEIRO deploy: se uma tentativa anterior tiver travado no meio
// do caminho, pode ter deixado tabelas criadas sem registrar isso no
// Laravel, causando erro de "tabela já existe". fresh derruba tudo e
// recria do zero — seguro aqui pois o banco ainda não tem conteúdo real.
// NUNCA rode este script contra um site já em produção com dados reais.
run('Rodando migrations (fresh)', 'migrate:fresh', ['--force' => true]);

// Comente a linha abaixo se NÃO quiser popular o banco com o conteúdo
// institucional já preparado (notícias, páginas, FAQ, etc.).
run('Populando conteúdo institucional (db:seed)', 'db:seed', ['--force' => true]);

run('Criando link de storage público', 'storage:link');

echo "\nDeploy concluído. Confira o site e, em seguida, APAGUE este arquivo (deploy.php) do servidor.\n";
