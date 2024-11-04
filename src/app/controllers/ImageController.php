<?php

class ImageController extends Controller
{
    public function like($imageId)
    {
        // Vérifiez que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            echo json_encode(['message' => 'Unauthorized']);
            exit;
        }

        // Récupérer l'ID de l'utilisateur
        $userId = $_SESSION['user_id'];

        // Ajouter le like à la base de données
        try {
            $stmt = $this->pdo->prepare("INSERT INTO likes (user_id, image_id) VALUES (:user_id, :image_id)");
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':image_id', $imageId);
            $stmt->execute();

            // Renvoie le nombre de likes après l'ajout
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS likes_count FROM likes WHERE image_id = :image_id");
            $stmt->bindParam(':image_id', $imageId);
            $stmt->execute();
            $likeCount = $stmt->fetch(PDO::FETCH_ASSOC)['likes_count'];

            echo json_encode(['message' => 'Like ajouté', 'likes_count' => $likeCount]);
        } catch (PDOException $e) {
            echo json_encode(['message' => 'Erreur lors de l\'ajout du like']);
        }
    }
}
