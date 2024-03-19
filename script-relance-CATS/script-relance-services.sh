#!/bin/bash

# Navigate to the directory containing the docker-compose.yml file
cd ../  # Assuming the script is in 'script-relance-CATS' and docker-compose is just above this directory

# Stopping all running containers to ensure a clean state before restarting
echo "Stopping all running Docker containers..."
docker-compose down

# Adding a brief pause to ensure all containers are fully stopped
sleep 5

# Starting the containers using docker-compose, ensuring all services are up and running
echo "Starting the Docker containers..."
docker-compose up -d

echo "Docker containers have been restarted successfully."
