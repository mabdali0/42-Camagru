<?php

require_once 'app/config/Database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Image {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getDb();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    // Méthode pour récupérer toutes les images
    public function getAllImages() {
        $stmt = $this->pdo->prepare("SELECT * FROM images");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer les likes d'une image par son ID
    public function getLikesByImageId($imageId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as like_count FROM likes WHERE image_id = :image_id");
        $stmt->bindParam(':image_id', $imageId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['like_count'] ?? 0;
    }

    // Méthode pour récupérer les commentaires d'une image par son ID
    public function getCommentsByImageId($imageId) {
        $stmt = $this->pdo->prepare("
        SELECT comments.*, users.username 
        FROM comments 
        JOIN users ON comments.user_id = users.id 
        WHERE comments.image_id = :image_id
    ");
        $stmt->bindParam(':image_id', $imageId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer toutes les images avec leurs likes et commentaires
    public function getImagesWithLikesAndComments() {
        $images = $this->getAllImages();
        $result = [];

        foreach ($images as $image) {
            $imageId = $image['id'];
            $likes = $this->getLikesByImageId($imageId);
            $comments = $this->getCommentsByImageId($imageId);
            $result[] = [
                'image' => $image,
                'likes' => $likes,
                'comments' => $comments
            ];
        }

        return $result;
    }

    public function getAllImagesWithDetails($user_id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                images.id, 
                users.username, 
                images.image, 
                images.created_at,
                (SELECT COUNT(*) FROM comments WHERE comments.image_id = images.id) AS nb_comments,
                (SELECT COUNT(*) FROM likes WHERE likes.image_id = images.id) AS nb_likes,
                (SELECT EXISTS(SELECT 1 FROM likes WHERE likes.image_id = images.id AND likes.user_id = :user_id)) AS user_like
            FROM images
            JOIN users ON images.user_id = users.id
        ");
        // Lier le paramètre :user_id
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaginatedImages($offset, $items_per_page, $user_id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                images.id, 
                users.username, 
                images.image, 
                images.created_at,
                (SELECT COUNT(*) FROM comments WHERE comments.image_id = images.id) AS nb_comments,
                (SELECT COUNT(*) FROM likes WHERE likes.image_id = images.id) AS nb_likes,
                (SELECT EXISTS(SELECT 1 FROM likes WHERE likes.image_id = images.id AND likes.user_id = :user_id)) AS user_like
            FROM images
            JOIN users ON images.user_id = users.id
            ORDER BY images.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':limit', $items_per_page, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletePost($postId) {
        // Démarrer une transaction pour garantir l'intégrité des données
        $this->pdo->beginTransaction();
    
        try {
            // Supprimer les likes liés au post
            $stmtLikes = $this->pdo->prepare("DELETE FROM likes WHERE image_id = :post_id");
            $stmtLikes->bindParam(':post_id', $postId, PDO::PARAM_INT);
            $stmtLikes->execute();
    
            // Supprimer les commentaires liés au post
            $stmtComments = $this->pdo->prepare("DELETE FROM comments WHERE image_id = :post_id");
            $stmtComments->bindParam(':post_id', $postId, PDO::PARAM_INT);
            $stmtComments->execute();
    
            // Supprimer le post
            $stmtPost = $this->pdo->prepare("DELETE FROM images WHERE id = :post_id");
            $stmtPost->bindParam(':post_id', $postId, PDO::PARAM_INT);
            $stmtPost->execute();
    
            // Valider la transaction
            $this->pdo->commit();
            return true; // Suppression réussie
        } catch (Exception $e) {
            // En cas d'erreur, annuler la transaction
            $this->pdo->rollBack();
            return false; // Erreur de suppression
        }
    }

    

    public function getPaginatedPosts($offset, $items_per_page, $user_id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                images.id, 
                users.username, 
                images.image, 
                images.created_at,
                (SELECT COUNT(*) FROM comments WHERE comments.image_id = images.id) AS nb_comments,
                (SELECT COUNT(*) FROM likes WHERE likes.image_id = images.id) AS nb_likes,
                (SELECT EXISTS(SELECT 1 FROM likes WHERE likes.image_id = images.id AND likes.user_id = :user_id)) AS user_like
            FROM images
            JOIN users ON images.user_id = users.id
            WHERE images.user_id = :user_id
            ORDER BY images.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':limit', $items_per_page, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalImageCount() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM images");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getTotalPostsCount($user_id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM images WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }



public function like($imageId)
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        echo json_encode(['message' => 'Unauthorized']);
        exit;
    }

    $userId = $_SESSION['user_id'];

    // Vérifiez si l'utilisateur a déjà aimé l'image
    $stmt = $this->pdo->prepare("SELECT * FROM likes WHERE user_id = :user_id AND image_id = :image_id");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':image_id', $imageId);
    $stmt->execute();
    $like = $stmt->fetch();

    if ($like) {
        // Si un like existe déjà, le supprimer
        $stmt = $this->pdo->prepare("DELETE FROM likes WHERE user_id = :user_id AND image_id = :image_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':image_id', $imageId);
        $stmt->execute();
        $message = "Like supprimé";
    } else {
        // Sinon, ajouter un like
        $stmt = $this->pdo->prepare("INSERT INTO likes (user_id, image_id) VALUES (:user_id, :image_id)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':image_id', $imageId);
        $stmt->execute();
        $message = "Like ajouté";

        $image = new Image;
        $user = new User;
        $image = $image->getImageById($imageId);
        $user_image = $user->getUserById($image['user_id']);
        $user = $user->getUserById($userId);
        if ($user_image['active_notification'] == 1) {
            // Envoyer une notification par e-mail au propriétaire de l'image
            $this->sendNotificationEmail($user_image['email'], $user['username'], $user_image['username']);
        }
        // $this->sendNotificationEmail($user_image['email'], $user['username'], $user_image['username']);
    }

    // Récupérer le nouveau nombre de likes
    $stmt = $this->pdo->prepare("SELECT COUNT(*) AS likes_count FROM likes WHERE image_id = :image_id");
    $stmt->bindParam(':image_id', $imageId);
    $stmt->execute();
    $likeCount = $stmt->fetch(PDO::FETCH_ASSOC)['likes_count'];

    echo json_encode(['message' => $message, 'likes_count' => $likeCount]);
}


public function getImageById($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM images WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getImageWithDetailsById($image_id, $user_id) {
    $stmt = $this->pdo->prepare("
        SELECT 
            images.id, 
            users.username, 
            images.image, 
            images.created_at,
            (SELECT COUNT(*) FROM comments WHERE comments.image_id = images.id) AS nb_comments,
            (SELECT COUNT(*) FROM likes WHERE likes.image_id = images.id) AS nb_likes,
            (SELECT EXISTS(SELECT 1 FROM likes WHERE likes.image_id = images.id AND likes.user_id = :user_id)) AS user_like
        FROM images
        JOIN users ON images.user_id = users.id
        WHERE images.id = :image_id
    ");
    // Lier le paramètre :user_id
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':image_id', $image_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function sendNotificationEmail($email, $username, $username_image) {
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
        $mail->Subject = "Nouveau like sur votre photo";
        
        // Corps de l'e-mail
        $mail->Body = "Bonjour {$username_image},<br><br>{$username} a aimé une de vos photos <br><br>Cordialement,<br>L'équipe de Camagru";

        // Envoi de l'e-mail
        $mail->send();
        return true;
    } catch (Exception $e) {
        return $mail->ErrorInfo; // En cas d'erreur, renvoie false ou gère l'erreur comme nécessaire
    }
}
}
