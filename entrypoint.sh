#!/bin/bash
set -e

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate --force
fi

# Clear ALL cached config - Render injects env vars at runtime
rm -f bootstrap/cache/config.php
rm -f bootstrap/cache/routes.php
rm -f bootstrap/cache/routes-v7.php
rm -f bootstrap/cache/views.php

# Run migrations only
php artisan migrate --force

# Start Apache
exec apache2-foreground
