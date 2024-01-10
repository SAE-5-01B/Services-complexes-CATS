#!/bin/bash

# Récupère l'adresse IP principale de la machine
server_ip=$(hostname -I | awk '{print $1}')

# Affiche l'adresse IP récupérée
echo "Adresse IP du serveur détectée : $server_ip"

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
docker-compose up -d
