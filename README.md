# Site Tinsei

Site institucional da Tinsei (tinsei.com.br), em **Laravel 11 + Filament 3**, no mesmo modelo de painel do site da Databit.

## Páginas

| Rota | Conteúdo |
| --- | --- |
| `/` | Home: destaque, pilares, atuação, portfólio (com busca na loja), números, mapa de clientes, sustentabilidade, história e sócios, vídeo, depoimentos, notícias, agenda, marcas |
| `/sobre` | Quem somos, valores, linha do tempo, sócios, vídeo institucional |
| `/portfolio` | Linhas do portfólio com link para a loja B2B (loja.tinsei.com.br) |
| `/sustentabilidade` | ESG e economia circular |
| `/onde-estamos` | Mapa do Brasil interativo + tabela de clientes por UF |
| `/noticias`, `/agenda`, `/depoimentos` | Áreas de conteúdo |
| `/contato` | Formulário (salvo no painel + aviso por e-mail) |
| `/trabalhe-conosco` | Envio de currículo |
| `/loja` | Atalho que redireciona para a loja |

## Painel (`/admin`)

- **Conteúdo:** menu, páginas, banners/avisos, notícias (com vídeo do YouTube), agenda
- **Institucional:** linha do tempo, sócios, depoimentos
- **Comercial:** mensagens do site, linhas do portfólio, marcas, **mapa de clientes por estado** (quantidade editável direto na lista)
- **Configurações:** contatos, redes, link da loja, números da home, Google Analytics e usuários do painel

## Instalação

```bash
composer install
npm install && npm run build
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

O seeder cria o usuário definido em `ADMIN_EMAIL`/`ADMIN_PASSWORD` (padrão `admin@tinsei.com.br` / `troque-esta-senha`) e carrega o conteúdo inicial. Ele pode ser rodado de novo sem duplicar registros. Troque a senha no primeiro acesso.

Testes: `php artisan test`.

## Pendências de conteúdo (confirmar com a Tinsei)

- **Fotos dos sócios.** Por enquanto aparecem as iniciais. Envie as fotos em *Institucional › Sócios*.
- **Anos da linha do tempo.** Três marcos estão sem ano: liderança em A3, indústria de suprimentos e parceria Xerox.
- **Depoimentos e agenda.** Não há conteúdo real, apenas exemplos não publicados.
- **Total de clientes.** A soma por estado dá 3.229 e o total informado é 3.230. O site mostra 3.230, definido em *Configurações › Números*. Deixe esse campo vazio para usar a soma.
- **Horário de atendimento.** Não informado; preencha em *Configurações*.
- **Política de Privacidade e Termos de Uso.** São textos-base que precisam de revisão jurídica.
- **Logos de marcas.** Só envie logos com autorização de uso. Por enquanto as marcas aparecem como texto.
