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
    <form method="POST" action="/change-password">
        <h3><?php echo $translations['change-password']; ?></h3>

        <label for="password"><?php echo $translations['password']; ?></label>
        <input type="password" id="password" name="new_password" required>
        <?php if (isset($_GET['token_email'])) : ?>
            <input type="hidden" id="token_email" name="token_email" value="<?php echo htmlspecialchars($_GET['token_email']); ?>">
        <?php endif; ?>
        <label for="confirm_password"><?php echo $translations['confirm_password']; ?></label>
        <input type="password" class="mb-3" id="confirm_password" name="confirm_password" required>
        <?php if (!empty($_GET['error'])): ?>
            <div class="error-message" style="color: red;">
                <?php echo ($_GET['error']); ?>
            </div>
            <?php endif; ?>
            
            <button type="submit" class="btn">
                <?php echo $translations['sign_in_form']; ?>
            </button>
    </form>
</body>
</html>
