

**Beshbarmaq Food - Restaurant Franco-Kazakh**

Bienvenue dans le projet **Beshbarmaq Food**, un site web pour un restaurant franco-kazakh. Ce projet est développé avec le framework Symfony et utilise plusieurs fonctionnalités modernes pour la gestion des réservations, des commandes, des employés, et bien plus encore.

**Prérequis**

Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre machine :

- PHP 8.1 ou supérieur
- Composer
- Symfony CLI
- MySQL ou tout autre SGBD compatible avec Doctrine ORM
- Node.js et npm (pour gérer les dépendances frontend si nécessaire)

**Installation**

Suivez ces étapes pour installer et configurer le projet :

1. Cloner le dépôt

Clonez le dépôt depuis GitHub :

```
git clone https://github.com/votre-utilisateur/votre-repository.git
cd votre-repository
```

---



### 2. Installer les dépendances PHP

Utilisez Composer pour installer les dépendances :

```bash
composer install
```

### 3. Configurer l'environnement

Créez un fichier `.env` en copiant le fichier `.env` et modifiez-le selon votre configuration locale :

```bash
cp .env .env
```

Dans le fichier `.env`, configurez les paramètres suivants :

```env
APP_ENV=dev
APP_SECRET=your-secret-key
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
```

### 4. Créer la base de données

Créez la base de données en utilisant la commande Doctrine :

```bash
php bin/console doctrine:database:create
```

### 5. Effectuer les migrations

Exécutez les migrations pour créer les tables nécessaires :

```bash
php bin/console doctrine:migrations:migrate
```

### 6. Installer les dépendances frontend (facultatif)

Si le projet utilise des outils frontend, installez les dépendances avec npm :

```bash
npm install
npm run dev
```

### 7. Lancer le serveur Symfony

Lancez le serveur de développement Symfony :

```bash
symfony serve
```

Accédez à votre projet en ouvrant votre navigateur et en vous rendant sur [http://localhost:8000](http://localhost:8000).

## Utilisation

Une fois le projet installé et en cours d'exécution, vous pouvez accéder aux différentes fonctionnalités du site :

- **Page d'accueil** : Présentation générale du restaurant.
- **Menus** : Visualisation des plats et des boissons disponibles.
- **Réservations** : Formulaire pour effectuer des réservations en ligne.
- **Blog** : Accès aux articles de blog.
- **Espace employé** : Gestion des commandes, des employés, etc.

## Environnements de développement et de production

Le projet peut être exécuté en mode développement ou production. Pour basculer entre les environnements, modifiez la variable `APP_ENV` dans le fichier `.env`.

- **Dev** : `APP_ENV=dev`
- **Prod** : `APP_ENV=prod`

## Déploiement

Pour déployer ce projet en production, suivez les étapes standards de déploiement Symfony, notamment :

1. Configuration des environnements.
2. Exécution des migrations en production.
3. Optimisation du cache et des assets.

## Auteurs

- [RedaKH](https://github.com/RedaKH)

---

Merci d'avoir utilisé **Beshbarmaq Food** !


