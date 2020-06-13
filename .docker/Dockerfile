# docker build -t iuctf -f .docker/Dockerfile .

FROM alpine:3.12

MAINTAINER Iucyber

COPY app      /var/www/localhost/htdocs/app
COPY public   /var/www/localhost/htdocs/public
COPY tests    /var/www/localhost/htdocs/tests
COPY writable /var/www/localhost/htdocs/writable

COPY composer.json /var/www/localhost/htdocs/
COPY builds        /var/www/localhost/htdocs/
COPY spark         /var/www/localhost/htdocs/
COPY env           /var/www/localhost/htdocs/

WORKDIR /var/www/localhost/htdocs

RUN chmod 777 /var/www/localhost/htdocs/writable -R

RUN apk update
RUN apk upgrade
RUN apk add --no-cache php7 apache2 php-apache2
RUN apk add --no-cache php7-xml php7-intl php7-sqlite3 php7-mysqli php7-curl php7-json php7-zip php7-dom php7-xmlwriter php7-tokenizer php7-session
RUN apk add --no-cache composer

RUN composer install

COPY env /var/www/localhost/htdocs/.env
RUN sed -i "s|# database.default.database = ci4|database.default.database = ../writable/iuctf.sqlite|g" /var/www/localhost/htdocs/.env
RUN sed -i "s|# database.default.DBDriver = MySQLi|database.default.DBDriver = SQLite3|g" /var/www/localhost/htdocs/.env

RUN sed -i "s|/var/www/localhost/htdocs|/var/www/localhost/htdocs/public|g" /etc/apache2/httpd.conf
RUN sed -i "s|#LoadModule rewrite_module|LoadModule rewrite_module|g" /etc/apache2/httpd.conf
RUN sed -i "s|#ServerName www.example.com:80|ServerName localhost|g" /etc/apache2/httpd.conf
RUN sed -i 's|AllowOverride [Nn]one|AllowOverride All|' /etc/apache2/httpd.conf

EXPOSE 80
VOLUME /var/www/localhost/htdocs
ENTRYPOINT ["/usr/sbin/httpd", "-D", "FOREGROUND"]
