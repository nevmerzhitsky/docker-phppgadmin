FROM php:5.6-fpm-alpine
MAINTAINER Sergey Nevmerzhitsky "sergey.nevmerzhitsky@gmail.com"

ARG NGINX_DOCROOT=/usr/share/nginx/html

WORKDIR $NGINX_DOCROOT
COPY src .

RUN set -ex && \
    apk --no-cache add postgresql-dev && \
    docker-php-ext-install pgsql
