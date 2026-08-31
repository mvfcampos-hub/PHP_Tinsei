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

1. Copie o **conteúdo** de `crn9-app/public/` (o `index.php`, o `.htaccess`
   e a pasta `build/`) para dentro de `public_html/`.
2. Substitua o `public_html/index.php` pelo conteúdo de
   `deploy/index_public_html.php` (já incluído nesta pasta), ajustando a
   variável `$appPath` no topo para o caminho real do passo 5.
3. Confirme que `public_html/.htaccess` foi copiado (ele existe no
   `public/` original do Laravel e cuida do roteamento).

## 7. Rodar o deploy

1. Envie `deploy/deploy.php` para a **mesma pasta** que ficou com o
   `index.php` final (ou seja, o document root do site — `public_html/`
   na Opção B, ou `crn9-app/public/` na Opção A).
2. Acesse no navegador:
   ```
   https://seudominio.com.br/deploy.php?token=SEU_DEPLOY_SECRET
   ```
3. Confira a saída: `key:generate`, `migrate` e `db:seed` devem terminar
   com `[OK]`. Isso já popula o site com todo o conteúdo institucional
   preparado (notícias, páginas, FAQ, Ética Profissional, Transparência,
   etc.) — se preferir subir com o banco vazio, comente a linha do
   `db:seed` dentro de `deploy.php` antes de enviar.
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

### Se algo der errado

- **Erro 500 sem detalhes**: confirme `APP_DEBUG=false` no `.env` (não
  mude para `true` em produção, mas para depurar temporariamente você
  pode olhar `storage/logs/laravel.log` pelo Gerenciador de Arquivos).
- **"Specified key was too long"** ao rodar `migrate`: já tratado no
  código (`Schema::defaultStringLength(191)` em `AppServiceProvider`) —
  se aparecer mesmo assim, confirme que o `.env` enviado é o mesmo que
  contém essa versão do código.
- **CSS/JS não carregam**: confirme que a pasta `public/build/` foi
  enviada (gerada no passo 3) e que o `APP_URL` no `.env` bate com o
  domínio real.
