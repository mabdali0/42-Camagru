<?php
include 'lang.php'; // Assurez-vous que le chemin est correct
$translations = loadLanguage();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si non connecté, rediriger vers la page de connexion
    header("Location: signin_or_signup.php");
    exit;
}

// Si connecté, afficher la page d'accueil
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Camagru</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers ton fichier CSS -->
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur Camagru, <?php echo $_SESSION['username']; ?> !</h1>
        <p>Voici l'application où vous pouvez partager et éditer vos photos.</p>

        <!-- Bouton de déconnexion -->
        <form action="logout.php" method="POST">
            <button type="submit">Se déconnecter<?php echo $translations['login']; ?></button>
        </form>
    </div>
</body>
</html>
