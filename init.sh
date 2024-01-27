#!/bin/bash

# Récupère l'adresse IP principale de la machine
server_ip=$(hostname -I | awk '{print $1}')

# Affiche l'adresse IP récupérée
echo "Adresse IP du serveur détectée : $server_ip"

#-------------------------------------------------------------------------#

# Keycloak

# Chemin vers le fichier template JSON et le fichier de destination
json_template="./conf/REALM/royaumeV4_Template.json"
json_file="./conf/REALM/royaumeV4.json"

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

# Web portal

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

sed "s/SERVER_IP/$server_ip/g" ./conf/nginxTemplate.conf > ./conf/nginx.conf
echo "Fichier nginx.conf généré avec l'adresse IP: $server_ip"

# Lancement du docker-compose
docker compose up -d

#-------------------------------------------------------------------------#

# Nextcloud
nextcloud_url="https://$server_ip/nextcloud"
echo "Vérification de l'état de Nextcloud à l'adresse $nextcloud_url"
while true; do
    if wget --no-check-certificate --spider $nextcloud_url 2>/dev/null; then

        echo "Nextcloud est opérationnel à l'adresse $nextcloud_url"
        echo "Execution du script de configuration de Nextcloud..."

        # Faire confiance au certificat auto-signé de Keycloak
        echo "Ajout du certificat auto-signé de Keycloak au magasin de certificats de confiance..."
        docker exec nextcloud_app bash -c "update-ca-certificates"

        # Installer et configurer l'application Social Login
        echo "Installation de Social Login dans Nextcloud..."
        docker exec -u 33 nextcloud_app php /var/www/html/occ app:enable sociallogin

        echo "Configuration de Social Login dans Nextcloud..."
        docker exec -u 33 nextcloud_app php /var/www/html/occ config:app:set sociallogin custom_providers --value="{\"custom_oidc\": [{\"name\": \"keycloak_oidc\", \"title\": \"Keycloak\", \"authorizeUrl\": \"https://$server_ip/keycloak/realms/CATS/protocol/openid-connect/auth\", \"tokenUrl\": \"https://$server_ip/keycloak/realms/CATS/protocol/openid-connect/token\", \"userInfoUrl\": \"https://$server_ip/keycloak/realms/CATS/protocol/openid-connect/userinfo\", \"logoutUrl\": \"\", \"clientId\": \"nextcloud\", \"clientSecret\": \"OcX8Ij59scaLVhJuLWcX84ERsK2RKYkv\", \"scope\": \"openid\", \"groupsClaim\": \"groups\", \"style\": \"keycloak\", \"defaultGroup\": \"\"}]}"

        echo "Social Login configuré avec succès."
        break
    else
        echo "En attente que Nextcloud soit opérationnel..."
        sleep 10
    fi
done
#-------------------------------------------------------------------------#

echo "Le script d'initialisation est terminé."