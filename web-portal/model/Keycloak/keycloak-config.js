
const keycloakConfig = {
    url: `http://${serverIp}:8080/`, // URL de votre serveur Keycloak
    realm: 'CATS', // Le nom de votre realm
    clientId: 'portal-cats', // L'ID de votre client Keycloak
};
const keycloak = new Keycloak(keycloakConfig);
