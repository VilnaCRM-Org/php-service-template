FROM php:8.1

WORKDIR '/app'

RUN docker-php-ext-enable opcache

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN echo 'export PATH="$HOME/.symfony/bin:$PATH"' >> /root/.bashrc

RUN echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

RUN chmod -R 0777 /var/log/
RUN mkdir -p /var/run/
RUN chmod -R 0777 /var/run/

EXPOSE 22