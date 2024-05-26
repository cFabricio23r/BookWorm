ARG ALPINE_VERSION=3.18
FROM alpine:${ALPINE_VERSION}

WORKDIR /var/www/html

RUN apk add --no-cache \
  git \
  curl \
  tini \
  nginx \
  php \
  php82-bcmath \
  php82-ctype \
  php82-curl \
  php82-dom \
  php82-fpm \
  php82-ftp \
  php82-fileinfo \
  php82-gd \
  php82-intl \
  php82-json \
  php82-exif \
  php82-mbstring \
  php82-mysqli \
  php82-opcache \
  php82-openssl \
  php82-pdo \
  php82-pdo_mysql \
  php82-pcntl \
  php82-phar \
  php82-posix \
  php82-redis \
  php82-simplexml \
  php82-session \
  php82-tokenizer \
  php82-xml \
  php82-xmlreader \
  php82-xmlwriter \
  php82-zlib \
  php82-zip \
  php82-iconv \
  icu-data-full \
  supervisor \
  bash

# Install Composer
# Create symlink so programs depending on `php` still function
RUN ln -s /usr/bin/php82 /usr/bin/php

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

# Copy the default Nginx configuration
COPY /docker/config/nginx.conf /etc/nginx/nginx.conf

COPY ./*.sh /var/www/html/

COPY ./entrypoint.sh ./entrypoint.sh
RUN chmod +x ./entrypoint.sh

# Configure PHP-FPM
COPY /docker/config/fpm-pool.conf /etc/php82/php-fpm.d/www.conf

# Configure php.ini
COPY /docker/config/php.ini /etc/php82/conf.d/custom.ini

# Configure supervisord
COPY /docker/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY /docker/config/supervisord-horizon.conf /etc/supervisor/conf.d/supervisord-horizon.conf
COPY /docker/config/supervisord-queue.conf /etc/supervisor/conf.d/supervisord-queue.conf
COPY /docker/config/supervisord-websockets.conf /etc/supervisor/conf.d/supervisord-websockets.conf

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /var/www/html /run /var/lib/nginx /var/log/nginx /var/log/php82

# Switch to use a non-root user from here on
USER nobody

# Add application
COPY --chown=nobody ./ /var/www/html/

# Install composer dependencies
RUN composer install \
    --optimize-autoloader \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --ignore-platform-req=ext-exif \
    --ansi

RUN composer update

RUN git config user.email "fabricio.23@live.com"
RUN git config user.name "Fabricio Ramirez"
# RUN git tag -a -m new-tag $TAG
# RUN php artisan version:absorb

# Expose ports for Nginx
EXPOSE 8000

STOPSIGNAL SIGTERM

# Let supervisord start nginx & php-fpm
ENTRYPOINT ["/sbin/tini", "--", "bash", "./entrypoint.sh"]

# Configure a healthcheck to validate that everything is up&running
# HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8000/fpm-ping
