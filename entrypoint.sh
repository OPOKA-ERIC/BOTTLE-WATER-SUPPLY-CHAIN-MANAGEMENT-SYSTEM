#!/bin/bash
set -e

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate --force
fi

# Clear ALL cached config forcefully
rm -f bootstrap/cache/config.php
rm -f bootstrap/cache/routes.php
rm -f bootstrap/cache/routes-v7.php
rm -f bootstrap/cache/views.php
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

# Set correct permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Write debug info to log
php artisan --version > /var/www/html/storage/logs/startup.log 2>&1
echo "APP_KEY set: $([ -n "$APP_KEY" ] && echo 'yes' || echo 'NO')" >> /var/www/html/storage/logs/startup.log
echo "DB_HOST: $DB_HOST" >> /var/www/html/storage/logs/startup.log
echo "DB_PORT: $DB_PORT" >> /var/www/html/storage/logs/startup.log
echo "DB_DATABASE: $DB_DATABASE" >> /var/www/html/storage/logs/startup.log
echo "APP_DEBUG: $APP_DEBUG" >> /var/www/html/storage/logs/startup.log
echo "APP_URL: $APP_URL" >> /var/www/html/storage/logs/startup.log
echo "CACHE_DRIVER: $CACHE_DRIVER" >> /var/www/html/storage/logs/startup.log
echo "SESSION_DRIVER: $SESSION_DRIVER" >> /var/www/html/storage/logs/startup.log
php artisan config:show --raw >> /var/www/html/storage/logs/startup.log 2>&1 || true

# Run migrations
php artisan migrate --force >> /var/www/html/storage/logs/startup.log 2>&1

# Test DB connection
php artisan tinker --execute="DB::connection()->getPdo(); echo 'DB connected OK';" >> /var/www/html/storage/logs/startup.log 2>&1 || echo "DB CONNECTION FAILED" >> /var/www/html/storage/logs/startup.log

chown -R www-data:www-data /var/www/html/storage/logs

# Start Apache
exec apache2-foreground
