<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Informations de l'Utilisateur</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/stylePagesPersonnelUtilisateur.css">
    <link rel="stylesheet" href="../Style/styleBarreNavigation.css">
</head>
<body>
<div class="navbar">
    <nav class="navbar">

        <div id="gaucheNavBarre">
            <div id="imgAndCATS"><img src="../Images/patte-de-chat-noir.png" alt="Logo du projet Miaou" class="logo"><a id="nomProjet">CATS </a></div>
        </div>

        <div id="millieuNavBarre">

            <a href="espacePersonnelUtilisateur.html" class="nav-link">Talbeau de bord</a>
            <a href="./informationsUtilisateur.php" class="nav-link">Mes informations</a>
            <a href="" class="nav-link">À propos</a>
        </div>

        <div id="droiteNavBarre">
            <a href="./../../controller/deconnexion.php" class="nav-link">Se déconnecter</a>
        </div>

    </nav>
</div>

<div id="contenuePage">
    <div class="container">
        <h1>Informations de l'utilisateur</h1>
        <?php
        // Récupération des informations de l'utilisateur
        $detailsUtilisateur = $_SESSION['userDetails'];

        // Affichage des informations
        if ($detailsUtilisateur) {
            echo "<p>Nom : " . htmlspecialchars($detailsUtilisateur['sn'][0]) . "</p>";
            echo "<p>Prénom : " . htmlspecialchars($detailsUtilisateur['givenname'][0]) . "</p>";
            echo "<p>Nom complet : " . htmlspecialchars($detailsUtilisateur['cn'][0]) . "</p>";
            echo "<p>UID : " . htmlspecialchars($detailsUtilisateur['uid'][0]) . "</p>";
            echo "<p>Groupe de l'utilisateur : " . htmlspecialchars($_SESSION['group']) . "</p>";


            echo "<form action='formulaireChangementMDPUtilisateur.php'>
                <button type='submit'>Changez le mot de passe</button>
                </form>";
        } else {
            echo "<p>Aucune information disponible.</p>";
        }
        ?>
    </div>

</div>

</body>
</html>

