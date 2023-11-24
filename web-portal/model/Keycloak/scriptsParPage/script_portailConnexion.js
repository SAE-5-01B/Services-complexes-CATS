window.addEventListener('load', () => {
    const loginBtn = document.getElementById('login');
    const logoutBtn = document.getElementById('logout');
    keycloak.init({ onLoad: 'check-sso' }).then(authenticated => {
        if (authenticated) {
            //alert("Vous êtes connecté")
            //loginBtn.style.display = 'none';
            //logoutBtn.style.display = 'block';
            //Redirection vers l'espace personnel
            window.location.replace("https://localhost:8443/view/Utilisateurs/espacePersonnelUtilisateur.html");
        } else {
            loginBtn.style.display = 'block';
            logoutBtn.style.display = 'none';
        }
    });
    loginBtn.addEventListener('click', () => {
        keycloak.login();
    });
    logoutBtn.addEventListener('click', () => {
        keycloak.logout();
    });
});
