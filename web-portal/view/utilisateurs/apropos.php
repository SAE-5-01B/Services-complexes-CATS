<?php
$message = '';
if (isset($_GET['emailSent'])) {
    if ($_GET['emailSent'] == 'success') {
        $message = 'Merci pour votre commentaire. Votre message a été envoyé avec succès.';
    } elseif ($_GET['emailSent'] == 'fail') {
        $message = "Désolé, il y a eu un problème lors de l'envoi de votre message.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Informations de l'Utilisateur</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/stylePagesPersonnelUtilisateur.css">
    <link rel="stylesheet" href="../style/styleBarreNavigation.css">
    <script src="./../../serverConfig.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/keycloak-js"></script>
    <script src="../../model/keycloak/keycloak-config.js"></script>
    <script src="../../model/keycloak/methode_Keycloak.js"></script>
    <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="3807f17e-196e-444d-8132-0d1c4c898efd";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>

</head>
<body>

<nav class="navbar">
    <div id="gaucheNavBarre">
        <div id="imgAndCATS"><img src="../images/patte-de-chat-blanche.png" alt="Logo du projet Miaou" class="logo"><a
                id="nomProjet">CATS </a></div>
    </div>
    <div id="millieuNavBarre">
        <a href="espacePersonnelUtilisateur.html" class="nav-link">Talbeau de bord</a>
        <a href="informationsUtilisateur.html" class="nav-link">Mes informations</a>
        <a href="securite.html" class="nav-link">Sécurité</a>
        <a href="apropos.php" class="nav-link">À propos</a>
    </div>
    <div id="droiteNavBarre">
        <button id="logout">Se Déconnecter</button>
    </div>
</nav>
<div id="contenuePage">
    <div>

        <div class="container">
            <h1>À propos de CATS</h1>
            <p class="AproposText">CATS (Central Authentication & Technology Services) est une plateforme dédiée à offrir des solutions technologiques avancées et sécurisées. Notre objectif est de fournir des services fiables et faciles d'utilisation pour améliorer votre expérience digitale.</p>
        </div>


        <div class="container">
            <h2>Notre Infrastructure</h2>
            <p class="AproposText">CATS s'appuie sur une infrastructure robuste, incluant un proxy sécurisé et une communication chiffrée HTTPS, garantissant la sécurité et la confidentialité des données de nos utilisateurs. Notre système d'authentification unique (SSO) avec Keycloak simplifie l'accès à différents services tout en renforçant la sécurité.</p>
        </div>

        <div class="container">
            <h2>Nos Services Principaux</h2>
            <ul>
                <li><p class="AproposText"><strong>Portail Web :</strong> Un point d'accès central pour tous nos services, offrant une expérience utilisateur intuitive et sécurisée.</p></li>
                <li><p class="AproposText"> <strong>Service de dépôt de fichier Nextcloud :</strong> Une solution de stockage cloud flexible et sécurisée pour gérer et partager vos fichiers en toute confiance.</p></li>
                <li><p class="AproposText"><strong>Service de chat en ligne RocketChat :</strong> Une plateforme de communication en ligne permettant des échanges instantanés et sécurisés, facilitant la collaboration et le travail d'équipe.</p></li>
            </ul>
        </div>

        <div class="container">
            <h2>Notre Engagement</h2>
            <p class="AproposText">Chez CATS, nous nous engageons à fournir des services de haute qualité, en mettant l'accent sur la sécurité, la fiabilité et la convivialité. Notre équipe travaille continuellement pour améliorer et innover afin de répondre au mieux à vos besoins technologiques.</p>
        </div>


        <div class="container">
            <h2>Votre avis nous intéresse</h2>
            <form action="./../../model/envoieMail.php" method="POST">
                <label for="email">Email :</label><br>
                <input type="email" id="email" name="email" required><br>

                <label for="name">Nom et prénom :</label><br>
                <input type="text" id="name" name="name" required><br>

                <label for="comments">Commentaires :</label><br>
                <textarea id="comments" name="comments" rows="4" required></textarea><br>

                <div class="submit-container">
                    <input type="submit" value="Envoyer">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fenêtre modale pour le message -->
<div id="emailModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="modalMessage"></p>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        const urlParams = new URLSearchParams(window.location.search);
        const emailSent = urlParams.get('emailSent');
        const modal = document.getElementById('emailModal');
        const span = document.getElementsByClassName('close')[0];
        const message = document.getElementById('modalMessage');

        if (emailSent) {
            if (emailSent === 'success') {
                message.innerHTML = 'Merci pour votre commentaire. Votre message a été envoyé avec succès.';
            } else if (emailSent === 'fail') {
                message.innerHTML = "Désolé, il y a eu un problème lors de l'envoi de votre message.";
            }
            modal.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';

            // Supprimer le paramètre emailSent de l'URL après la fermeture du pop-up
            const newUrl = window.location.href.split('?')[0];
            window.history.pushState({}, '', newUrl);
        }

        span.onclick = function() {
            closeModal();
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    });
</script>




<script src="../../model/keycloak/scriptsParPage/script_informationUtilisateur.js"></script>
</body>
</html>

