
const keycloakConfig = {
    url: `http://${serverIp}:8080/`, // URL de votre serveur keycloak
    realm: 'CATS', // Le nom de votre realm
    clientId: 'portal-cats', // L'ID de votre client keycloak
};
const keycloak = new Keycloak(keycloakConfig);
