<?php
include_once 'lang.php'; // Assurez-vous que le chemin est correct
session_start(); // Démarrez la session pour utiliser $_SESSION

$translations = loadLanguage();

$error_message = ""; // Pour stocker les messages d'erreur

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username_or_email = $_POST['username_or_email'];
    $password = $_POST['password'];

    // Connectez-vous à votre base de données
    $conn = new mysqli('camagru-db', 'user', 'userpassword', 'camagru');

    // Vérifiez la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparer la requête pour vérifier si l'utilisateur existe
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifiez si l'utilisateur existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Récupérer les données de l'utilisateur

        // Vérifier le mot de passe
        if (password_verify($password, $user['password'])) {
            // Mot de passe correct, connecter l'utilisateur
            $_SESSION['username'] = $user['username']; // Enregistrer le nom d'utilisateur dans la session
            header("Location: /home"); // Rediriger vers la page d'accueil
            exit;
        } else {
            $error_message = "Le mot de passe est incorrect.";
        }
    } else {
        $error_message = "L'utilisateur n'existe pas.";
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $translations['sign_in_page']; ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST" action="">
        <h3><?php echo $translations['sign_in']; ?></h3>

        <label for="username_or_email"><?php echo $translations['username_or_email']; ?></label>
        <input type="text" placeholder="<?php echo $translations['username_or_email']; ?>" id="username_or_email" name="username_or_email" required>

        <label for="password"><?php echo $translations['password']; ?></label>
        <input type="password" placeholder="<?php echo $translations['password']; ?>" id="password" name="password" required>

        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <button type="submit"><?php echo $translations['sign_in_form']; ?></button>
        <a href="https://api.intra.42.fr/oauth/authorize?client_id=u-s4t2ud-971784524958ec92f5e82fe4f0730931e50681b2eb35353afeba44f79893734e&redirect_uri=http%3A%2F%2Fdev.42companion.com%2Fauth%2Fcallback&response_type=code">
            <div class="btn login_with_42"><?php echo $translations['sign_in_with']; ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 57 40" height="18" class="ml-1 transition-all fill-white group-hover:fill-black"><path d="M31.627.205H21.084L0 21.097v8.457h21.084V40h10.543V21.097H10.542L31.627.205M35.349 10.233 45.58 0H35.35v10.233M56.744 10.542V0H46.512v10.542L36.279 21.085v10.543h10.233V21.085l10.232-10.543M56.744 21.395 46.512 31.628h10.232V21.395"></path></svg>
            </div>
        </a>
    </form>
</body>
</html>
