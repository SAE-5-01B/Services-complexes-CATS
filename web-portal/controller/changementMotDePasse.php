<?php
session_start();
//Ce fichier permet de faire l'intermédiaire entre la vue et le modèle pour le changement de mot de passe
require "./../model/LDAP/methodeLDAP.php";
//$changementMotDePasse = passwordChange("ggonfiantini","gogo","gaga"); //Exemple utilisation de la fonction passwordChange
if(isset($_POST['username']) && isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])){
    $username = $_POST['username'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    if($newPassword != $confirmPassword){
        $_SESSION['changementMotDePasse'] = "Les mots de passe ne correspondent pas";
    }
    else{
        $changementMotDePasse = passwordChange($username,$oldPassword,$newPassword);
        if($changementMotDePasse == "SUCCESS"){
            $_SESSION['changementMotDePasse'] = "Mot de passe changé avec succès";
        }
        else {
            switch ($changementMotDePasse) {
                case "ERR_LDAP_CONNECTION":
                    $_SESSION['changementMotDePasse'] = "Erreur lors de la connexion LDAP";
                    break;
                case "ERR_ADMIN_BIND":
                    $_SESSION['changementMotDePasse'] = "Erreur lors de la connexion en tant qu'administrateur";
                    break;
                case "ERR_USER_SEARCH":
                    $_SESSION['changementMotDePasse'] = "Erreur lors de la recherche de l'utilisateur";
                    break;
                case "ERR_USER_NOT_FOUND":
                    $_SESSION['changementMotDePasse'] = "Utilisateur non trouvé";
                    break;
                case "ERR_OLD_PASSWORD":
                    $_SESSION['changementMotDePasse'] = "Ancien mot de passe incorrect";
                    break;
                case "ERR_PASSWORD_CHANGE":
                    $_SESSION['changementMotDePasse'] = "Erreur lors du changement de mot de passe";
                    break;
                default:
                    $_SESSION['changementMotDePasse'] = "Erreur lors du changement de mot de passe";
            }
        }
    }
}
else {
    $_SESSION['changementMotDePasse'] = "Erreur lors du changement de mot de passe";
}
header('Location: ./../view/Utilisateurs/formulaireChangementMDPUtilisateur.php');
?>