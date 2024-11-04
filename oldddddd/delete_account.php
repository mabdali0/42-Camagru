<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: /sign_in_or_sign_up"); // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    exit;
}

// Connexion à la base de données
$conn = new mysqli('camagru-db', 'user', 'userpassword', 'camagru');

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Suppression de l'utilisateur
$username = $_SESSION['username'];
$stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    // Détruire la session et rediriger l'utilisateur
    session_destroy();
    header("Location: /sign_in_or_sign_up?message=Votre compte a été supprimé avec succès.");
} else {
    echo "Erreur lors de la suppression du compte : " . $conn->error;
}

$stmt->close();
$conn->close();
?>
