<?php
// Démarrer la session
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Démarrez la session uniquement si elle n'est pas déjà active
}

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou d'accueil
header("Location: /sign_in_or_sign_up");
exit;
