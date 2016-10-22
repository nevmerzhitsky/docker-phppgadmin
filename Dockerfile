FROM nginx:alpine

MAINTAINER Sergey Nevmerzhitsky "sergey.nevmerzhitsky@gmail.com"

RUN apk add --no-cache php5

COPY html/ /usr/share/nginx/html

# phpPgadmin 5.0-beta2

