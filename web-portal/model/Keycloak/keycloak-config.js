const keycloakConfig = {
    url: 'http://localhost:8080/', // URL de votre serveur Keycloak
    realm: 'CATS', // Le nom de votre realm
    clientId: 'b74fb1bc-6057-4234-bef6-17d9cd47d9b6', // L'ID de votre client Keycloak
};
const keycloak = new Keycloak(keycloakConfig);
