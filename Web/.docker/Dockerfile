FROM php:7.4-apache

# Update system
RUN apt-get update && apt-get install git -y

# Install composer
ENV COMPOSER_HOME "/home/www-data/.composer"
RUN mkdir -p $COMPOSER_HOME && chmod -R 777 $COMPOSER_HOME && curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN mkdir /srv/web
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN docker-php-ext-install pdo pdo_mysql bcmath && \
 chown -R www-data:www-data /srv/web && \
 a2enmod rewrite
