# Application de Gestion de Recettes Culinaires

Application web complète pour la gestion de recettes de cuisine avec système d'authentification, gestion des ingrédients, notation des recettes et commandes.

## Prérequis

- PHP 8.0+
- Composer 2.0+
- MySQL 8.0+
- Node.js 14+ (pour les assets frontend)
- Serveur web (Apache/Nginx) ou PHP built-in server

## Installation

### 1. Cloner le dépôt


git clone https://github.com/votre-repo/gestion-recettes.git
cd gestion-recettes


### 2. Installer les dépendances PHP


composer install


### 3. Installer les dépendances JavaScript


npm install
npm run build


### 4. Configurer l'environnement

Copier le fichier `.env.example` vers `.env` et modifier les paramètres :


cp .env.example .env


Éditer le fichier `.env` et configurer notamment :


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_votre_base
DB_USERNAME=utilisateur_mysql
DB_PASSWORD=mot_de_passe_mysql


### 5. Générer la clé d'application


php artisan key:generate


### 6. Exécuter les migrations et seeders


php artisan migrate --seed


Ceci va :
- Créer toutes les tables nécessaires
- Créer un utilisateur admin par défaut :
  - Email: `admin@admin.com`
  - Mot de passe: `11111111`
- Initialiser les informations de l'entreprise

### 7. Configurer le stockage (optionnel)

Pour permettre le stockage des images :


php artisan storage:link


### 8. Démarrer l'application

Pour le développement, vous pouvez utiliser le serveur intégré :


php artisan serve


L'application sera accessible à l'adresse : `http://localhost:8000`

Pour la production, configurez votre serveur web (Apache/Nginx) pour pointer vers le dossier `public`.

## Accès

- **Interface publique** : `/`
- **Interface d'administration** : `/admin`
  - Identifiants admin :
    - Email: `admin@admin.com`
    - Mot de passe: `11111111`

## Fonctionnalités

### Pour les visiteurs
- Voir la liste des recettes
- Voir le détail d'une recette
- Noter et commenter les recettes
- Passer des commandes (sans compte)

### Pour les utilisateurs enregistrés
- Toutes les fonctionnalités visiteurs
- Voir l'historique des commandes
- Modifier son profil

### Pour les administrateurs
- Gestion complète des recettes
- Gestion des ingrédients
- Gestion des utilisateurs
- Visualisation des commandes
- Modération des avis
- Configuration des informations de l'entreprise

## Sécurité

Après installation en production :
1. **Changez immédiatement** le mot de passe admin
2. Mettez à jour les informations de l'entreprise
3. Configurez HTTPS
4. Sauvegardez régulièrement votre base de données

## Licence


Ce README fournit toutes les instructions nécessaires pour installer et configurer l'application, tout en restant clair et concis.