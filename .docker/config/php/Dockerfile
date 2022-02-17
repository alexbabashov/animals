FROM  php:8.2-fpm

ARG uid=1000
ARG user=www
ARG group=www

#ENV TZ=Europe/Moscow
#RUN rm /etc/localtime && mkdir /etc/localtime
#RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
#RUN printf '[PHP]\ndate.timezone = "Europe/Moscow"\n' > /usr/local/etc/php/conf.d/tzone.ini

RUN apt-get update && apt-get install -y \
    build-essential \
    wget \
    curl \
    cron \
    git \
    openssl \
    sendmail \
    unzip \
    libzip-dev \
    zip \
    locales \
    vim \
    #mysql-client \
    dpkg-dev \
    libpq-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libfreetype6-dev \
    libxml2-dev \
    libxpm-dev \
    jpegoptim optipng pngquant gifsicle \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli

#ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
#RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
#   install-php-extensions mbstring pdo_mysql zip exif pcntl gd

# nvm environment variables
ENV NVM_DIR /usr/local/nvm
ENV NODE_VERSION 16.14.0

RUN mkdir -p "$NVM_DIR" ; \
    curl -o- "https://raw.githubusercontent.com/nvm-sh/nvm/master/install.sh" | bash ;\
    /bin/bash -c "source $NVM_DIR/nvm.sh  \
    && nvm install $NODE_VERSION --latest-npm"

# Use latest npm
RUN npm i npm@latest -g

# add node and npm to path so the commands are available
ENV NODE_PATH $NVM_DIR/v$NODE_VERSION/lib/node_modules
ENV PATH $NVM_DIR/versions/node/v$NODE_VERSION/bin:$PATH

#install VueJs
RUN npm install -g @vue/cli

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath
RUN docker-php-ext-configure gd \
    --enable-gd \
    --with-jpeg \
    --with-xpm \
    --with-freetype

    # before PHP 7.4.0
    #--with-gd \
    #--with-webp-dir \
    #--with-jpeg-dir \
    #--with-zlib-dir \
    #--with-png-dir \
    #--with-xpm-dir \
    #--with-freetype-dir

RUN docker-php-ext-install gd

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Add user for laravel application
RUN groupadd -g $uid $group
RUN useradd -g $group -G www-data,root,$group -u $uid -d /home/$user -ms /bin/bash $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

USER $user

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
