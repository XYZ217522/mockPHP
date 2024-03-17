FROM golang:1.18-alpine AS builder

# 設定工作目錄
WORKDIR /build

COPY ./encryption-helper-golang /build

#RUN go mod download

# 執行編譯
RUN CGO_ENABLED=0 go build -v -o encryption_helper

#php version is 7.4.25
FROM alpine:3.14

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
    php7-pdo_mysql \
    php7-xmlwriter \
    php7-xmlreader \
    php7-simplexml \
    php7-xml \
    php7-zip \
    php7-gd \
    php7-pear \
    curl \
    tzdata \
    htop \
    nginx \
    composer

WORKDIR /app

# 將 Golang 階段的二進制文件複製
RUN mkdir -p /golang
COPY --from=builder /build/encryption_helper /golang/encryption_helper

RUN chmod 755 /golang/encryption_helper

RUN mkdir -p /run/nginx/ && \
	mkdir -p /var/log/nginx

# 確認 php 版本為 7.4
ARG PHP_VERSION=7.4
RUN php -v | head -n 1 | grep -q "PHP ${PHP_VERSION}."

COPY docker-files/config /

COPY . /app

RUN rm -rf /app/docker-files /app/encryption-helper-golang

RUN mkdir -p /app/src/res/temp && \
	chown nobody.nobody /app/src/res/temp

# install s6
ARG S6_VERSION=2.2.0.3
RUN curl -L -s https://github.com/just-containers/s6-overlay/releases/download/v${S6_VERSION}/s6-overlay-amd64.tar.gz \
        | tar xvzf - -C /

#RUN composer install

ENTRYPOINT ["/init"]
