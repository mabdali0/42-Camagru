<?php


// Récupérer la route depuis l'URL
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_method = $_SERVER['REQUEST_METHOD'];

// Définir les routes
$routes = [
    '/' => 'home.php',
    '/home' => 'home.php',
    '/sign_in' => 'sign_in.php',
    '/sign_up' => 'sign_up.php',
    '/sign_in_or_sign_up' => 'sign_in_or_sign_up.php',
    '/logout' => 'logout.php',
];

// // Vérifier si l'utilisateur est connecté, sauf sur la page de connexion
// if (!isset($_SESSION['username']) && $request_uri !== '/sign_in_or_sign_up' && $request_uri !== '/sign_in' && $request_uri !== '/sign_up') {
//     // Si non connecté et pas sur la page de connexion, rediriger vers la page de connexion
//     header("Location: /sign_in_or_sign_up");
//     exit;
// }

// Trouver le fichier correspondant à la route
$page = $routes[$request_uri] ?? '404.php'; // Page 404 par défaut

// Inclure la page correspondante
include($page);
