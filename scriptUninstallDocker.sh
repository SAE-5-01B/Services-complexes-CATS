#!/bin/bash

# Mise à jour des paquets
sudo apt-get update


sudo dpkg -l | grep -i docker

sudo apt-get purge -y docker-engine docker docker.io docker-ce docker-ce-cli docker-compose-plugin
sudo apt-get autoremove -y --purge docker-engine docker docker.io docker-ce docker-compose-plugin

sudo rm -rf /var/lib/docker /etc/docker
sudo rm /etc/apparmor.d/docker
sudo groupdel docker
sudo rm -rf /var/run/docker.sock


# Installation des dépendances nécessaires pour Docker Engine
sudo apt-get install -y\
    apt-transport-https -y\
    ca-certificates -y\
    curl -y\
    gnupg -y\
    lsb-release -y

# Ajout du GPG officiel de Docker
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

# Ajout du repository Docker "stable" pour Docker Engine
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Mise à jour des paquets après l'ajout du repository Docker Engine
sudo apt-get update -y

# Installation de Docker Engine et Docker Compose
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-compose-plugin -y

# Vérification de l'installation de wget
if ! command -v wget &> /dev/null
then
    echo "Installation de wget..."
    sudo apt-get install wget -y
fi

# Téléchargement de Docker Desktop
wget https://desktop.docker.com/linux/main/amd64/docker-desktop-4.26.1-amd64.deb -O docker-desktop.deb

# Installation de Docker Desktop
sudo apt-get install ./docker-desktop.deb -y

# Nettoyage du fichier téléchargé
rm docker-desktop.deb

sudo usermod -aG docker $USER

sudo systemctl stop apparmor
sudo systemctl disable apparmor

sudo systemctl start docker


# Vérification de l'installation de Docker
sudo docker run hello-world


