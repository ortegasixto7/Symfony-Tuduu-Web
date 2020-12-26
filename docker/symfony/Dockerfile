FROM composer as builder
WORKDIR /app/
COPY ./composer.json .
COPY ./composer.lock .
RUN composer install


FROM php:7.4-fpm-alpine

RUN apk add --no-cache zip libzip-dev
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql 

WORKDIR /app
COPY . .
COPY --from=builder /app/vendor /app/vendor

RUN mkdir -p var/cache/prod
RUN mkdir -p var/log
RUN chmod -R 777 var/cache/prod
RUN chmod -R 777 var/log

ENV APP_ENV=${APP_ENV}
ENV APP_SECRET=${APP_SECRET}
ENV DATABASE_URL=${DATABASE_URL}