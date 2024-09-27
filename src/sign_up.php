<?php
// Include your language file or any required files
include_once 'lang.php'; // Assurez-vous que le chemin est correct

$translations = loadLanguage();
$error_message = ''; // Variable pour stocker les messages d'erreur

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Vérifier si les champs sont vides
    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "Tous les champs doivent être remplis.";
    } // Vérification de l'email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "L'adresse email est invalide.";
    }

    // Vérification du mot de passe
    elseif (strlen($password) < 8) {
        $error_message = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error_message = "Le mot de passe doit contenir au moins une lettre majuscule.";
    } elseif (!preg_match('/[a-z]/', $password)) {
        $error_message = "Le mot de passe doit contenir au moins une lettre minuscule.";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error_message = "Le mot de passe doit contenir au moins un chiffre.";
    } else if ($password !== $confirm_password) {
        $error_message = "Les mots de passe ne correspondent pas.";
    }

    else {
        // Connectez-vous à votre base de données
        $conn = new mysqli('camagru-db', 'user', 'userpassword', 'camagru');

        // Vérifiez la connexion
        if ($conn->connect_error) {
            $error_message = "Erreur de connexion à la base de données.";
        } else {
                // Vérifier si l'username ou l'email existe déjà
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Vérifier si l'username ou l'email existe déjà
            $error_message = '';
            while ($row = $result->fetch_assoc()) {
                if ($row['username'] === $username && $row['username'] === $username) {
                    $error_message = "Le pseudo et l'email sont déjà utilisé.";
                    break;
                }
                elseif ($row['username'] === $username) {
                    $error_message = "Le pseudo est déjà utilisé.";
                    break;
                }
                elseif ($row['email'] === $email) {
                    $error_message = "L'email est déjà utilisé.";
                    break;
                }
            }
            // Hacher le mot de passe avant de l'enregistrer
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insérer l'utilisateur dans la base de données
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['username'] = $username; // Enregistrer le nom d'utilisateur dans la session
                header("Location: /"); // Rediriger vers la page d'accueil
                exit;
            }
            
            $stmt->close();
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $translations['sign_up_page']; ?></title>
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
    <form action="/sign_up" method="POST">
        <h3><?php echo $translations['sign_up']; ?></h3>

        <label for="username"><?php echo $translations['username']; ?></label>
        <input type="text" placeholder="<?php echo $translations['username']; ?>" id="username" name="username" required>
        
        <label for="email"><?php echo $translations['email']; ?></label>
        <input type="text" placeholder="<?php echo $translations['email']; ?>" id="email" name="email" required>
        
        <label for="password"><?php echo $translations['password']; ?></label>
        <input type="password" placeholder="<?php echo $translations['password']; ?>" id="password" name="password" required>
        
        <label for="confirm_password"><?php echo $translations['confirm_password']; ?></label>
        <input type="password" placeholder="<?php echo $translations['confirm_password']; ?>" id="confirm_password" name="confirm_password" required>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message" style="color: red;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <button><?php echo $translations['sign_up_form']; ?></button>
        <a href="https://api.intra.42.fr/oauth/authorize?client_id=u-s4t2ud-971784524958ec92f5e82fe4f0730931e50681b2eb35353afeba44f79893734e&redirect_uri=http%3A%2F%2Fdev.42companion.com%2Fauth%2Fcallback&response_type=code">
            <div class="btn login_with_42"><?php echo $translations['sign_up_with']; ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 57 40" height="18" class="ml-1 transition-all fill-white group-hover:fill-black"><path d="M31.627.205H21.084L0 21.097v8.457h21.084V40h10.543V21.097H10.542L31.627.205M35.349 10.233 45.58 0H35.35v10.233M56.744 10.542V0H46.512v10.542L36.279 21.085v10.543h10.233V21.085l10.232-10.543M56.744 21.395 46.512 31.628h10.232V21.395"></path></svg>
            </div>
        </a>
    </form>
</body>
</html>
