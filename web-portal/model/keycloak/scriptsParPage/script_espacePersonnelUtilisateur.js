window.addEventListener('load', () => {
    const logoutBtn = document.getElementById('logout');
    // Initialiser keycloak et vérifier si l'utilisateur est connecté
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
                    const linkAdminKeycloak = document.getElementById("linkAdminKeycloak");
                    linkAdminKeycloak.href = `https://${serverIp}/keycloak/admin/CATS/console`;
                    divAdministrateur.style.display = "block";
                }
            }

            const linkNextCloud = document.getElementById('linkNextCloud');
            if (linkNextCloud) {
                linkNextCloud.href = `https://${serverIp}/nextcloud/`;
            }
            const linkRocketChat = document.getElementById('linkRocketChat');
            if (linkRocketChat) {
                linkRocketChat.href = `https://${serverIp}/rocketchat/`;
            }

        } else {
            window.location.replace(`https://${serverIp}`);
        }
    });
    // Gérer le clic sur le bouton de déconnexion
    logoutBtn.addEventListener('click', () => {
        keycloak.logout();
    });
});
