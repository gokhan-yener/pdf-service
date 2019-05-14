FROM alpine:3.6

RUN apk add --update \
    dcron \
    wget \
    rsync \
    ca-certificates \
    nginx \
    supervisor \
    php7 \
    php7-bcmath \
    php7-dom \
    php7-ctype \
    php7-curl \
    php7-fpm \
    php7-gd \
    php7-iconv \
    php7-intl \
    php7-json \
    php7-mbstring \
    php7-mcrypt \
    php7-mysqlnd \
    php7-opcache \
    php7-openssl \
    php7-pdo \
    php7-pdo_mysql \
    php7-pdo_pgsql \
    php7-pdo_sqlite \
    php7-phar \
    php7-posix \
    php7-session \
    php7-soap \
    php7-xml \
    php7-zip \
    php7-apcu \
    php7-bz2 \
    php7-calendar \
    php7-dba \
    php7-exif \
    php7-ftp \
    php7-gettext \
    php7-pear \
    php7-pcntl \
    php7-pdo_dblib \
    php7-shmop \
    php7-simplexml \
    php7-sockets \
    php7-sysvmsg \
    php7-sysvsem \
    php7-sysvshm \
    php7-wddx \
    php7-xmlreader \
    php7-xsl \
    php7-zlib \
    php7-ldap \
    php7-odbc \
    php7-tokenizer \
    make \
    curl

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

RUN rm -rf /var/cache/apk/* && rm -rf /tmp/*

RUN mkdir -p /var/log/cron && mkdir -m 0644 -p /var/spool/cron/crontabs && touch /var/log/cron/cron.log && mkdir -m 0644 -p /etc/cron.d
RUN mkdir -p /run/nginx

ADD ./docker/supervisor/supervisord.conf /etc

ADD ./docker/nginx/nginx.conf /etc/nginx/
ADD ./docker/nginx/default.conf /etc/nginx/conf.d/

ADD ./docker/php/symfony.ini /etc/php7/conf.d/
ADD ./docker/php/symfony.pool.conf /etc/php7/php-fpm.d/
RUN rm /etc/php7/php-fpm.d/www.conf

ADD ./docker/cron/cronjobs /etc/crontabs/root
RUN chmod 0644 /etc/crontabs/root

ADD . /var/www/symfony

RUN chmod -R 777 /var/www/symfony/log \
    && chmod -R 777 /var/www/symfony/var/* \
    && chmod -R 777 /var/www/symfony/app/cache \
    && chmod -R 777 /var/www/symfony/app/logs \
    && chmod -R 777 /var/www/symfony/app/sessions \
    && chmod -R 777 /var/www/symfony/app/tmp \
    && chmod -R 777 /var/www/symfony/web/download \
    && chmod -R 777 /var/www/symfony/web/sign

CMD ["/usr/bin/supervisord"]

WORKDIR /var/www/symfony

EXPOSE 80
