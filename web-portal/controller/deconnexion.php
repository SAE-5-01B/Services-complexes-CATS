<?php
session_start();
unset($_SESSION['userDetails']);
session_destroy();
header('Location: ./../view/portail-connexion/formulaireAuthentification.php');
exit();
?>
