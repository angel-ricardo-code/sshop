### Multi-stage Dockerfile
### Stage 1: Node builder - build frontend assets
FROM node:18-alpine AS node_builder
WORKDIR /app

# Copy package files first for caching
COPY package.json package-lock.json* ./
RUN npm ci --silent || npm install --no-audit --no-fund --silent

# Copy everything (resources, vite config, etc.) so build can access assets
COPY . .

# Build assets into public/build
RUN npm run build || true

### Stage 2: Composer builder - install PHP dependencies
FROM composer:2 AS composer_builder
WORKDIR /app

# Copy composer files and install vendors
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts --no-progress

# Copy the rest of the app (so vendor is alongside app code)
COPY . .

# Run optimized autoload
RUN composer dump-autoload --optimize --classmap-authoritative || true

### Stage 3: Production image with php-fpm
FROM php:8.2-fpm-alpine

# System deps required at runtime
RUN apk add --no-cache \
    bash \
    coreutils \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    postgresql-dev

# PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip intl mbstring

WORKDIR /var/www/html

# Copy application code and vendor from composer stage
COPY --from=composer_builder /app /var/www/html

# Copy built frontend assets from node stage
COPY --from=node_builder /app/public/build /var/www/html/public/build

# Ensure storage and cache are writable
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/build || true

EXPOSE 9000

CMD ["php-fpm"]
