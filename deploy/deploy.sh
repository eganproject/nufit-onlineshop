#!/usr/bin/env bash
# Deploy ulang NuFit Online Shop di VPS (jalankan dari folder aplikasi):
#   bash deploy/deploy.sh
# Asumsi: kode diambil dari git, Node.js tersedia untuk build aset.
set -euo pipefail

BRANCH="${BRANCH:-main}"

# Node dari nvm milik user ini (bila ada), mis. server yang Node-nya hanya untuk root.
if [ -s "$HOME/.nvm/nvm.sh" ]; then
    # shellcheck disable=SC1091
    . "$HOME/.nvm/nvm.sh" >/dev/null
fi

# Paket dev (Faker dkk.) hanya dipasang di luar produksi, supaya seeder contoh bisa jalan di staging.
APP_ENV_VALUE="$(grep -E '^APP_ENV=' .env 2>/dev/null | cut -d= -f2 | tr -d '"' || true)"
COMPOSER_DEV_FLAG="--no-dev"
if [ -n "$APP_ENV_VALUE" ] && [ "$APP_ENV_VALUE" != "production" ]; then
    COMPOSER_DEV_FLAG=""
fi

echo "==> Mode perawatan"
php artisan down --refresh=15 --retry=60 || true

# Pastikan situs kembali hidup walau ada langkah yang gagal.
trap 'php artisan up' EXIT

echo "==> Ambil kode terbaru ($BRANCH)"
git pull --ff-only origin "$BRANCH"

echo "==> Dependency PHP"
composer install $COMPOSER_DEV_FLAG --prefer-dist --no-interaction --optimize-autoloader

echo "==> Build aset"
npm ci --no-audit --no-fund
npm run build

echo "==> Migrasi database"
php artisan migrate --force

echo "==> Cache config, route, view, event"
php artisan optimize
php artisan storage:link 2>/dev/null || true

echo "==> Restart worker antrean"
php artisan queue:restart

# OPcache: muat ulang PHP-FPM bila user ini punya izin (abaikan bila tidak).
sudo -n systemctl reload php8.3-fpm 2>/dev/null || true

echo "==> Selesai"
php artisan shop:check || true
