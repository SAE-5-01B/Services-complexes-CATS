window.addEventListener('load', () => {
    const logoutBtn = document.getElementById('logout');
    // Initialiser Keycloak et vérifier si l'utilisateur est connecté
    keycloak.init({ onLoad: 'check-sso' }).then(authenticated => {
        if (authenticated) {
            // Récupérer les informations de l'utilisateur
            const userInfo = KeycloakService.getUserInfo();

            // Récupérer les éléments HTML :
            const prenom = document.getElementById('prenom');
            const nom = document.getElementById('nom');
            const email = document.getElementById('email');
            const groupes = document.getElementById('groupes');

            //Mettre à jour les éléments HTML :
            prenom.textContent += userInfo.firstNameAndLastName.split(" ")[0];
            nom.textContent += userInfo.firstNameAndLastName.split(" ")[1];
            // Supprimer le slash du début des noms de groupe
            const groupNames = userInfo.groups.map(group => group.substring(1));
            groupes.textContent = 'Groupes : ' + groupNames.join(', ');
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

// Gérer le clic sur le bouton de changement de mot de passe (Redirection vers la page de changement de mot de passe)
// Penser à authoriser la redirection vers la page de changement de mot de passe dans Keycloak
document.getElementById("boutonChangementMDP").addEventListener("click", function() {
    window.location.replace("http://localhost:8080/realms/CATS/protocol/openid-connect/auth?client_id=b74fb1bc-6057-4234-bef6-17d9cd47d9b6&redirect_uri=https%3A%2F%2Flocalhost%3A8443%2Fview%2FUtilisateurs%2FinformationsUtilisateur.html&response_mode=fragment&response_type=code&scope=openid&nonce=e8f2162f-2d69-4ed5-b1fa-8931db645871&kc_action=UPDATE_PASSWORD&code_challenge=XbvFfVo7eZX4DJLtJITjMkOfICgQl4cOJy2AeF-vlIg&code_challenge_method=S256");
});

document.getElementById("boutonCompteKeycloak").addEventListener("click", function() {
    window.location.replace("http://localhost:8080/realms/CATS/account/#/personal-info?client_id=b74fb1bc-6057-4234-bef6-17d9cd47d9b6"); //Mettre le lien de redirection vers le compte Keycloak
});