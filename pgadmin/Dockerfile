FROM php:5.6-fpm-alpine
MAINTAINER Sergey Nevmerzhitsky "sergey.nevmerzhitsky@gmail.com"

ARG NGINX_DOCROOT=/usr/share/nginx/html

RUN set -ex && \
    apk --no-cache add postgresql-dev && \
    docker-php-ext-install pgsql
RUN set -ex && \
    apk --no-cache add git && \
    mkdir -p $NGINX_DOCROOT && \
    cd $NGINX_DOCROOT && \
    rm -rf * && \
    git clone https://github.com/phppgadmin/phppgadmin.git . && \
    git checkout tags/REL_5-0-BETA-2 && \
    rm -rf .git* && \
    apk del git
