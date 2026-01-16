# ==========================================
# Base PHP 8.4 avec Apache
# ==========================================
FROM php:8.4-apache

# ==========================================
# Installer extensions PHP et outils
# ==========================================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && a2enmod rewrite

# ==========================================
# Installer Composer
# ==========================================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ==========================================
# Installer Node.js pour frontend (optionnel)
# ==========================================
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
 && apt-get install -y nodejs

# ==========================================
# Définir le répertoire de travail et copier le projet
# ==========================================
WORKDIR /var/www/html
COPY . .

# ==========================================
# Installer dépendances PHP
# ==========================================
RUN composer install --no-dev --optimize-autoloader

# ==========================================
# Installer dépendances frontend si package.json existe
# ==========================================
RUN if [ -f "package.json" ]; then npm install && npm run build; fi

# ==========================================
# Configurer permissions Laravel
# ==========================================
RUN chmod -R 775 storage bootstrap/cache

# ==========================================
# Configurer Apache pour pointer sur /public
# ==========================================
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# ==========================================
# Exposer le port par défaut Render
# ==========================================
EXPOSE 80

# ==========================================
# Script pour attendre la DB et lancer migrations + Apache
# ==========================================
RUN echo '#!/bin/bash\n\
echo "Attente de la DB..."\n\
until pg_isready -h $DB_HOST -p $DB_PORT -U $DB_USERNAME; do sleep 2; done\n\
echo "DB prête !"\n\
php artisan config:clear\n\
php artisan cache:clear\n\
php artisan migrate --force\n\
apache2-foreground' > /wait-for-db.sh

RUN chmod +x /wait-for-db.sh

# ==========================================
# Commande finale
# ==========================================
CMD ["/wait-for-db.sh"]
