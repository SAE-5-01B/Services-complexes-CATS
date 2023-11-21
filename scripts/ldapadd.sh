#!/bin/bash

# Vérifie s'il y a un argument en entrée
if [ $# -ne 1 ]; then
    echo "Usage: $0 fichier.ldif"
    exit 1
fi

# Vérifie si le fichier en entrée existe
if [ ! -f "$1" ]; then
    echo "Le fichier $1 n'existe pas."
    exit 1
fi

# Copie le fichier *.ldif dans le répertoire ./init/ldif.ldif
cp "$1" ./init/ldif.ldif

# Vérifie si la copie a réussi
if [ $? -eq 0 ]; then

    export $(cat ./.env)    
    docker exec -it ldap_server_container ldapadd -x -D cn=admin,dc=$DOMAINENIV2,dc=$DOMAINENIV1 -w $LDAP_ADMIN_PASSWORD -f /init/ldif.ldif

    # Supprime le fichier créé
    rm ./init/ldif.ldif
    echo "Fichier ./init/ldif.ldif supprimé."
else
    echo "Erreur lors de la copie du fichier."
fi

