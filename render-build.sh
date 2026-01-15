#!/usr/bin/env bash

# Script de construction pour Render

echo "🚀 Début de l'installation..."

# Mettre à jour les paquets
apt-get update -y

# Installer PHP 8.2 avec les extensions nécessaires
apt-get install -y \
    php8.2 \
    php8.2-cli \
    php8.2-common \
    php8.2-mysql \
    php8.2-zip \
    php8.2-gd \
    php8.2-mbstring \
    php8.2-curl \
    php8.2-xml \
    php8.2-bcmath \
    php8.2-tokenizer \
    php8.2-dom \
    php8.2-simplexml \
    php8.2-fileinfo

# Installer Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer Node.js et NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt-get install -y nodejs

# Vérifier les versions installées
echo "PHP version: $(php --version | head -n 1)"
echo "Composer version: $(composer --version)"
echo "Node.js version: $(node --version)"
echo "NPM version: $(npm --version)"

# Aller dans le répertoire de l'application
cd /opt/render/project/src

# Installer les dépendances PHP
echo "📦 Installation des dépendances Composer..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Installer les dépendances NPM
echo "📦 Installation des dépendances Node.js..."
if [ -f "package.json" ]; then
    npm ci --only=production
    npm run build
fi

# Générer la clé d'application Laravel
echo "🔑 Génération de la clé d'application..."
php artisan key:generate --force

# Mettre en cache la configuration
echo "⚡ Optimisation de l'application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Créer le lien de stockage
echo "📁 Configuration du stockage..."
php artisan storage:link

# Définir les permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "✅ Construction terminée avec succès!"