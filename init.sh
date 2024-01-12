#!/bin/bash

# Récupère l'adresse IP principale de la machine
server_ip=$(hostname -I | awk '{print $1}')

# Affiche l'adresse IP récupérée
echo "Adresse IP du serveur détectée : $server_ip"

#-------------------------------------------------------------------------#

# Chemin vers le fichier template JSON et le fichier de destination
json_template="./data/REALM/royaumeV4_Template.json"
json_file="./data/REALM/royaumeV4.json"

# Vérifie si le fichier template JSON existe
if [ -f "$json_template" ]; then
    # Copie le fichier template en fichier de destination
    cp "$json_template" "$json_file"

    # Remplace toutes les occurrences de SERVER_IP dans le fichier de destination
    sed -i "s/SERVER_IP/$server_ip/g" "$json_file"
    echo "Les occurrences de SERVER_IP dans $json_file ont été remplacées par $server_ip"
else
    echo "Le fichier template $json_template n'existe pas."
    exit 1
fi

#-------------------------------------------------------------------------#

# Chemin vers le fichier serverConfig.js dans le dossier web-portal
config_js_file="./web-portal/serverConfig.js"

# Écriture ou mise à jour de l'adresse IP dans serverConfig.js
echo "const serverIp = \"$server_ip\";" > "$config_js_file"

echo "Le fichier $config_js_file a été mis à jour avec l'adresse IP du serveur : $server_ip"

# Chemin vers le fichier .env
env_file="./.env"

# Vérifie si le fichier .env existe
if [ ! -f "$env_file" ]; then
    echo "Le fichier .env n'existe pas au chemin spécifié."
    exit 1
fi

# Vérifie si la variable SERVER_IP existe déjà dans le fichier .env
if grep -q "SERVER_IP=" "$env_file"; then
    # Remplace la valeur existante
    sed -i "s/^SERVER_IP=.*/SERVER_IP=$server_ip/" "$env_file"
else
    # Ajoute la variable SERVER_IP à la fin du fichier si elle n'existe pas
    echo "SERVER_IP=$server_ip" >> "$env_file"
fi

echo "Le fichier .env a été mis à jour avec l'adresse IP du serveur : $server_ip"

# Lancement du docker-compose
docker compose up -d

#-------------------------------------------------------------------------#

url="http://$server_ip:9080"
max_attempts=2000
current_attempt=1

while [ $current_attempt -le $max_attempts ]; do
    response_code=$(curl -s -o /dev/null -w "%{http_code}" $url)

    if [ $response_code -eq 200 ]; then
        echo "La page $url est disponible !"
        break
    elif [ $response_code -eq 400 ]; then
        echo "La page $url renvoie une erreur 400. Exécution des commandes suivantes :"

        # Chemin vers le fichier template PHP et le fichier de destination
        php_template="./config_template.php"
        php_file="./data/nextcloud_data/config/config.php"

        # Vérifie si le fichier template PHP existe
        if [ -f "$php_template" ]; then
            # Copie le fichier template en fichier de destination
            cp "$php_template" "$php_file"

            # Remplace toutes les occurrences de SERVER_IP dans le fichier de destination
            sed -i "s/SERVER_IP/$server_ip/g" "$php_file"
            echo "Les occurrences de SERVER_IP dans $php_file ont été remplacées par $server_ip"

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

        else
            echo "Le fichier template $php_template n'existe pas."
            exit 1
        fi

        break
    else
        echo "Tentative $current_attempt : La page n'est pas encore disponible (Code HTTP: $response_code)"
        current_attempt=$((current_attempt + 1))
        sleep 2
    fi
done

if [ $current_attempt -gt $max_attempts ]; then
    echo "La page n'est pas disponible après $max_attempts tentatives."
fi

