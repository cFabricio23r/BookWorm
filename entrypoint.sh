#!/bin/sh

echo 'starting web server'

# Run database migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache

# Clear and cache routes
php artisan route:cache

# Classmap Optimization
php artisan optimize

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
