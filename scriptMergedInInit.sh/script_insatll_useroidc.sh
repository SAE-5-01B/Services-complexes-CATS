#!/bin/bash

# Lire la valeur de SERVER_IP depuis le fichier .env
SERVER_IP=$(grep "SERVER_IP" .env | cut -d '=' -f2)

# Récupérer les conteneurs Docker en cours d'exécution
containers=$(docker ps --format "{{.ID}}\t{{.Names}}\t{{.Ports}}" | grep ":9080->" | cut -f 1)

# Vérifier si des conteneurs sur le port 9080 ont été trouvés
if [ -z "$containers" ]; then
    echo "Aucun conteneur sur le port 9080 n'a été trouvé."
    exit 1
fi

# Parcourir les conteneurs et exécuter les commandes à l'intérieur
for container_id in $containers; do
    echo "Exécution des commandes dans le conteneur $container_id"
    docker exec -it $container_id apt-get update
    docker exec -it $container_id apt-get install sudo

    # Installer le plugin user_oidc avec la valeur de SERVER_IP
    docker exec -it $container_id sudo -u www-data php /var/www/html/occ app:install user_oidc

    # Activer le plugin user_oidc
    docker exec -it $container_id sudo -u www-data php /var/www/html/occ app:enable user_oidc

    # Configurer le provider demoprovider avec la valeur de SERVER_IP
    docker exec -it $container_id sudo -u www-data php /var/www/html/occ user_oidc:provider Keycloak --clientid="nextcloud" --clientsecret="OcX8Ij59scaLVhJuLWcX84ERsK2RKYkv" --discoveryuri="http://$SERVER_IP:8080/realms/CATS/.well-known/openid-configuration"

    # Désactiver l'option "Use unique user id"
    docker exec -it $container_id sudo -u www-data php /var/www/html/occ config:app:set user_oidc use_unique_id --value=false
done

echo "Script terminé."

