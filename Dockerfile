FROM webdevops/php-nginx:7.4-alpine

WORKDIR /var/www/app

COPY /src/composer.json composer.json
COPY /src/composer.lock composer.lock

COPY /src .

RUN composer i  --ignore-platform-reqs

RUN chmod 777 -R public/wp-content/uploads
RUN chmod 777 -R public/wp-content/cache