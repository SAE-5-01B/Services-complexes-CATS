#!/bin/bash

# Récupère l'adresse IP principale de la machine
server_ip=$(hostname -I | awk '{print $1}')

# Affiche l'adresse IP récupérée
echo "Adresse IP du serveur détectée : $server_ip"

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
else
    echo "Le fichier template $php_template n'existe pas."
    exit 1
fi
