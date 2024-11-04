<?php

require_once 'app/config/Database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Comment {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getDb();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
function sendNotificationEmail($email, $username, $username_image, $comment) {
    // Création d'une nouvelle instance de PHPMailer
    $mail = new PHPMailer(true); // true active les exceptions

    try {
        // Paramètres SMTP pour Gmail
        $mail->isSMTP(); // Utilisation de SMTP
        $mail->Host = 'smtp.gmail.com';  // Serveur SMTP de Gmail
        $mail->SMTPAuth = true; // Authentification SMTP activée
        $mail->Username = 'camagru42perpignan@gmail.com'; // Ton adresse Gmail complète
        $mail->Password = 'rompekqxjsebehcn'; // Ton mot de passe Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Chiffrement TLS
        $mail->Port = 587; // Port SMTP pour Gmail

        // Expéditeur
        $mail->setFrom('camagru42perpignan@gmail.com', 'Camagru');

        // Destinataire
        $mail->addAddress($email);

        // Contenu de l'e-mail
        $mail->isHTML(true); // Format HTML
        $mail->Subject = "Nouveau commentaire sur votre photo";
        
        // Corps de l'e-mail
        $mail->Body = "Bonjour {$username_image},<br><br>{$username} a commenté une de vos photos :<br><br><strong>Commentaire :</strong> {$comment}<br><br>Cordialement,<br>L'équipe de Camagru";

        // Envoi de l'e-mail
        $mail->send();
        return true;
    } catch (Exception $e) {
        return $mail->ErrorInfo; // En cas d'erreur, renvoie false ou gère l'erreur comme nécessaire
    }
}
    public function addComment($imageId, $userId, $comment) {
        try {
            // Préparer la requête SQL pour insérer le commentaire
            $stmt = $this->pdo->prepare("
                INSERT INTO comments (image_id, user_id, comment, created_at) 
                VALUES (:image_id, :user_id, :comment, NOW())
            ");
    
            // Lier les paramètres
            $stmt->bindParam(':image_id', $imageId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    
            // Exécuter la requête
            $stmt->execute();
            $image = new Image;
            $user = new User;
            $image = $image->getImageById($imageId);
            $user_image = $user->getUserById($image['user_id']);
            $user = $user->getUserById($userId);
            if ($user_image['active_notification'] == 1) {
                // Envoyer une notification par e-mail au propriétaire de l'image
                $this->sendNotificationEmail($user_image['email'], $user['username'], $user_image['username'], $comment);
            }
        } catch (PDOException $e) {
            // Gérer les erreurs de la base de données
            echo "Erreur lors de l'ajout du commentaire : " . $e->getMessage();
            return false;
        }
    
        return true; // Retourne true si l'ajout est réussi
    }
    

}
