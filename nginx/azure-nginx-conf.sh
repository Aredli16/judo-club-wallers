#!/bin/bash

cp /home/site/wwwroot/nginx/default /etc/nginx/sites-available/default
service nginx reload

php /home/site/wwwroot/bin/console doctrine:database:create --if-not-exists
php /home/site/wwwroot/bin/console doctrine:migrations:migrate --no-interaction