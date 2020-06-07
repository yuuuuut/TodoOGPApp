FROM php:7.3-fpm
COPY php.ini /usr/local/etc/php/

RUN apt-get update \
  && apt-get install -y libzip-dev zlib1g-dev mariadb-client \
  && docker-php-ext-install zip pdo_mysql

#Nodejs
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

#Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

WORKDIR /var/www

RUN composer global require "laravel/installer"