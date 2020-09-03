FROM webdevops/php-nginx:7.4-alpine

WORKDIR /var/www/app

COPY /docker/nginx/10-gzip.conf /opt/docker/etc/nginx/vhost.common.d/10-gzip.conf
COPY /docker/nginx/10-general.conf /opt/docker/etc/nginx/vhost.common.d/10-general.conf

COPY /src .

COPY /docker/bootstrap.sh /opt/docker/provision/entrypoint.d/bootstrap.sh