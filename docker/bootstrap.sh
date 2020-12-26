#!/usr/bin/env bash

cd /var/www/app/ || exit
composer i --ignore-platform-reqs

cd /var/www/app/public || exit
find . -type f -exec chmod 644 {} +
find . -type d -exec chmod 755 {} +