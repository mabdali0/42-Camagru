<?php
// verify.php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Démarrez la session uniquement si elle n'est pas déjà active
}

$conn = new mysqli('camagru-db', 'user', 'userpassword', 'camagru');

if ($conn->connect_error) {
    $_SESSION['error_message'] = "Échec de la connexion à la base de données.";
    header("Location: /home");
    exit;
}

if (isset($_GET['token_email'])) {
    $token_email = $_GET['token_email'];

    // Rechercher l'utilisateur par token_email
    if ($stmt = $conn->prepare("SELECT * FROM users WHERE token_email = ?")) {
        $stmt->bind_param("s", $token_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // L'utilisateur a été trouvé, valider son compte
            if ($stmt = $conn->prepare("UPDATE users SET email_validated = 1 WHERE token_email = ?")) {
                $stmt->bind_param("s", $token_email);
                $stmt->execute();
                $_SESSION['success_message'] = "Votre compte a été validé avec succès.";
                $_SESSION['email_validated'] = 1; // Enregistrer le nom d'utilisateur dans la session

            } else {
                $_SESSION['error_message'] = "Erreur lors de la préparation de la requête d'activation.";
            }
        } else {
            $_SESSION['error_message'] = "Token invalide.";
        }
    } else {
        $_SESSION['error_message'] = "Erreur lors de la préparation de la requête de recherche.";
    }

    // Rediriger vers la page d'accueil
    header("Location: /home");
    exit;
} else {
    $_SESSION['error_message'] = "Aucun token_email fourni.";
    header("Location: /home");
    exit;
}
