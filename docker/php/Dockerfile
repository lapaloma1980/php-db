ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm

LABEL maintainer="Sven Schicketanz <s.schicketanz@pyrexx.com>"

ARG UID
ARG GID
ARG PHP_EXTRA_CONFIG_FILE
ARG XDEBUG_PORT
ARG COMPOSER_SSH_PUB_KEY
ARG COMPOSER_SSH_PRIV_KEY

ENV DEBIAN_FRONTEND noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
    apt-utils git unzip

# --- sockets Extension -------------------------------------------------------------
RUN docker-php-ext-install -j$(($(nproc)-1)) sockets

# --- zip Extension ------------------------------------------------------------
RUN apt-get install -y zlib1g-dev libzip-dev \
    && docker-php-ext-install -j$(($(nproc)-1)) zip

# --- soap Extension ------------------------------------------------------------
RUN apt-get update \
    && apt-get install -y libxml2-dev \
    && docker-php-ext-install -j$(($(nproc)-1)) soap

# --- PDO and Co. --------------------------------------------------------------
RUN apt-get update \
    && docker-php-ext-install -j$(($(nproc)-1)) pdo_mysql

# --- xdebug Extension ---------------------------------------------------------
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# --- install locales ----------------------------------------------------------
RUN apt-get install -y locales \
	&& localedef -i en_GB -c -f UTF-8 -A /usr/share/locale/locale.alias en_GB \
	&& localedef -i de_DE -c -f UTF-8 -A /usr/share/locale/locale.alias de_DE

# --- apt & pear cleanup -------------------------------------------------------
RUN rm -rf /tmp/pear \
    && rm -r /var/lib/apt/lists/*


# --- composer -----------------------------------------------------------------
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# --- create user and group for application ------------------------------------
RUN useradd -u${UID} -mUs /bin/bash app

# --- set php-fpm to run as app user -------------------------------------------
RUN echo "user = app" >> /usr/local/etc/php-fpm.d/www.conf
RUN echo "group = app" >> /usr/local/etc/php-fpm.d/www.conf

# --- switch to app user for the test of the commands --------------------------
USER app

# --- copy ssh pub/priv keys into the app user's home directory ----------------
COPY --chown=app:app ./.ssh/id_rsa /home/app/.ssh/id_rsa
COPY --chown=app:app ./.ssh/id_rsa.pub /home/app/.ssh/id_rsa.pub

# --- some basice bash setup ---------------------------------------------------
RUN echo 'alias l="ls -lah"' >> /home/app/.bashrc
RUN echo 'stty cols 120 rows 60' >> /home/app/.bashrc

EXPOSE ${XDEBUG_PORT}

WORKDIR /var/www/html
