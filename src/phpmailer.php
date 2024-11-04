<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fonction pour envoyer un e-mail de confirmation
function sendConfirmationEmail($email, $subject, $body) {
    // Création d'une nouvelle instance de PHPMailer
    $mail = new PHPMailer(true); // true active les exceptions

    try {
        // Paramètres SMTP pour Gmail
        $mail->isSMTP(); // Utilisation de SMTP
        $mail->Host = 'smtp.gmail.com';  // Serveur SMTP de Gmail
        $mail->SMTPAuth = true; // Authentification SMTP activée
        $mail->Username = 'camagru42perpignan@gmail.com'; // Ton adresse Gmail complète
        $mail->Password = 'rompekqxjsebehcn'; // Ton mot de passe Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Chiffrement TLS (STARTTLS est souvent utilisé)
        $mail->Port = 587; // Port SMTP pour Gmail

        // Expéditeur
        $mail->setFrom('camagru42perpignan@gmail.com', 'Camagru');

        // Destinataire
        $mail->addAddress($email);

        // Contenu de l'e-mail
        $mail->isHTML(true); // Format HTML
        // $mail->Subject = 'Confirmation d\'inscription';
        $mail->Subject = $subject;
        // $mail->Body    = 'Bonjour,<br><br>Merci pour votre inscription. Cliquez sur le lien suivant pour activer votre compte : <a href="https://www.example.com/activation.php?email=' . urlencode($email) . '">Activer votre compte</a><br><br>Cordialement,<br>L\'équipe de votre site';
        $mail->Body    = $body;

        // Envoi de l'e-mail
        $mail->send();
        return true;
    } catch (Exception $e) {
        return $mail->ErrorInfo; // En cas d'erreur, renvoie false ou gère l'erreur comme nécessaire
    }
}

// // Exemple d'utilisation après la validation du formulaire d'inscription
// if (1) {
//     $email = 'lamineabd57@gmail.com'; // Récupérer l'email depuis le formulaire
//     $test = sendConfirmationEmail($email);
//     // Envoyer l'e-mail de confirmation
//     if (!$test) {
//         echo 'Un e-mail de confirmation a été envoyé à ' . htmlspecialchars($email);
//     } else {
//         echo "Erreur lors de l\'envoi de l\'e-mail de confirmation.{$test}";
//     }
// }
?>
