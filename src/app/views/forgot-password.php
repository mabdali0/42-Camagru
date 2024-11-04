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
    <form method="POST" action="/send-mail-forgot-password">
        <h3><?php echo $translations['forgot-password']; ?></h3>

        <label for="email"><?php echo $translations['email']; ?></label>
        <input type="text" id="email" name="email" required>

        <?php if (!empty($_GET['error'])): ?>
            <div class="error-message" style="color: red;">
                <?php echo ($_GET['error']); ?>
            </div>
            <?php endif; ?>
            
            <button type="submit" class="btn">
                <?php echo $translations['forgot_password_form']; ?>
            </button>
            <a href="/login_or_register" class="btn">&#8592; Retour</a>
    </form>
</body>
</html>
