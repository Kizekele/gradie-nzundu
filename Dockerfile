# syntax=docker/dockerfile:1

# --- Étape 1 : compilation des assets (Vite / Tailwind) ---
FROM node:22-alpine AS assets
WORKDIR /app
COPY gestion_mambemba/package.json gestion_mambemba/package-lock.json gestion_mambemba/.npmrc ./
RUN npm ci
COPY gestion_mambemba/vite.config.js ./
COPY gestion_mambemba/resources ./resources
RUN npm run build

# --- Étape 2 : application PHP ---
FROM php:8.4-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libzip-dev ca-certificates \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Le serveur PHP intégré peut utiliser plusieurs workers (concurrence)
ENV PHP_CLI_SERVER_WORKERS=4

WORKDIR /var/www/html

COPY gestion_mambemba/ ./

RUN mkdir -p \
        storage/app/public \
        storage/app/private \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-progress

COPY --from=assets /app/public/build ./public/build

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD ["sh", "-c", "php artisan storage:link || true; php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]