# ReSourcesRelationnelles 
![GitHub release (latest by date)](https://img.shields.io/github/v/release/Illenhad/ReSourcesRelationnelles?style=plastic)

**CESI Alternance**  
*Projet pédagogique*  
Le projet « (RE)Sources Relationnelles est une simulation d’un projet qui pourrait être porté par le Ministère des Solidarités et de la Santé à destination des citoyens afin de proposer une plateforme de sources, ressources, et d’échanges. 

## Installation

### Récupérer le projet 
```
git clone https://github.com/Illenhad/ReSourcesRelationnelles.git
```

### Installer les dépendances
_Pour installer composer : https://getcomposer.org/_
```
cd chemin/vers/projet
composer install
```

### Variables locale
* Pour renseigner les variables locales, créer un fichier **.env.local** au même niveau que le fichier **.env**
* Renseigner le chemin vers la base de données

Exemple : 
```
###> doctrine/doctrine-bundle ###
DATABASE_URL="mysql://user:password@localhost:3306/REsourcesRelationnelles"
###< doctrine/doctrine-bundle ###
```

### Créer et alimenter la base de données

Dans un terminal, lancer les commandes :

```
php bin\console doctrine:database:create
php bin\console doctrine:schema:create
php bin\console doctrine:fixtures:load
```

*Ne pas oublier de lancer le server de base de données*

### Lancer le serveur
```
php -S localhost:8000 -t public
```

## Comptes
Pour permettre l'utilisation rapide du produit, des comptes ont été créé.


| Rôle                | Identifiant   | Mot de passe  |
| ------------------- |:-------------:|:-------------:|
| Super administrateur| bigboss       | admin         |
| Administrateur      | jeaaaanne     | admin         |
| Modérateur          | mamienova     | admin         |
| Utilisateur         | aliceclt      | user          |
