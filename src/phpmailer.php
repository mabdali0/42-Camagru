<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function loadEnv($file)
{
    if (!file_exists($file)) {
        throw new Exception("Le fichier .env n'a pas été trouvé.");
    }

    // Lire toutes les lignes du fichier .env
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    // Traiter chaque ligne
    foreach ($lines as $line) {
        // Ignorer les lignes de commentaire
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Séparer la clé et la valeur
        list($key, $value) = explode('=', $line, 2);
        
        // Nettoyer la clé et la valeur (enlever les espaces superflus)
        $key = trim($key);
        $value = trim($value);
        
        // Définir la variable d'environnement
        putenv("$key=$value");
    }
}

// Fonction pour envoyer un e-mail de confirmation
function sendConfirmationEmail($email, $subject, $body) {
    // Création d'une nouvelle instance de PHPMailer
    $mail = new PHPMailer(true); // true active les exceptions
    loadEnv('/var/www/html/.env');

    $smtp = getenv('SMTP');
    $user_mail = getenv('USER_MAIL');
    $password_mail = getenv('PASSWORD_MAIL');
    $port_mail = getenv('PORT_MAIL');
    try {
        // Paramètres SMTP pour Gmail
        $mail->isSMTP(); // Utilisation de SMTP
        $mail->Host = $smtp;  // Serveur SMTP de Gmail
        $mail->SMTPAuth = true; // Authentification SMTP activée
        $mail->Username = $user_mail; // Ton adresse Gmail complète
        $mail->Password = $password_mail; // Ton mot de passe Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Chiffrement TLS (STARTTLS est souvent utilisé)
        $mail->Port = $port_mail; // Port SMTP pour Gmail

        // Expéditeur
        $mail->setFrom($user_mail, 'Camagru');

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

?>
