FROM php:7.2-apache-stretch

COPY . /var/www/html

COPY docker/production-br/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/production-br/vhost-ssl.conf /etc/apache2/sites-available/000-default-ssl.conf

COPY docker/production-br/ssl-keys/janela-news.crt /etc/ssl/certs/janela-news.crt
COPY docker/production-br/ssl-keys/janela-news.key /etc/ssl/certs/janela-news.key
COPY docker/production-br/ssl-keys/ca-janela-news.txt /etc/ssl/certs/ca-janela-news.txt

COPY docker/start.sh /usr/local/bin/start

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
    # Remove dev packages
    && apt-get remove --purge -yyq libicu-dev \
        libpq-dev \
        libmcrypt-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
    && rm -r /var/lib/apt/lists/*

RUN chown -R www-data:www-data /var/www/html \
    && chmod u+x /usr/local/bin/start \
    && a2enmod rewrite

CMD ["/usr/local/bin/start"]
