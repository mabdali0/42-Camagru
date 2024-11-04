<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $translations['sign_up_page']; ?></title>
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="public/css/form.css">
    <?php include 'app/views/layout/head.php'; ?>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="/register_user" method="POST">
        <h3><?php echo $translations['sign_up']; ?></h3>

        <label for="last_name"><?php echo $translations['last_name']; ?></label>
        <input type="text" id="last_name" name="last_name" required>
        
        <label for="first_name"><?php echo $translations['first_name']; ?></label>
        <input type="text" id="first_name" name="first_name" required>
        
        <label for="username"><?php echo $translations['username']; ?></label>
        <input type="text" id="username" name="username" required>
        
        <label for="email"><?php echo $translations['email']; ?></label>
        <input type="text" id="email" name="email" required>
        
        <label for="password"><?php echo $translations['password']; ?></label>
        <input type="password" id="password" name="password" required>
        
        <label for="confirm_password"><?php echo $translations['confirm_password']; ?></label>
        <input type="password" class="mb-3" id="confirm_password" name="confirm_password" required>
        
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
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 57 40" height="18" class="ml-1 transition-all fill-white group-hover:fill-black">
                    <path d="M31.627.205H21.084L0 21.097v8.457h21.084V40h10.543V21.097H10.542L31.627.205M35.349 10.233 45.58 0H35.35v10.233M56.744 10.542V0H46.512v10.542L36.279 21.085v10.543h10.233V21.085l10.232-10.543M56.744 21.395 46.512 31.628h10.232V21.395"></path>
                </svg>
            </button>
        </a>
        <a href="/login_or_register" class="btn">&#8592; Retour</a>
    </form>
</body>
</html>
