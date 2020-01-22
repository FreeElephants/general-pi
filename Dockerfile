FROM php:7.4-cli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN  apt-get update \
    && apt-get install -y libzip-dev \
    && docker-php-ext-install zip

# enable phpdebug
#RUN apt-get install -y libxml2-dev \
#    && docker-php-source extract \
#    && cd /usr/src/php \
#    && ./configure --enable-phpdbg \
#&& docker-php-source delete

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /general
