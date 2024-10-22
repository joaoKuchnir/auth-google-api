FROM php:8.3-fpm

# Adiciona um novo usuário e grupo com permissões totais
ARG USER=jhon
ARG GROUP=jhon
ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} ${GROUP} && \
    useradd -u ${UID} -g ${GROUP} -m ${USER} && \
    usermod -aG sudo ${USER} && \
    chown -R ${USER}:${GROUP} /var/www

# Define o diretório de trabalho
WORKDIR /var/www

# Copia o conteúdo do diretório atual para o contêiner
COPY . .

# Instala as dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zlib1g-dev \
    zip \
    unzip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala as extensões do PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip xml simplexml
RUN docker-php-ext-enable gd zip xml simplexml
RUN pecl install redis && docker-php-ext-enable redis

# Copia o Composer para o contêiner
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependências do projeto
RUN composer install --prefer-dist --no-dev --no-scripts --no-autoloader

# Define o usuário criado como o usuário padrão do contêiner
USER $USER

# Exponha a porta que o PHP-FPM escuta
EXPOSE 9000

# Comando para iniciar o PHP-FPM (já definido como padrão na imagem php:fpm)
CMD ["php-fpm"]
