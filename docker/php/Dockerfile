FROM php:8.3-cli-alpine3.20

ENV COMPOSER_HOME=/.composer
ENV PATH="$PATH:$COMPOSER_HOME/vendor/bin"

RUN mkdir $COMPOSER_HOME && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers postgresql-dev && \
    apk add --no-cache util-linux postgresql && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-install -j"$(nproc)" pdo_pgsql && \
    apk del .build-deps && \
    rm -r /tmp/pear/cache/* /tmp/pear/download/* && \
    curl --silent --fail-early https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    #According Sebastian Bergmann install QA tools outside the project
    composer global require symfony/phpunit-bridge && \
    wget -O php-cs-fixer-v2 https://cs.symfony.com/download/php-cs-fixer-v3.phar && chmod +x php-cs-fixer-v2 && mv php-cs-fixer-v2 /usr/local/bin/php-cs-fixer && \
    wget -O phpstan https://github.com/phpstan/phpstan/releases/download/1.12.7/phpstan.phar && chmod +x phpstan && mv phpstan /usr/local/bin/phpstan && \
    chmod -R o+rwx $COMPOSER_HOME

WORKDIR /app