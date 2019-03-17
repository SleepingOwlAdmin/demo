FROM theparticles/libs:alpine

COPY ./php/fpm_www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./php/php.ini /usr/local/etc/php/

COPY ./start.sh /usr/local/bin/start
RUN chmod u+x /usr/local/bin/start
