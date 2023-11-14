FROM php:7.3-apache

WORKDIR /var/www/html

COPY . /var/www/html/

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN chmod -R 755 /var/www/html/
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 9191

CMD ["apache2-foreground"]

