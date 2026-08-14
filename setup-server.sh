#!/bin/bash
# Oracle Cloud VPS Setup Script
# Run this on a fresh Ubuntu 22.04/24.04 ARM instance
# Usage: sudo bash setup-server.sh

set -e

echo "=== Updating system ==="
apt update && apt upgrade -y

echo "=== Installing PHP 8.1 and extensions ==="
apt install -y software-properties-common
add-apt-repository -y ppa:ondrej/php
apt update
apt install -y php8.1 php8.1-cli php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd php8.1-bcmath php8.1-tokenizer php8.1-dom unzip git curl

echo "=== Installing MySQL ==="
apt install -y mysql-server
mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'rootpassword';"
mysql -e "CREATE DATABASE laravel;"
mysql -e "FLUSH PRIVILEGES;"

echo "=== Installing Composer ==="
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

echo "=== Installing Node.js 20 ==="
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs

echo "=== Installing Nginx ==="
apt install -y nginx

echo "=== Configuring Nginx ==="
cat > /etc/nginx/sites-available/laravel <<'EOF'
server {
    listen 80;
    server_name _;
    root /var/www/laravel/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

ln -sf /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

echo "=== Configuring PHP ==="
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 50M/' /etc/php/8.1/fpm/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 50M/' /etc/php/8.1/fpm/php.ini
sed -i 's/max_execution_time = 30/max_execution_time = 60/' /etc/php/8.1/fpm/php.ini

echo "=== Setting up firewall ==="
apt install -y ufw
ufw allow 'Nginx Full'
ufw allow OpenSSH
ufw --force enable

echo "=== Starting services ==="
systemctl restart php8.1-fpm
systemctl restart nginx
systemctl restart mysql

echo "=== Server setup complete ==="
echo "MySQL root password: rootpassword"
echo "Database name: laravel"
echo "Next: Deploy your Laravel app using deploy.sh"
