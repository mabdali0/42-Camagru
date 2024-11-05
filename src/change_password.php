<?php
// session_start();

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

// Traitement du changement de mot de passe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Si le token est absent ou invalide, on rejette la requête
        die("Erreur CSRF : requête invalide.");
    }
    $username = $_SESSION['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérification de la correspondance des nouveaux mots de passe
    if ($new_password !== $confirm_password) {
        echo "Les nouveaux mots de passe ne correspondent pas.";
        exit;
    }

    // Récupération du mot de passe actuel de l'utilisateur pour vérification
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Vérification de l'ancien mot de passe
    if (!password_verify($old_password, $hashed_password)) {
        echo "L'ancien mot de passe est incorrect.";
        exit;
    }

    // Hashage du nouveau mot de passe
    $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Mise à jour du mot de passe dans la base de données
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $new_hashed_password, $username);

    if ($stmt->execute()) {
        echo "Votre mot de passe a été mis à jour avec succès.";
        // Vous pouvez également rediriger vers une autre page si nécessaire
    } else {
        echo "Erreur lors de la mise à jour du mot de passe : " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
