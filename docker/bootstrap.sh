#!/usr/bin/env bash

cd /var/www/app/

composer i --ignore-platform-reqs

chmod 777 -R /var/www/app/public/wp-content/uploads
chmod 777 -R /var/www/app/public/wp-content/cache