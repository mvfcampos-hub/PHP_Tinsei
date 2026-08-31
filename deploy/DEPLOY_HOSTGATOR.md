# Publicar o site do CRN-9 na Hostgator (hospedagem compartilhada, sem SSH)

Roteiro específico para o seu ambiente confirmado: plano **M_100**, cPanel
134, Apache 2.4.68, MySQL 5.7.44, sem acesso a Terminal/SSH.

Como não há SSH, os comandos do Laravel (`migrate`, `key:generate`, etc.)
são rodados uma única vez através do navegador, usando o script
`deploy.php` incluído nesta pasta.

---

## 1. Confirmar a versão do PHP

No cPanel, procure **"MultiPHP Manager"** (ou "Selecionar Versão do PHP").
Selecione **PHP 8.2 ou superior** para o domínio. Depois, na aba de
extensões desse mesmo painel (ícone de engrenagem/"Options"), confirme que
estão **habilitadas**: `mbstring`, `openssl`, `pdo_mysql`, `curl`, `zip`,
`xml`, `bcmath`, `fileinfo`, `gd`. Essas já vêm ativas na maioria dos
planos, mas vale conferir.

## 2. Criar o banco de dados MySQL

cPanel → **"MySQL® Databases"**:

1. Crie um banco (ex.: `usuario_crn9`).
2. Crie um usuário com senha forte.
3. Associe o usuário ao banco com **todos os privilégios**.
4. Anote nome do banco, usuário e senha — você vai usá-los no `.env`.

## 3. Build local (sua máquina, não no servidor)

No projeto, rode:

```bash
npm ci
npm run build
composer install --no-dev --optimize-autoloader
```

Isso gera as pastas `public/build/` e `vendor/`, que também serão
enviadas ao servidor (não são geradas lá, já que não há Composer/Node no
plano compartilhado).

## 4. Preparar o `.env`

Copie `deploy/.env.production.example` para `.env` na raiz do projeto e
preencha:

- `APP_URL` com o domínio real
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` do passo 2
- `DEPLOY_SECRET` com um valor aleatório só seu — gere um com:
  ```bash
  php -r "echo bin2hex(random_bytes(24));"
  ```

Deixe `APP_KEY` em branco — o `deploy.php` gera automaticamente.

## 5. Enviar os arquivos (FTP ou Gerenciador de Arquivos)

Envie **todo o projeto** — incluindo `vendor/` e `public/build/`, exceto
`.git` e `node_modules` — para uma pasta **fora** do `public_html`, por
exemplo `/home/SEUUSUARIO/crn9-app`.

## 6. Resolver o "Document Root" (a parte que costuma travar)

O Laravel espera servir só a pasta `public/`; o domínio da Hostgator
aponta para `public_html`. Verifique primeiro se dá para evitar o passo
manual:

**Opção A — se o cPanel permitir mudar o Document Root do domínio**
(cPanel → "Domínios"): aponte para `/home/SEUUSUARIO/crn9-app/public`.
Pronto, pule para o passo 7 — não precisa mexer em `public_html`.

**Opção B — se não permitir (comum no M_100):**

1. Copie **todo o conteúdo** de `crn9-app/public/` para dentro de
   `public_html/` — isso inclui `index.php`, `.htaccess`, a pasta
   `build/`, e também `images/`, `css/`, `js/`, `favicon.ico` e
   `robots.txt`. Não copie a pasta/link `storage` (o passo 7 cuida
   disso). É fácil esquecer `images/`, `css/` e `js/` porque não
   aparecem em destaque — se esquecer, o logo e outras imagens fixas do
   site não aparecem.
2. Substitua o `public_html/index.php` pelo conteúdo de
   `deploy/index_public_html.php` (já incluído nesta pasta), ajustando a
   variável `$appPath` no topo para o caminho real do passo 5.
3. Confirme que `public_html/.htaccess` foi copiado (ele existe no
   `public/` original do Laravel e cuida do roteamento).

## 7. Rodar o deploy

1. Envie `deploy/deploy.php` para a **mesma pasta** que ficou com o
   `index.php` final (ou seja, o document root do site — `public_html/`
   na Opção B, ou `crn9-app/public/` na Opção A).
   - **Se você seguiu a Opção B**, abra o `deploy.php` que acabou de
     enviar e ajuste a linha `$appPath = dirname(__DIR__);` para o
     caminho absoluto real do projeto — o mesmo valor que você usou no
     `$appPath` de `public_html/index.php`. Ex.:
     `$appPath = '/home/SEUUSUARIO/crn9-app';`. Sem esse ajuste, o
     `deploy.php` não encontra o `vendor/autoload.php` e dá erro 500.
2. Acesse no navegador:
   ```
   https://seudominio.com.br/deploy.php?token=SEU_DEPLOY_SECRET
   ```
3. Confira a saída: `key:generate`, `migrate:fresh` e `db:seed` devem
   terminar com `[OK]`. Isso já popula o site com todo o conteúdo
   institucional preparado (notícias, páginas, FAQ, Ética Profissional,
   Transparência, etc.) — se preferir subir com o banco vazio, comente a linha do
   `db:seed` dentro de `deploy.php` antes de enviar.
   - **Atenção:** `migrate:fresh` apaga TODAS as tabelas existentes antes
     de recriar — correto para o primeiro deploy (banco vazio), mas nunca
     rode este script de novo contra um site já em produção com dados
     reais, ou você perde tudo.
4. **Apague `deploy.php` do servidor imediatamente após o uso.** Ele não
   deve ficar publicado — é só para essa execução única.

## 8. Conferir permissões

`storage/` e `bootstrap/cache/` (dentro de `crn9-app/`) precisam ser
graváveis pelo PHP — normalmente `755` já funciona; se dashboard/uploads
falharem, ajuste para `775` pelo Gerenciador de Arquivos.

## 9. Teste final

- Acesse o site e confira a home, uma página institucional e o menu.
- Acesse `/admin` e faça login com o usuário administrador semeado pelo
  `db:seed` (`admin@crn9.org.br` / `password`) — **troque essa senha
  imediatamente** pelo próprio painel (Filament → seu usuário → editar).
- Teste um upload no painel (ex.: criar um banner) para confirmar que
  `storage:link` funcionou e os arquivos ficam acessíveis.

---

## 10. Como atualizar o site depois (novas funcionalidades)

Depois que o site já está no ar com dados reais (notícias, eventos,
denúncias, etc.), **nunca rode o `deploy.php` de novo** — ele usa
`migrate:fresh`, que apaga o banco inteiro. Para subir atualizações de
código (correções, novas páginas, menu, etc.), use este roteiro em vez
disso:

1. **Na sua máquina**, com a branch atualizada (`git pull`):
   ```bash
   npm ci
   npm run build
   composer install --no-dev --optimize-autoloader
   ```
2. **Envie os arquivos atualizados** por FTP/Gerenciador de Arquivos,
   sobrescrevendo os antigos. Pode reenviar o projeto inteiro (mais
   simples e sem risco), **exceto**:
   - `.env` — nunca sobrescreva o `.env` que já está no servidor (tem as
     credenciais reais do banco e o `APP_KEY`);
   - a pasta `storage/app/public` (ou o link `storage/` do document
     root) — é onde ficam os uploads feitos pelo painel (banners,
     imagens de notícias etc.), não sobrescreva com a versão local.
   - Se seguiu a Rota B (passo 6), lembre de copiar de novo o conteúdo
     de `public/` para dentro de `public_html/` (`build/`, `images/`,
     `css/`, `js/`, `index.php`, `.htaccess`) — é o jeito das novas
     classes CSS/JS e do menu atualizado aparecerem no ar.
3. **Envie `deploy/update.php`** para a mesma pasta onde está (ou estava)
   o `deploy.php` — o document root do site. Se estiver na Rota B, ajuste
   o `$appPath` no topo do arquivo, igual foi feito no `deploy.php`.
4. Acesse no navegador:
   ```
   https://seudominio.com.br/update.php?token=SEU_DEPLOY_SECRET
   ```
   Isso roda `migrate` (só as migrations novas, sem apagar nada),
   `db:seed` (atualiza páginas/menu/conteúdo institucional para a versão
   nova — seguro rodar de novo, não duplica nem apaga o que foi
   cadastrado pelo painel) e limpa os caches do Laravel.
5. Confira o site. **Apague `update.php` do servidor** em seguida (mesma
   regra do `deploy.php` — nunca deixar publicado).

### Se algo der errado

- **Erro 500 sem detalhes**: confirme `APP_DEBUG=false` no `.env` (não
  mude para `true` em produção, mas para depurar temporariamente você
  pode olhar `storage/logs/laravel.log` pelo Gerenciador de Arquivos).
- **Erro 500 especificamente no `deploy.php`, mas o site normal
  funciona**: na Opção B, o `$appPath` dentro do `deploy.php` precisa
  ser ajustado manualmente (veja o passo 7) — se ficar no valor padrão
  `dirname(__DIR__)`, ele procura `vendor/` dentro de `public_html/`, que
  não existe ali.
- **"Trait/Class ... not found"** vindo de dentro de `vendor/`: o upload
  do `vendor/` ficou incompleto (comum ao enviar milhares de arquivos
  pequenos por FTP). Zipe a pasta `vendor/` inteira localmente, envie
  esse único arquivo, e extraia pelo "Extract" do Gerenciador de Arquivos
  do cPanel em vez de reenviar arquivo por arquivo.
- **"SQLSTATE[42S01]: ... already exists"** ao rodar as migrations: uma
  tentativa anterior de deploy travou no meio do caminho e deixou
  tabelas criadas sem registrar isso no Laravel. O `deploy.php` já usa
  `migrate:fresh` (que derruba e recria tudo) exatamente para evitar
  isso — se você editou o script e trocou para `migrate` simples, volte
  para `migrate:fresh`.
- **Logo/imagens fixas do site não aparecem** (mas o resto do site
  funciona): faltou copiar `images/`, `css/` e/ou `js/` de dentro de
  `public/` para `public_html/` na Rota B (veja o passo 6.1).
- **Imagens de banners/notícias/uploads não aparecem, mas o logo
  aparece normalmente**: o `storage:link` do Artisan cria o link dentro
  de `crn9-app/public/storage`, que na Rota B não é a pasta servida pelo
  domínio. O `deploy.php` já cria um segundo link na pasta correta
  automaticamente — se mesmo assim não funcionar, a função `symlink()`
  pode estar desabilitada no servidor; nesse caso copie manualmente o
  conteúdo de `crn9-app/storage/app/public/` para uma pasta `storage/`
  dentro de `public_html/` (uploads futuros pelo painel não aparecerão
  até você repetir essa cópia).
- **"Specified key was too long"** ao rodar `migrate`: já tratado no
  código (`Schema::defaultStringLength(191)` em `AppServiceProvider`) —
  se aparecer mesmo assim, confirme que o `.env` enviado é o mesmo que
  contém essa versão do código.
- **CSS/JS não carregam**: confirme que a pasta `public/build/` foi
  enviada (gerada no passo 3) e que o `APP_URL` no `.env` bate com o
  domínio real.
