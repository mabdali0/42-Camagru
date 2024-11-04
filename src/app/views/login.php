<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $translations['sign_in_page']; ?></title>
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="public/css/form.css">
    <?php include 'app/views/layout/head.php'; ?>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST" action="/login_user">
        <h3><?php echo $translations['sign_in']; ?></h3>

        <label for="username_or_email"><?php echo $translations['username_or_email']; ?></label>
        <input type="text" id="username_or_email" name="username_or_email" required>    
        <label for="password"><?php echo $translations['password']; ?></label>
        <input type="password" class="mb-3" id="password" name="password" required>
        <a href="/forgot-password">Mot de passe oublié</a>
        <?php if (!empty($_GET['error'])): ?>
            <div class="error-message" style="color: red;">
                <?php echo ($_GET['error']); ?>
            </div>
            <?php endif; ?>
            
            <button type="submit" class="btn">
                <?php echo $translations['sign_in_form']; ?>
            </button>
            <a href="/login_or_register" class="btn">&#8592; Retour</a>
    </form>
</body>
</html>
