<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
// Récupération des données du formulaire
$senderEmail = $_POST['email'];
$senderName = $_POST['name'];
$comments = $_POST['comments'];

// Configuration du serveur SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'cats.rocket.chat@gmail.com';
$mail->Password = 'urhksbhbfmbasyhl';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->CharSet = 'UTF-8';


// Configurer l'expéditeur et le destinataire
$mail->setFrom($senderEmail, $senderName);
$mail->addAddress('cats.rocket.chat@gmail.com', 'CATS Support');

// Contenu de l'email
$mail->isHTML(true);
$mail->Subject = "Nouveau message de $senderName";
$mail->Body    = "<b>Email de l'expéditeur :</b> $senderEmail <br><b>Message :</b><br>$comments";
$mail->AltBody = "Email de l'expéditeur : $senderEmail \nMessage :\n$comments";

$mail->send();
    header('Location: ./../../view/utilisateurs/apropos.php?emailSent=success');
    exit;
} catch (Exception $e) {
    header('Location: ./../../view/utilisateurs/apropos.php?emailSent=fail');
    exit;
}