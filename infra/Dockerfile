FROM php:8.2-fpm

# Instalar dependências necessárias para Symfony
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    postgresql-client \ 
    && docker-php-ext-install intl pdo pdo_mysql pdo_pgsql zip opcache \
    && docker-php-ext-enable opcache

# Instalar o wait-for-it para verificar a inicialização dos serviços de banco de dados
ADD https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar o arquivo .env para dentro do reconhecimentoFacialApi
COPY .env.prod /var/www/html/.env

# Copiar o arquivo de configuração do PHP-FPM para o container
COPY infra/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY infra/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Criar o diretório de cache para o Nginx e ajustar permissões
RUN mkdir -p /var/cache/nginx \
    && chown -R www-data:www-data /var/cache/nginx

# Copiar o código da aplicação Symfony
WORKDIR /var/www/html
COPY reconhecimentoFacialApi /var/www/html
# Instalar dependências do Symfony

RUN composer update

RUN composer install

# Dar permissões corretas para a pasta var
RUN chown -R www-data:www-data /var/www/html/var

# Expor a porta 9000 para o PHP-FPM
EXPOSE 9000
