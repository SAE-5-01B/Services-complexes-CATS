docker compose down
docker rm ldap_server_container
docker rm ldap_phpldapadmin_container
docker rm ldap_web_portal_container
docker rm nextcloud_db
docker rm nextcloud_app

rm -rf data/*
