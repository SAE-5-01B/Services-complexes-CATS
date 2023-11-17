# Application-Web

## Description

Cette application web intègre un serveur web sophistiqué conçu pour authentifier les utilisateurs via un service LDAP. 
Après une authentification réussie, l'utilisateur est redirigé vers la page d'accueil, qui offre une vue détaillée des informations de son compte LDAP ainsi que des services auxquels il a accès.

Selon les privilèges de l'utilisateur, il peut accéder à certains services.

Les utilisateurs clients ont accès à :

- Accès à sa base de données. 
- Accès à "nextcloud" qui est un service de stockage de fichiers en ligne.

Les utilisateurs administrateurs ont accès à :

- Accès à sa base de données.
- Accès à "nextcloud" qui est un service de stockage de fichiers en ligne.
- Accès à "phpldammin" qui est un service de gestion de base de données LDAP.

## Guide utilisateur    




## Détails techniques 

Ce site à été développé en utilisant les bonnes pratiques de programmation, donc facilement maintenable et évolutif.

Notamment ce site utilise le modèle MVC (Modèle-Vue-Contrôleur). 




## Sécurisation du site

Dans le cadre de la mise en place de la sécurité sur notre site, nous avons opté pour un certificat SSL auto-signé afin de mettre en œuvre une communication chiffrée entre le client et le serveur.

### Génération du certificat auto-signé

Pour créer ce certificat, nous avons utilisé la librairie OpenSSL, qui est un outil robuste pour la gestion de certificats et autres fonctionnalités liées à la cryptographie. La commande suivante a été utilisée pour générer le certificat :

```bash
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout localhost.key -out localhost.crt
```

Cette commande produit deux fichiers :

- `localhost.key` : Il s'agit de la clé privée.
- `localhost.crt` : Il s'agit du certificat auto-signé.

Le certificat sera valide pendant 365 jours à compter de sa date de création.

## Configuration du serveur Apache

La mise en place de la sécurité SSL/TLS nécessite certaines configurations sur le serveur Apache. Voici les étapes suivies pour la configuration :

### 1. Création d'un VirtualHost

Pour servir le contenu via HTTPS, nous avons configuré un `VirtualHost` pour écouter sur le port 443. Voici la configuration :

```apache
<VirtualHost *:443>
ServerName  localhost
DocumentRoot /var/www/html
SSLEngine on
SSLCertificateFile /etc/ssl/certs/localhost.crt
SSLCertificateKeyFile /etc/ssl/private/localhost.key
</VirtualHost>
```

### 2. Modification du port d'écoute

Par défaut, Apache écoute sur le port 80 pour les requêtes HTTP. Puisque nous configurons le serveur pour utiliser HTTPS, nous avons modifié Apache pour qu'il écoute sur le port 443, le port standard pour les requêtes HTTPS.

### 3. Activation du module SSL sur Apache

Le support SSL/TLS sur Apache nécessite que le module `mod_ssl` soit activé. Cette étape est essentielle pour que la configuration précédente fonctionne correctement.


### Limitations et précautions

Il est important de noter que les certificats auto-signés ne sont pas reconnus comme étant de confiance par les navigateurs par défaut. 
Les utilisateurs se verront donc présenter un avertissement de sécurité lorsqu'ils accèdent au site pour la première fois. 
Pour contourner cet avertissement en environnement de développement, le certificat doit être ajouté manuellement à la liste des certificats de confiance du navigateur. 
Cependant, cette approche n'est pas recommandée pour les environnements de production.

### Alternative : Certificats valides

Pour un environnement de production, il est essentiel d'utiliser un certificat émis par une autorité de certification (CA) reconnue. 
Ces certificats sont automatiquement reconnus par la plupart des navigateurs, garantissant ainsi que la communication est sécurisée sans avertissements inutiles pour les utilisateurs finaux. 
Une des autorités de certification gratuites et populaires est "Let's Encrypt". Pour obtenir un tel certificat, il est nécessaire d'avoir un nom de domaine public.
