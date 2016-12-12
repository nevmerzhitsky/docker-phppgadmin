FROM nginx:stable-alpine

MAINTAINER Sergey Nevmerzhitsky "sergey.nevmerzhitsky@gmail.com"

ENV NGINX_FPM_HOST=app
ENV NGINX_FPM_PORT=9000
ENV NGINX_INDEX_SCRIPT=index.php

COPY default-template.conf /etc/nginx/conf.d/default-template.conf
RUN envsubst < /etc/nginx/conf.d/default-template.conf > /etc/nginx/conf.d/default.conf && \
    rm /etc/nginx/conf.d/default-template.conf
