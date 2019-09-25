FROM php:7.2-apache-stretch

COPY . /var/www/html

COPY docker/production-com/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/production-com/vhost-ssl.conf /etc/apache2/sites-available/default-ssl.conf

COPY docker/production-com/ssl-keys/www_news_janelaunica.crt /etc/ssl/certs/janela-news.crt
COPY docker/production-com/ssl-keys/www_news_janelaunica.key /etc/ssl/certs/janela-news.key

COPY docker/start.sh /usr/local/bin/start

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update -yqq \
    && apt-get install -yqq --no-install-recommends \
        libicu-dev \
        libpq-dev \
        libmcrypt-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        unzip \
        nano \
        mysql-client \
    && docker-php-ext-install \
        pdo_mysql \
        zip \
        opcache \
        ctype \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && apt-get remove --purge -yyq libicu-dev \
        libpq-dev \
        libmcrypt-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
    && rm -r /var/lib/apt/lists/*

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN chown -R www-data:www-data /var/www/html \
    && chmod u+x /usr/local/bin/start \
    && chmod -R 777 /var/www/html \
    && ln -sfn /var/www/html/storage /var/www/html/public \
    && a2enmod rewrite \
    && a2enmod ssl

RUN (cd /etc/apache2/sites-available && a2ensite default-ssl.conf)

RUN mkdir -p /var/run/apache2/

RUN (cd /var/www/html && rm -rf vendor)

RUN useradd -ms /bin/bash  composer

USER composer

RUN (cd /var/www/html && composer install --no-dev --no-interaction --optimize-autoloader)

USER root

EXPOSE 80
EXPOSE 443

CMD ["/usr/local/bin/start"]
