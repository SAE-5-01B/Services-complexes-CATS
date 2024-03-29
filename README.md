# CATS - Central Authentication & Technology Services

Bienvenue sur le dépôt officiel du projet CATS. 

## Présentation

Tout d'abord que veut dire CATS ? CATS signifie Central Authentication & Technology Services.

Ce projet a pour but de centraliser des services qu'une entreprise aurait besoin.

## Services

Les services présents dans ce projet sont les suivants :

Côté Frontend :

- **Serveur Apache** : Mise en place d'un serveur Apache pour centraliser et faciliter l'accès aux différents services.

- **RocketChat** : Intégration de RocketChat, un service de messagerie instantanée, optimisant la communication interne.

- **NextCloud** : Configuration de NextCloud pour le stockage et la gestion des fichiers, offrant une solution robuste pour le dépôt de fichiers.

Côté Backend :

- **Keycloak** : Implémentation de Keycloak pour l'authentification des utilisateurs, un élément clé pour la gestion de l'identité et l'accès.

- **Plusieurs bases de Données** : Établissement d'une base de données pour assurer la persistance et la sécurité des données utilisateurs.

- **LDAP** : Utilisation de LDAP comme annuaire pour stocker les informations des clients, garantissant une gestion efficace des utilisateurs.

- **Nginx** : Mise en place d'un serveur Nginx pour la gestion des requêtes et la communication entre les différents services.

## Structure des applications

Dans le diagramme ci-dessous, vous pouvez voir la structure des applications et leurs relations.

![structureApplications.png](imgREADME%2FstructureApplications.png)

## Installation

Nous avons conçu ce projet pour qu'il soit installé sur un serveur Linux.

C'est pour cela que nous avons deux scripts qui permettent d'installer les services sur un serveur Linux.

### Script n°1 : Installation de docker

Docker est essentiel pour l'installation de nos services. C'est pour cela que nous avons créé un script qui permet d'installer docker sur un serveur Linux.

Ce script ne fait pas que simplement installer docker, il fait d'abord une désinstallation de docker s'il est déjà installé, puis il installe docker et docker-compose sur 
des bases saines.

Pour lancer ce script, placez-vous à la racine du projet et executez les commandes suivantes :

```bash
chmod +x scriptPurgeDocker.sh
./scriptPurgeDocker.sh
```

À noter que ce script n'est pas obligatoire si vous avez déjà installé docker sur votre serveur Linux.

### Script n°2 : Installation des services

Ce script permet d'installer tous les services du projet et égalment les configurer. 

Pour lancer ce script, placez-vous à la racine du projet et executez les commandes suivantes :

```bash
chmod +x ./init.sh
./init.sh
```

## Test de l'installation :

### Test du script n°1 : Installation de docker

Ouvrez un terminal et placez-vous à la racine du projet. Puis, executez les commandes suivantes :

![lancementScriptDocker.png](imgREADME%2FlancementScriptDocker.png)

La purge de docker et l'installation de docker sont en cours.

Normalement, vous devriez avoir ce résultat :

![scriptDockerReussite.png](imgREADME%2FscriptDockerReussite.png)


### Test du script n°2 : Installation des services

Pour l'installation des services, rendez-vous à la racine du projet et executez les commandes suivantes :

![lancementScriptInitialisation.png](imgREADME%2FlancementScriptInitialisation.png)

L'execution du script en sudo est obligatoire pour l'installation des services.

Voici le résultat de l'execution du script :

![scriptServiceReussite.png](imgREADME%2FscriptServiceReussite.png)

Maintenant, vous n'avez plus qu'à accéder aux services, car tout est installé et configuré.

## Accès aux services : 

Pour accéder aux services, vous devez vous rendre sur l'adresse IP de votre serveur Linux.

Par défaut si vous accédez à l'url https://adresseIPServeur, vous allez tomber sur le portail de connexion CATS.

![portailCATS.png](imgREADME%2FportailCATS.png)

Après vous avoir authentifié avec les logins fournis lors de la livraison du projet, vous allez tomber sur la page d'accueil de CATS.

![CATSServices.png](imgREADME%2FCATSServices.png)

Sur cette page, vous avez accès à tous les services du projet, et comme il y a la mise en place d'un SSO, vous n'avez pas besoin de vous authentifier à chaque fois que vous accédez à un service.


## Nous contacter

Si vous avez des problèmes avec l'installation ou si vous avez des questions, vous pouvez nous contacter à l'une des adresses suivantes :

gaetan.gonfinatini@gmail.com
