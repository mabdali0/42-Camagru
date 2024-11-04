<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $translations['sign_in_or_sign_up_page']; ?></title>
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="public/css/form.css">
    <?php include 'app/views/layout/head.php'; ?>
</head>
<body>


    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form class="login-or-register">
    <?php if (isset($_GET['message'])): ?>
    <div class="container">

        <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
        </div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
    <div class="container">

        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
        </div>
    <?php endif; ?>
        <a href="/register">
            <div class="btn"><?php echo $translations['sign_up']; ?></div>
        </a>
        <a href="/login">
            <div class="btn"><?php echo $translations['sign_in']; ?></div>
        </a>
        <a href="https://api.intra.42.fr/oauth/authorize?client_id=u-s4t2ud-b859f12a58cec91d13bbe81962d113cb01813f345f3c38944643a3190f3a0cf2&redirect_uri=http%3A%2F%2Flocalhost%2Flogin-with-42&response_type=code">
            <div class="btn login_with_42"><?php echo $translations['sign_in_with']; ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 57 40" height="18" class="ml-1 transition-all fill-white group-hover:fill-black"><path d="M31.627.205H21.084L0 21.097v8.457h21.084V40h10.543V21.097H10.542L31.627.205M35.349 10.233 45.58 0H35.35v10.233M56.744 10.542V0H46.512v10.542L36.279 21.085v10.543h10.233V21.085l10.232-10.543M56.744 21.395 46.512 31.628h10.232V21.395"></path></svg>
            </div>
        </a>
    </form>
</body>

</html>
