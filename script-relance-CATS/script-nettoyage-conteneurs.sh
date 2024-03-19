
#!/bin/bash

echo "Stopping all Docker containers..."
docker stop $(docker ps -aq)

echo "Removing all Docker containers..."
docker rm $(docker ps -aq)

echo "All Docker containers have been stopped and removed."
