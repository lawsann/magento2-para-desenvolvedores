FROM php:7.4-fpm-buster
LABEL maintainer="Fillipe Almeida Dutra <fillipe@querycommerce.com>" \
      Description="Servidor de aplicação sugerido para o livro Magento 2 para desenvolvedores." \
      Version="1.0.0"

RUN apt-get update && apt-get install -y \
  cron \
  git \
  gzip \
  libbz2-dev \
  libfreetype6-dev \
  libicu-dev \
  libjpeg62-turbo-dev \
  libmcrypt-dev \
  libonig-dev \
  libpng-dev \
  libsodium-dev \
  libssh2-1-dev \
  libxslt1-dev \
  libzip-dev \
  lsof \
  default-mysql-client \
  vim \
  zip \
  procps

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
  bcmath \
  bz2 \
  calendar \
  exif \
  gd \
  gettext \
  intl \
  mbstring \
  mysqli \
  opcache \
  pcntl \
  pdo_mysql \
  soap \
  sockets \
  sodium \
  sysvmsg \
  sysvsem \
  sysvshm \
  xsl \
  zip


#RUN pecl channel-update pecl.php.net \
#  && pecl install xdebug

#RUN docker-php-ext-enable xdebug

RUN groupadd -g 1000 magento \
    && useradd -g magento -u 1000 -d /home/magento -s /bin/bash magento

RUN curl -sSLO https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 \
  && chmod +x mhsendmail_linux_amd64 \
  && mv mhsendmail_linux_amd64 /usr/local/bin/mhsendmail

RUN curl -sS https://getcomposer.org/installer | \
    php -- --2 --install-dir=/usr/local/bin --filename=composer

COPY conf/www.conf /usr/local/etc/php-fpm.d/
COPY conf/php.ini /usr/local/etc/php/
COPY conf/php-fpm.conf /usr/local/etc/

RUN mkdir -p /sock /var/www /var/www/magento /home/magento \
    && chown -R magento:magento /var/www/magento /usr/local/etc/php/conf.d /sock /home/magento

USER magento:magento
VOLUME /var/www/magento
WORKDIR /var/www/magento/