window.addEventListener('load', () => {
    const logoutBtn = document.getElementById('logout');
    // Initialiser keycloak et vérifier si l'utilisateur est connecté
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
            window.location.replace(`https://${serverIp}`);
        }
    });
    // Gérer le clic sur le bouton de déconnexion
    logoutBtn.addEventListener('click', () => {
        keycloak.logout();
    });
});

// Gérer le clic sur le bouton de changement de mot de passe (Redirection vers la page de changement de mot de passe)
// Penser à authoriser la redirection vers la page de changement de mot de passe dans keycloak
document.getElementById("boutonChangementMDP").addEventListener("click", function() {
    window.location.replace(`https://${serverIp}/keycloak/realms/CATS/protocol/openid-connect/auth?client_id=portal-cats&redirect_uri=https%3A%2F%2F${serverIp}%2Fview%2Futilisateurs%2FinformationsUtilisateur.html&response_mode=fragment&response_type=code&scope=openid&nonce=e8f2162f-2d69-4ed5-b1fa-8931db645871&kc_action=UPDATE_PASSWORD&code_challenge=XbvFfVo7eZX4DJLtJITjMkOfICgQl4cOJy2AeF-vlIg&code_challenge_method=S256`);
});

document.getElementById("boutonCompteKeycloak").addEventListener("click", function() {
    window.location.replace(`https://${serverIp}/keycloak/realms/CATS/account/#/personal-info?client_id=portal-cats`); //Mettre le lien de redirection vers le compte keycloak
});


// Fonction pour mettre à jour le compte à rebours
function updateCountdown() {
    const currentTime = Math.floor(Date.now() / 1000);
    const timeLeft =  keycloak.tokenParsed.exp - currentTime;

    if (timeLeft > 0) {
        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const seconds = timeLeft % 60;

        // Affiche le compte à rebours dans un élément avec l'ID 'countdown'
        document.getElementById('countdown').innerHTML =
            hours + 'h ' + minutes + 'm ' + seconds + 's ';
    } else {
        document.getElementById('countdown').innerHTML = 'Le token a expiré.';
        clearInterval(interval);
    }
}

// Mettre à jour le compte à rebours toutes les secondes
const interval = setInterval(updateCountdown, 1000);

//tempsRestantSession id


document.getElementById('refreshToken').addEventListener('click', () => {
    keycloak.updateToken(-1).then(refreshed => {
        if (refreshed) {
            console.log('Token rafraîchi avec succès');
            updateCountdown();
        } else {
            console.log('Erreur lors de la tentative de rafraîchissement');
        }
    }).catch(err => {
        console.log('Erreur lors de la tentative de rafraîchissement du token', err);
    });
});
