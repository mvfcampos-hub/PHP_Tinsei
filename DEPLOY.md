# Publicação em hospedagem cPanel

Roteiro para publicar o site em **homologação** (`novo.tinsei.com.br`) e, depois, no domínio definitivo.

**Requisitos da hospedagem:** PHP 8.2 ou superior, com as extensões `pdo_mysql`, `mbstring`, `intl`, `fileinfo`, `gd`, `zip` e `openssl`, e MySQL ou MariaDB.

## 1. Banco de dados

1. No cPanel, em **Bancos de dados MySQL**, crie o banco (ex.: `usuario_tinsei`).
2. Crie um usuário e dê a ele **todos os privilégios** nesse banco.

## 2. Arquivos

1. Envie o pacote `tinsei-site-*.zip` pelo **Gerenciador de Arquivos** para a pasta *home* da conta (fora de `public_html`) e extraia. O resultado é `~/tinsei_site/`.
2. Em **Domínios** ou **Subdomínios**, crie `novo.tinsei.com.br` com a **raiz do documento** em `tinsei_site/public`.
   - Se a hospedagem não deixar escolher essa pasta como raiz, aponte para `tinsei_site`: o `.htaccess` que vem nela redireciona tudo para `public/`.
3. Em **PHP Selector** ou **MultiPHP**, selecione PHP 8.2 ou superior para esse domínio.

## 3. Configuração (`.env`)

1. No pacote, o arquivo `tinsei_site/.env` já existe. Sem o pacote, copie `.env.cpanel.example` para `.env`.
2. Preencha as linhas marcadas com `PREENCHER` (banco, e-mail e senha do administrador). No pacote, o `.env` já vem pronto com o `APP_KEY`.
3. Ative o SSL no **SSL/TLS Status** (AutoSSL) para `novo.tinsei.com.br`.

## 4. Criar as tabelas e o conteúdo

**Com Terminal ou SSH no cPanel:**

```bash
cd ~/tinsei_site
php artisan migrate --seed --force
php artisan optimize
```

**Sem Terminal:**

1. Abra o **phpMyAdmin**, selecione o banco e **importe** o arquivo `database/tinsei-homologacao.sql` que vem no pacote.
2. Esse arquivo já cria todas as tabelas, o conteúdo inicial e o usuário `admin@tinsei.com.br` com a senha `troque-esta-senha`. Troque essa senha no primeiro acesso, em `/admin`.

## 5. Conferir

- `https://novo.tinsei.com.br` abre o site.
- `https://novo.tinsei.com.br/admin` abre o painel.
- `https://novo.tinsei.com.br/robots.txt` deve mostrar `Disallow: /`, porque a homologação não aparece no Google.
- Envie uma mensagem pelo formulário de contato. Ela deve aparecer em **Comercial › Mensagens do site**.

## 6. Ir para o domínio definitivo

1. Aponte `tinsei.com.br` para `tinsei_site/public`, no lugar do site atual (guarde um backup do site atual).
2. No `.env`, mude `APP_URL=https://tinsei.com.br` e `SITE_NOINDEX=false`.
3. Rode `php artisan optimize:clear && php artisan optimize`. Sem Terminal, apague os arquivos de `bootstrap/cache/` (exceto o `.gitignore`).
4. Envie o sitemap (`/sitemap.xml`) no Google Search Console.

## Atualizações futuras

1. Gere um novo pacote a partir da branch principal.
2. Substitua os arquivos mantendo `.env` e `public/storage/`, onde ficam as imagens enviadas pelo painel.
3. Rode `php artisan migrate --force && php artisan optimize`.
