FROM nginx:alpine

MAINTAINER Sergey Nevmerzhitsky "sergey.nevmerzhitsky@gmail.com"

RUN apk add --no-cache git php5
RUN cd /usr/share/nginx/html && \
    rm -rf * && \
    git clone https://github.com/phppgadmin/phppgadmin.git . && \
    git checkout tags/REL_5-0-BETA-2

#COPY html/ /usr/share/nginx/html
# phpPgadmin 5.0-beta2
