FROM eksponent/php-5.3-fpm

# Install modules
RUN apt-get update && apt-get install -y  --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpq-dev \
    apt-utils \
    mysql-client \
    zlib1g-dev \
    imagemagick \
    libxml2-dev \
    unzip \
    libmcrypt-dev

RUN docker-php-ext-install mbstring \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install  gd \
    && docker-php-ext-install  zip \
    && docker-php-ext-install  mcrypt \
    && docker-php-ext-install  mysqli

RUN curl -L https://pecl.php.net/get/redis-2.2.8.tgz > /tmp/redis.tgz \
    && mkdir -p /usr/src/php/ext \
    && tar -xvf /tmp/redis.tgz -C /usr/src/php/ext \
    && rm /tmp/redis.tgz \
    && docker-php-ext-install redis-2.2.8

ADD ./entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ADD ./php.ini /usr/local/etc/php/php.ini

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
