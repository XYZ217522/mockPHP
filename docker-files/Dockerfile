#php version is 7.4.25
FROM alpine:3.14

## Install S6-Overlay
RUN apk update && apk upgrade && \
    apk add --no-cache curl tzdata procps htop && \
    cp /usr/share/zoneinfo/Asia/Taipei /etc/localtime && \
    curl -L -s https://github.com/just-containers/s6-overlay/releases/download/v1.20.0.0/s6-overlay-amd64.tar.gz \
    | tar xvzf - -C /

RUN apk update && apk upgrade && \
    apk --no-cache --progress add \
    php7 \
    php7-fpm \
    php7-curl \
    php7-json \
    php7-openssl \
    php7-mbstring \
    php7-mcrypt \
    php7-opcache \
    php7-iconv \
    php7-ctype \
    php7-fileinfo \
    php7-tokenizer \
    php7-session \
    php7-mongodb \
    php7-pdo \
    php7-pdo_mysql



RUN apk update && apk upgrade && \
	apk --no-cache --progress add \
	nginx \
	php7-xmlwriter \
	php7-xmlreader \
	php7-simplexml \
	php7-xml \
	php7-zip \
	php7-gd \
    php7-pear \
    composer

RUN mkdir -p /run/nginx/ && \
	mkdir -p /var/log/nginx

# 確認 php 版本為 7.4
ARG PHP_VERSION=7.4
RUN php -v | head -n 1 | grep -q "PHP ${PHP_VERSION}."

COPY docker-files/config /

COPY docker-files/conf_php /home/httpd/conf_php/

COPY . /app

RUN rm -rf /app/docker-files

RUN mkdir -p /app/src/res/temp && \
	chown nobody.nobody /app/src/res/temp

WORKDIR /app

ENTRYPOINT ["/init"]
