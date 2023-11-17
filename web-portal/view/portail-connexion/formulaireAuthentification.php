<?php session_start();?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="../style/stylePageConnexion.css">
    <script>
        // Fonction pour ouvrir et fermer le popup
        function toggleInfoPopup() {
            var popup = document.getElementById("infoPopup");
            if (popup.style.display === "none" || !popup.style.display) {
                popup.style.display = "block";
            } else {
                popup.style.display = "none";
            }
        }
    </script>
</head>
<body>
<div>
    <h1 id="titreMiaou">Bienvenue sur le portail Miaou</h1>
</div>
<div class="login-container">
    <h1>Connectez-vous</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p id='message_erreur'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>
    <form method="post" action="./../../controller/verificationAuthentification.php">
        <div class="input-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Connexion</button>

    </form>

    <div class="button-group">
        <button onclick="toggleInfoPopup()">Informations</button>
        <a href="formulaireEnvoieMail.html"><button>Nous contacter</button></a>
    </div>

</div>

<!-- Popup pour les informations -->
<div id="infoPopup">
    <h2>Informations sur le site</h2>

    <p>Bienvenue et merci d'avoir fait confiance aux services Miaou. Miaou est un service de stockage de fichiers sécurisé.</p>

    <p>Si vous n'avez pas encore de compte chez nous, veuillez contacter l'un de nos supports afin qu'il puisse vous créer un compte. Pour nous contacter, vous pouvez cliquer sur le bouton "Nous contacter" présent sur le portail de connexion.</p>

    <button onclick="toggleInfoPopup()">Fermer</button>
</div>


</body>
</html>
