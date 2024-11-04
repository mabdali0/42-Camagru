<?php

require_once 'Controller.php';
require_once 'app/models/Image.php'; // Le modèle User pour gérer les utilisateurs
require_once 'app/models/Comment.php'; // Le modèle User pour gérer les utilisateurs
require_once 'app/helper/DateHelper.php';

class HomeController extends Controller
{
    // // Affiche le formulaire de connexion
    // public function index()
    // {
    //     $imageModel = new Image();
    //     $images = $imageModel->getAllImagesWithDetails();
    //     foreach ($images as &$image) {
    //         $image['created_at'] = DateHelper::formatDate($image['created_at']);
    //     }

    //     var_dump($images);
    //     $this->render('home', ['images' => $images]);
    // }

    public function index()
{
    // echo print_r($_SESSION, true); 

    if (isset($_SESSION['username'])) {
        $imageModel = new Image();

        $user_id = $_SESSION['user_id']; // Assurez-vous que l'utilisateur est connecté
        // $images = $imageModel->getAllImagesWithDetails($user_id);
        $items_per_page = 12;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $items_per_page;
        
        $images = $imageModel->getPaginatedImages($offset, $items_per_page, $user_id);
        $total_items = $imageModel->getTotalImageCount();
        $total_pages = ceil($total_items / $items_per_page);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        // Formater les dates pour chaque image
        foreach ($images as &$image) {
            $image['created_at'] = DateHelper::formatDate($image['created_at']);
        }
        $this->render('home', ['images' => $images, 'total_items' => $total_items, 'page' => $page, 'total_pages' => $total_pages]);
    } else {
        // echo print_r($_SESSION, true); 
        header("Location: /login_or_register"); // Rediriger vers la page d'accueil
        // Gérer le cas où l'utilisateur n'est pas connecté
        // Rediriger vers la page de connexion ou afficher un message
    }
}

public function myPostsindex()
{
    // echo print_r($_SESSION, true); 

    if (isset($_SESSION['username'])) {
        $imageModel = new Image();

        $user_id = $_SESSION['user_id']; // Assurez-vous que l'utilisateur est connecté
        // $images = $imageModel->getAllImagesWithDetails($user_id);
        $items_per_page = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $items_per_page;
        
        $images = $imageModel->getPaginatedPosts($offset, $items_per_page, $user_id);
        $total_items = $imageModel->getTotalPostsCount($user_id);
        $total_pages = ceil($total_items / $items_per_page);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        // Formater les dates pour chaque image
        foreach ($images as &$image) {
            $image['created_at'] = DateHelper::formatDate($image['created_at']);
        }
        $this->render('home', ['images' => $images, 'total_items' => $total_items, 'page' => $page, 'total_pages' => $total_pages]);
    } else {
        // echo print_r($_SESSION, true); 
        header("Location: /login_or_register"); // Rediriger vers la page d'accueil
        // Gérer le cas où l'utilisateur n'est pas connecté
        // Rediriger vers la page de connexion ou afficher un message
    }
}


public function showImage($id) {
    $imageModel = new Image();
    $images = $imageModel->getImageWithDetailsById($id, $_SESSION['user_id']);
    $comments = $imageModel->getCommentsByImageId($id);
    // print_r($comments);
    foreach ($comments as &$comment) {
        $comment['created_at'] = DateHelper::formatDate($comment['created_at']);
    }
    foreach ($images as &$image) {
        $image['created_at'] = DateHelper::formatDate($image['created_at']);
    }
    if ($images) {
        $this->render('image_show', ['image' => $images, 'comments' => $comments]);

        // include 'app/views/image_show.php'; // Inclus la vue pour afficher l'image
    } else {
        http_response_code(404);
        echo 'Image non trouvée.';
    }
}

public function submitComment() {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $comment = $data['comment'];
        $imageId = $data['image_id'];
        $userId = $_SESSION['user_id']; // Récupérer l'ID de l'utilisateur connecté

        // Appelle le modèle pour enregistrer le commentaire
        $commentModel = new Comment();
        $commentModel->addComment($imageId, $userId, $comment);

        // Redirection après ajout
        header("Location: /home"); // Rediriger vers la page de l'image
        exit;
    }
}

public function sendEmail()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        echo json_encode(['message' => 'Unauthorized']);
        exit;
    }

    $userId = $_SESSION['user_id'];
    $imageId = $_POST['image_id'];

    // Récupérer les informations nécessaires pour l'e-mail
    $image = new Image;
    $user = new User;
    $imageData = $image->getImageById($imageId);
    $userImage = $user->getUserById($imageData['user_id']);
    $currentUser = $user->getUserById($userId);

    // Préparer le contenu de l'e-mail
    $subject = "Notification de like sur votre photo";
    $body = $currentUser['username'] . " a aimé votre photo.";

    // Envoi de l'e-mail
    $imageModel = new Image;
    $user = new User;
    $image = $image->getImageById($imageId);
    $user_image = $user->getUserById($image['user_id']);
    $user = $user->getUserById($userId);
    $imageModel->sendNotificationEmail($user_image['email'], $user['username'], $user_image['username']);
}

public function deletePostAction() {
    $data = json_decode(file_get_contents('php://input'), true);

    $imageModel = new Image(); // Assurez-vous d'instancier votre modèle correctement
    if ($imageModel->deletePost($data['postId'])) {
        // Redirection ou message de succès
        // header("Location: /my-posts?success_message=ee"); // Redirigez vers la page des posts
        echo json_encode(['success' => true, 'redirect' => '/home?success_message=Votre post à bien été supprimé']);
        // exit();
    } else {
        // Gestion des erreurs
        echo "Erreur lors de la suppression du post.";
    }
}




}
