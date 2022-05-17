FROM php:8.0-apache
RUN apt update && apt install -y libssl-dev
RUN pecl install mongodb \
  && docker-php-ext-enable mongodb

### ENABLE THIS CONFIG TO MAKE LARAVEL WORK
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
RUN chown www-data:www-data /var/www/* -R

### ADD PDO_MYSQL FUNCTIONALITY
#ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
#RUN chmod +x /usr/local/bin/install-php-extensions && \
#  install-php-extensions pdo_mysql

### ENABLE REQRITE FOR LARAVEL
RUN a2enmod rewrite
RUN apt update && apt -y install wget

### LOAD AND EXECUTABLE RUN.SH CUSTOM SCRIPT
#COPY ./run.sh /var/www/run.sh
#RUN chmod +x /var/www/run.sh