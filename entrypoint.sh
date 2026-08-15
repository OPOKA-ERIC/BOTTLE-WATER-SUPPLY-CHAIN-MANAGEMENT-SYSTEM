#!/bin/bash
set -e

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Cache config, routes, views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
exec apache2-foreground
