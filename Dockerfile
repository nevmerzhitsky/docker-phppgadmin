# SMALL linux
# nginx
# php 5.5 / 5.6?
# phpPgadmin 5.0-beta2

FROM nginx:alpine

MAINTAINER Sergey Nevmerzhitsky "sergey.nevmerzhitsky@gmail.com"

COPY conf/nginx.conf /etc/nginx/nginx.conf
COPY html/ /usr/share/nginx/html
