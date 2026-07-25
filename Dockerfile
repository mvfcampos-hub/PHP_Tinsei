# Preview/demo image for the public CRN-9 site.
# Not intended for production use: uses SQLite on an ephemeral disk and
# seeds demo content on every boot, so data does not persist across deploys.

FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY public ./public
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

FROM php:8.3-cli-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
        unzip git libsqlite3-dev libzip-dev libcurl4-openssl-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_sqlite zip mbstring curl bcmath xml \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress \
    && cp .env.example .env \
    && mkdir -p database storage/app/public \
    && touch database/database.sqlite \
    && php artisan key:generate --force

EXPOSE 10000

CMD php artisan migrate:fresh --force \
    && php artisan db:seed --force \
    && php artisan storage:link \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
