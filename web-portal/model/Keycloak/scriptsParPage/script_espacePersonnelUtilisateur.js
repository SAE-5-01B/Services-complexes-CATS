window.addEventListener('load', () => {
    const logoutBtn = document.getElementById('logout');
    // Initialiser Keycloak et vérifier si l'utilisateur est connecté
    keycloak.init({ onLoad: 'check-sso' }).then(authenticated => {
        if (authenticated) {
            // Récupérer les informations de l'utilisateur
            const userInfo = KeycloakService.getUserInfo();
            // Mettre à jour le message de bienvenue
            document.getElementById('welcomeMessage').textContent = `Bonjour ${userInfo.firstNameAndLastName}`;
            // Affiche le groupe

        } else {
            // Redirection si non authentifié
            window.location.replace("https://localhost:8443/index.html");
        }
    });
    // Gérer le clic sur le bouton de déconnexion
    logoutBtn.addEventListener('click', () => {
        keycloak.logout();
    });
});