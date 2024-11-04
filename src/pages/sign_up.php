<?php
// Include your language file or any required files
include_once 'lang.php'; // Assurez-vous que le chemin est correct
include_once 'phpmailerrrr.php'; // Assurez-vous que le chemin est correct

require_once 'app/models/User.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Démarrez la session uniquement si elle n'est pas déjà active
}
$translations = loadLanguage();
$error_message = ''; // Variable pour stocker les messages d'erreur

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $user->create(
        $_POST['username'], 
        $_POST['last_name'], 
        $_POST['first_name'], 
        $_POST['email'], 
        $_POST['password'], 
        $_POST['confirm_password']);
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="/sign_up" method="POST">
        <h3><?php echo $translations['sign_up']; ?></h3>

        <label for="last_name"><?php echo $translations['last_name']; ?></label>
        <input type="text" placeholder="<?php echo $translations['last_name']; ?>" id="last_name" name="last_name" required>
        
        <label for="first_name"><?php echo $translations['first_name']; ?></label>
        <input type="text" placeholder="<?php echo $translations['first_name']; ?>" id="first_name" name="first_name" required>
        
        <label for="username"><?php echo $translations['username']; ?></label>
        <input type="text" placeholder="<?php echo $translations['username']; ?>" id="username" name="username" required>
        
        <label for="email"><?php echo $translations['email']; ?></label>
        <input type="text" placeholder="<?php echo $translations['email']; ?>" id="email" name="email" required>
        
        <label for="password"><?php echo $translations['password']; ?></label>
        <input type="password" placeholder="<?php echo $translations['password']; ?>" id="password" name="password" required>
        
        <label for="confirm_password"><?php echo $translations['confirm_password']; ?></label>
        <input type="password" class="mb-3" placeholder="<?php echo $translations['confirm_password']; ?>" id="confirm_password" name="confirm_password" required>
        
        <?php if (!empty($_GET['error'])): ?>
            <div class="error-message" style="color: red;">
                <?php echo ($_GET['error']); ?>
            </div>
        <?php endif; ?>
        <button type="submit" class="btn">
            <?php echo $translations['sign_up_form']; ?>
        </button>
        <a href="https://api.intra.42.fr/oauth/authorize?client_id=u-s4t2ud-b859f12a58cec91d13bbe81962d113cb01813f345f3c38944643a3190f3a0cf2&redirect_uri=http%3A%2F%2Fcamagru.com%2Fauth-42-api&response_type=code">
            <button class="btn login_with_42"><?php echo $translations['sign_up_with']; ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 57 40" height="18" class="ml-1 transition-all fill-white group-hover:fill-black"><path d="M31.627.205H21.084L0 21.097v8.457h21.084V40h10.543V21.097H10.542L31.627.205M35.349 10.233 45.58 0H35.35v10.233M56.744 10.542V0H46.512v10.542L36.279 21.085v10.543h10.233V21.085l10.232-10.543M56.744 21.395 46.512 31.628h10.232V21.395"></path></svg>
            </button>
        </a>
    </form>
</body>
</html>
