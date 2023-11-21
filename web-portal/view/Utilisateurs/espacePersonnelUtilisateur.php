<?php session_start();
if (!isset($_SESSION['userDetails'])) {
    header('Location: ./../view/portail-connexion/formulaireAuthentification.php');
    exit();
}

$userDetails = $_SESSION['userDetails'];
$displayName = isset($userDetails['cn']) ? $userDetails['cn'][0] : "Utilisateur";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/stylePagesPersonnelUtilisateur.css">
    <link rel="stylesheet" href="./../style/styleBarreNavigation.css">
    <title>Espace Miaou</title>
</head>
<body>
    <nav class="navbar">
        <a href="espacePersonnelUtilisateur.php" class="nav-link">Talbeau de bord</a>
        <a href="./informationsUtilisateur.php" class="nav-link">Mes informations</a>
        <a href="./../../controller/deconnexion.php" class="nav-link">Se déconnecter</a>
    </nav>
    <div id="contenuePage">
        <div class="container">
            <h1>Bonjour, <?php echo $displayName; ?>!</h1>
            <p>Bienvenue sur votre espace Miaou. Utilisez les liens ci-dessous pour naviguer.</p>
        </div>

        <div class="container">
            <h1>Vos services</h1>

            <div id="lesServicesUtilisateur">
                <div>
                <a href="http://localhost:9080" target="_bla">
                    <img alt="Ceci est le service n°2 qui est le service next cloud" src="./../images/nextCloud.png"/>
                    <p>Next Cloud</p>
                </div>
                </a>
            </div>
            <div id="lesServicesAdministrateurs">
                <!--Si l'utilisateur est un administrateur il a accès à phpLDAPAdmin -->
                <?php
                if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){
                    echo "<div>";
                    echo "<img alt='Ceci est le service phpLDAPAdmin' src='./../images/phpldapAdmin.png'/>";
                    echo "<p>phpLDAPAdmin</p>";
                    echo "</div>";
                }
                ?>

            </div>

        </div>

    </div>







</body>
</html>

