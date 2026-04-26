#!/usr/bin/env bash
set -euo pipefail

# Minimal start script for Render (when not using Docker)
cd $(dirname "$0")

# install composer deps
if command -v composer >/dev/null 2>&1; then
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# npm build assets
if command -v npm >/dev/null 2>&1; then
  npm ci --silent || npm install --no-audit --no-fund --silent
  npm run build || true
fi

# run migrations (if configured)
if php artisan --version >/dev/null 2>&1; then
  php artisan migrate --force || true
fi

# start php-fpm
php-fpm
