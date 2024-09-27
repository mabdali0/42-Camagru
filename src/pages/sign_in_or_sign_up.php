<?php
include_once 'lang.php'; // Assurez-vous que le chemin est correct

    $translations = loadLanguage();
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Démarrez la session uniquement si elle n'est pas déjà active
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $translations['sign_in_or_sign_up_page']; ?></title>
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
    <form>
        <a href="/sign_up">
            <div class="btn"><?php echo $translations['sign_up']; ?></div>
        </a>
        <a href="/sign_in">
            <div class="btn"><?php echo $translations['sign_in']; ?></div>
        </a>
        <a href="https://api.intra.42.fr/oauth/authorize?client_id=u-s4t2ud-971784524958ec92f5e82fe4f0730931e50681b2eb35353afeba44f79893734e&redirect_uri=http%3A%2F%2Fdev.42companion.com%2Fauth%2Fcallback&response_type=code">
            <div class="btn login_with_42"><?php echo $translations['sign_in_with']; ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 57 40" height="18" class="ml-1 transition-all fill-white group-hover:fill-black"><path d="M31.627.205H21.084L0 21.097v8.457h21.084V40h10.543V21.097H10.542L31.627.205M35.349 10.233 45.58 0H35.35v10.233M56.744 10.542V0H46.512v10.542L36.279 21.085v10.543h10.233V21.085l10.232-10.543M56.744 21.395 46.512 31.628h10.232V21.395"></path></svg>
            </div>
        </a>
    </form>
</body>
</html>
