export $(cat ./.env)
envsubst < ./init/ldap_init.ldif.template > init/ldap_init.ldif

docker compose down
docker compose up -d 

sleep 5
docker exec -it ldap_server_container ldapadd -x -D cn=admin,dc=$DOMAINENIV2,dc=$DOMAINENIV1 -w $LDAP_ADMIN_PASSWORD -f /init/ldap_init.ldif

echo "Services are running"
