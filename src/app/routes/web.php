<?php

include_once 'app/config/init.php';

// Inclure le contrôleur nécessaire
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/HomeController.php';
// require_once 'app/controllers/AboutController.php';
require_once 'app/controllers/ProfileController.php';
require_once 'app/controllers/CameraController.php';

// Créer une instance du contrôleur
$userController = new UserController();
$authController = new AuthController();
$homeController = new HomeController();
// $aboutController = new AboutController();
$profileController = new ProfileController();
$cameraController = new CameraController();

require_once 'app/models/Image.php'; // Le modèle User pour gérer les utilisateurs
$imageModel = new Image();

// Définir les routes
$routes = [
    '/' => function() use ($homeController) {
        $homeController->index();
    },
    '/home' => function() use ($homeController) {
        $homeController->index();
    },
    '/delete-account' => function() use ($profileController) {
        $profileController->deleteAccount();
    },
    '/profile' => function() use ($profileController) {
        $profileController->index();
    },
    // '/about' => function() use ($aboutController) {
    //     $aboutController->index();
    // },
    '/camera' => function() use ($cameraController) {
        $cameraController->index();
    },
    '/upload' => function() use ($cameraController) {
        $cameraController->uploadImage();
    },
    '/like_image' => function() use ($imageModel) {
        $imageId = $_POST['image_id']; // Assurez-vous que l'ID de l'image est passé via POST
        $imageModel->like($imageId);
    },
    '/login_or_register' => function() use ($authController) {
        $authController->indexLoginOrRegister();
    },
    '/register' => function() use ($authController) {
        $authController->indexRegister();
    },
    '/login' => function() use ($authController) {
        $authController->indexLogin();
    },
    '/register_user' => function() use ($authController) {
        $authController->register();
    },
    '/login_user' => function() use ($authController) {
        $authController->login();
    },
    '/update-notification-settings' => function() use ($authController) {
        $authController->updateNotificationSettings();
    },
    '/change-password' => function() use ($authController) {
        $authController->changePassword();
    },
    '/change-profile-info' => function() use ($authController) {
        $authController->changeProfileInfo();
    },
    '/login-with-42' => function() use ($authController) {
        $authController->loginWith42();
    },
    '/logout' => function() use ($authController) {
        $authController->logout();
    },
    '/image' => function() use ($homeController) {
        $id = (int)$_GET['id']; // Récupérer l'ID de l'image depuis la query string
        $homeController->showImage($id); // Appel de la méthode pour afficher l'image
    },
    '/submit-comment' => function() use ($homeController) {
        $homeController->submitComment(); // Appel de la méthode pour afficher l'image
    },
    '/send-email' => function() use ($homeController) {
        $homeController->sendEmail(); // Appel de la méthode pour afficher l'image
    },
    '/forgot-password' => function() use ($authController) {
        $authController->indexForgotPassword(); // Appel de la méthode pour afficher l'image
    },
    '/password-reinit' => function() use ($authController) {
        $authController->indexReinitPassword(); // Appel de la méthode pour afficher l'image
    },
    '/send-mail-forgot-password' => function() use ($authController) {
        $authController->sendMailForgotPassword(); // Appel de la méthode pour afficher l'image
    },
    '/my-posts' => function() use ($homeController) {
        $homeController->myPostsIndex(); // Appel de la méthode pour afficher l'image
    },
    '/delete-post' => function() use ($homeController) {
        $homeController->deletePostAction(); // Appel de la méthode pour afficher l'image
    },
    // Ajoutez d'autres routes ici
];

// Récupérer l'URL demandée et la query string
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$queryString = $_SERVER['QUERY_STRING'];

// Appeler la fonction associée à la route demandée
if (array_key_exists($requestUri, $routes)) {
    // Si la route est définie, on l'exécute
    $routes[$requestUri]();
} elseif ($requestUri === '/image/') {
    parse_str($queryString, $queryParams);
    if (isset($queryParams['id'])) {
        $id = (int)$queryParams['id'];
        $homeController->showImage($id); // Appel de la méthode pour afficher l'image
    } else {
        http_response_code(404);
        echo 'Page non trouvée.';
    }
} else {
    http_response_code(404);
    echo 'Page non trouvée.';
}
