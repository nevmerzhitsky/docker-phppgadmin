FROM php:5.6-fpm-alpine

MAINTAINER Sergey Nevmerzhitsky "sergey.nevmerzhitsky@gmail.com"

RUN apk add --no-cache git
RUN mkdir -p /usr/share/nginx/html && \
    cd /usr/share/nginx/html && \
    rm -rf * && \
    git clone https://github.com/phppgadmin/phppgadmin.git . && \
    git checkout tags/REL_5-0-BETA-2 && \
    rm -rf .git*
