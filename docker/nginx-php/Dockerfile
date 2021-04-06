FROM php:7.4-fpm

# Packages
RUN apt update && \
    apt install -y \
        wget \
        # Nginx
        nginx \
        nginx-extras \
        # PHP
        libicu-dev \
        libonig-dev \
        libxslt-dev \
        libzip-dev \
        icu-devtools \
        libc6-dev \
        zlib1g-dev && \
    apt clean && \
    rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install -j$(nproc) \
        intl \
        pdo_mysql \
        ctype \
        iconv \
        bcmath \
        zip \
        xsl

# Dumb init (process supervisor)
RUN wget -O /usr/local/bin/dumb-init https://github.com/Yelp/dumb-init/releases/download/v1.2.2/dumb-init_1.2.2_amd64 && \
    chmod +x /usr/local/bin/dumb-init

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer && mkdir -p /tmp/.composer && chown nobody: /tmp/.composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME=/tmp/.composer
ENV PATH="${PATH}:/tmp/.composer/vendor/bin"

EXPOSE 80
COPY ./entrypoint.sh /entrypoint.sh
# --rewrite SIGINT (2) (Ctrl + C) to SIGQUIT (3) for graceful stop
# --rewrite SIGTERM (15) to SIGQUIT (3) for graceful stop
ENTRYPOINT ["dumb-init", "--rewrite", "2:3", "--rewrite", "15:3" , "--"]
CMD ["/entrypoint.sh"]
