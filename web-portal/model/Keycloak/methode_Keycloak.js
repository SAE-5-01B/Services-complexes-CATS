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
            roles: keycloak.tokenParsed.realm_access.roles,
            firstNameAndLastName: keycloak.tokenParsed.given_name,  // Prénom de l'utilisateur
            lastName: keycloak.tokenParsed.family_name,  // Nom de famille de l'utilisateur
            groups: keycloak.tokenParsed.groups  // Groupes auxquels l'utilisateur appartient
        };
    },

    isauthenticated: function() {
        return keycloak.authenticated;
    },
};