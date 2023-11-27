window.addEventListener('load', () => {
    const logoutBtn = document.getElementById('logout');
    // Initialiser Keycloak et vérifier si l'utilisateur est connecté
    keycloak.init({ onLoad: 'check-sso' }).then(authenticated => {
        if (authenticated) {
            // Récupérer les informations de l'utilisateur
            const userInfo = KeycloakService.getUserInfo();
            // Mettre à jour le message de bienvenue
            document.getElementById('welcomeMessage').textContent = `Bonjour ${userInfo.firstNameAndLastName}`;

            const groupsUtilisateurs = userInfo.groups;
            for (let i = 0; i < groupsUtilisateurs.length; i++) {
                if (groupsUtilisateurs[i] === "/Administrateur") {
                    const divAdministrateur = document.getElementById("divAdminKeycloak");
                    divAdministrateur.style.display = "block";
                }
            }

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