#!/bin/sh

eval $(aws s3 cp s3://book-worm-test/book_worm_test.env - | sed 's/^/export /')

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
