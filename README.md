# Gestion des Demandes de Congés et Permissions

Une application web complète pour la gestion des demandes de congés et de permissions des employés, développée avec Laravel 12.

## 🚀 Fonctionnalités Clés

### Pour les Employés
- **Authentification Sécurisée** : Inscription et connexion.
- **Tableau de Bord** : Vue d'ensemble de l'état des demandes.
- **Nouvelle Demande** : Formulaire simple pour soumettre des demandes de congés ou permissions.
- **Suivi des Demandes** : Historique complet avec statut (En attente, Approuvée, Rejetée, Brouillon).
- **Export PDF** : Téléchargement de l'historique des demandes en format PDF.

### Pour les Administrateurs
- **Gestion des Demandes** : Voir toutes les demandes en attente.
- **Approbation/Rejet** : Valider ou refuser les demandes avec un commentaire explicatif (obligatoire pour les rejets).
- **Historique Global** : Vue filtrable de toutes les demandes traitées.
- **Statistiques** : Aperçu rapide des activités récentes.

## 🛠 Stack Technique

- **Backend** : Laravel 12.0
- **Frontend** : Blade, Tailwind CSS v3/v4, Alpine.js
- **Base de Données** : MySQL
- **Outils** :
    - `barryvdh/laravel-dompdf` pour la génération de PDF.
    - `laravel/breeze` pour l'authentification.
    - `vite` pour la compilation des assets.

## ⚙️ Prérequis

Assurez-vous d'avoir installé :
- [PHP](https://www.php.net/) (v8.2 ou supérieur)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) & NPM

## 📥 Installation

1. **Cloner le projet**
   ```bash
   git clone <votre-url-repo>
   cd essai2
   ```

2. **Installation Automatisée**
   Le projet inclut un script de configuration rapide qui installe les dépendances, configure l'environnement et lance les migrations.
   ```bash
   composer run setup
   ```
   
   *Si vous préférez l'installation manuelle :*
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   npm install
   npm run build
   ```

3. **Création du compte Admin (Seeder)**
   Une commande Seeder est disponible pour créer un administrateur par défaut.
   ```bash
   php artisan db:seed --class=AdminUserSeeder
   ```

   **Identifiants par défaut :**
   - Email : `admin@example.com`
   - Mot de passe : `password`

## 🖥️ Utilisation

### Lancer le serveur de développement
Pour lancer l'application (serveur PHP, worker de queue, et Vite) en une seule commande :
```bash
composer run dev
```
Accédez ensuite à l'application sur : `http://localhost:8000`

### Accès
- **Page d'accueil** : `/`
- **Login** : `/login`
- **Register** : `/register`

## 📁 Structure du Projet

- `app/Models` : Modèles de données (User, Demande, etc.)
- `app/Http/Controllers` : Logique mérier (AdminController, DemandeController).
- `resources/views` : Vues Blade (pages admin, pages employés).
- `database/migrations` : Structure de la base de données.
- `routes/web.php` : Définition des routes de l'application.

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à ouvrir une "Issue" ou une "Pull Request".

## 📄 Licence

Ce projet est sous licence [MIT](https://opensource.org/licenses/MIT).
