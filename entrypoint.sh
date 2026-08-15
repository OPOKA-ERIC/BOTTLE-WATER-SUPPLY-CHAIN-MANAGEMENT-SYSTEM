#!/bin/bash
set -e

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate --force
fi

# Run migrations only (not fresh)
php artisan migrate --force

# Cache config, routes, views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Seed demo users
php artisan db:seed --force 2>/dev/null || true

# Start Apache
exec apache2-foreground
