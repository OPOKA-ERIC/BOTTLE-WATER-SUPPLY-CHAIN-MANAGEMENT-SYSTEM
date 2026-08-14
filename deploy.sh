#!/bin/bash
# Laravel Deployment Script
# Run after setup-server.sh
# Usage: bash deploy.sh

set -e

APP_DIR="/var/www/laravel"
DB_NAME="laravel"
DB_USER="root"
DB_PASS="rootpassword"

echo "=== Cloning repository ==="
if [ -d "$APP_DIR" ]; then
    cd $APP_DIR
    git pull origin master
else
    git clone https://github.com/OPOKA-ERIC/BOTTLE-WATER-SUPPLY-CHAIN-MANAGEMENT-SYSTEM.git $APP_DIR
    cd $APP_DIR
fi

echo "=== Installing PHP dependencies ==="
composer install --no-dev --optimize-autoloader

echo "=== Installing Node dependencies and building assets ==="
npm ci
npm run build

echo "=== Setting up .env ==="
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate app key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    php artisan key:generate
fi

# Configure database in .env
sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=mysql/" .env
sed -i "s/DB_HOST=.*/DB_HOST=127.0.0.1/" .env
sed -i "s/DB_PORT=.*/DB_PORT=3306/" .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env

# Set production values
sed -i "s/APP_ENV=.*/APP_ENV=production/" .env
sed -i "s/APP_DEBUG=.*/APP_DEBUG=false/" .env
sed -i "s/SESSION_DRIVER=.*/SESSION_DRIVER=database/" .env
sed -i "s/CACHE_DRIVER=.*/CACHE_DRIVER=database/" .env

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Seeding database ==="
php artisan db:seed --force || true

echo "=== Caching config ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Setting permissions ==="
chown -R www-data:www-data $APP_DIR
chmod -R 755 $APP_DIR/storage
chmod -R 755 $APP_DIR/bootstrap/cache

echo "=== Restarting services ==="
systemctl restart php8.1-fpm
systemctl restart nginx

echo "=== Deployment complete ==="
echo "Your app is live at: http://YOUR_SERVER_IP"
