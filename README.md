# php-service-template

### How to deploy a project on a local machine

* add the following line to the file /etc/hosts:
> 127.0.0.1 crm.local

* execute bash script to run project's containers
> ./make up -d

* go inside the php fpm container

> docker exec -it docker_crm-php-fpm_1 bash

* install all project dependencies

> composer install

* go to browser and open the link below

> http://crm.local

### PHP Code sniffer
> ./vendor/bin/phpcs

### PSALM
> ./vendor/bin/psalm


### PHPUnit
> ./vendor/bin/phpunit