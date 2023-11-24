const KeycloakService = {
    login: function() {
        keycloak.login();
    },
    logout: function() {
        keycloak.logout();
    },
    getUserInfo: function() {
        return {
            token: keycloak.tokenParsed,
            username: keycloak.tokenParsed.preferred_username,
            email: keycloak.tokenParsed.email,
            roles: keycloak.tokenParsed.realm_access.roles,
            firstNameAndLastName: keycloak.tokenParsed.given_name,
            lastName: keycloak.tokenParsed.family_name,
            groups: keycloak.tokenParsed.groups
        };
    },
    isauthenticated: function() {
        return keycloak.authenticated;
    },


};