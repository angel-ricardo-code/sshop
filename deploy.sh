#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")"

echo "[deploy] Starting deploy script"

# Install PHP dependencies if vendor is missing
if [ ! -d vendor ] && command -v composer >/dev/null 2>&1; then
  echo "[deploy] Installing PHP dependencies (composer)"
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Build frontend assets if not present
if [ ! -d public/build ] && command -v npm >/dev/null 2>&1; then
  echo "[deploy] Building frontend assets (npm)"
  npm ci --silent || npm install --no-audit --no-fund --silent
  npm run build || true
fi

# Ensure storage symlink exists
if [ ! -L public/storage ]; then
  echo "[deploy] Creating storage symlink"
  php artisan storage:link || echo "[deploy] storage:link failed or already exists"
fi

# Run migrations with retries (useful when DB isn't immediately available)
MAX_RETRIES=${MAX_RETRIES:-10}
SLEEP=${SLEEP:-5}
i=0
echo "[deploy] Running migrations (up to $MAX_RETRIES attempts)"
until php artisan migrate --force; do
  i=$((i+1))
  if [ "$i" -ge "$MAX_RETRIES" ]; then
    echo "[deploy] Migrations failed after $i attempts" >&2
    exit 1
  fi
  echo "[deploy] Migration failed, retrying in $SLEEP seconds... ($i/$MAX_RETRIES)"
  sleep "$SLEEP"
done

echo "[deploy] Caching and optimizing"
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "[deploy] Restarting queues"
php artisan queue:restart || true

# Fix permissions for runtime
if id www-data >/dev/null 2>&1; then
  chown -R www-data:www-data storage bootstrap/cache public/build || true
fi

echo "[deploy] Deploy script finished"
