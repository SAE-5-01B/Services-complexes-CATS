const KeycloakService = {
    login: function() {
        keycloak.login();
    },
    logout: function() {
        keycloak.logout();
    },
    getUserInfo: function() {
        return {
            username: keycloak.tokenParsed.preferred_username,
            email: keycloak.tokenParsed.email,
            roles: keycloak.tokenParsed.realm_access.roles
        };
    },
};