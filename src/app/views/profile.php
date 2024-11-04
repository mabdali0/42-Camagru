<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $translations['profile_page']; ?></title>
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="public/css/navbar.css">
    <?php include 'app/views/layout/head.php'; ?>
</head>
<body>
  <?php include 'app/views/layout/navbar.php'; ?>
  <div class="container">
  <?php if (isset($_SESSION['email_validated']) && $_SESSION['email_validated'] == 0): ?>
    <div class="alert alert-warning" role="alert">
      Veuillez valider votre email pour accéder à toutes les fonctionnalités de Camagru (vérifiez vos spams).
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['message'])) : ?>
      <div class="alert alert-success" role="alert">
          <?php echo htmlspecialchars($_GET['message']); ?>
      </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])) : ?>
      <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($_GET['error']); ?>
      </div>
    <?php endif; ?>

		<div class="main-body">
			<div class="row">
				<div class="col-lg-5">
					<div class="card">
						<div class="card-body">
							<div class="d-flex flex-column align-items-center text-center">
								<!-- <img src="image/avatar.jpg" alt="Admin" class="rounded-circle p-1 bg-primary" width="110"> -->
                <img src="<?php echo isset($_SESSION['image_link']) ? $_SESSION['image_link'] : 'image/avatar.jpg'; ?>" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                <div class="mt-3">
									<h4><?php echo $_SESSION['last_name']; ?> <?php echo $_SESSION['first_name']; ?></h4>
                  <?php if(isset($_SESSION['email_validated']) && $_SESSION['email_validated'] == 1): ?>
                      <span class="badge text-bg-success">Compte validé</span>
                  <?php endif; ?>
									<p class="text-secondary mb-1">@<?php echo $_SESSION['username']; ?></p>
                  <?php if (!isset($_SESSION['42_account'])): ?>
									<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal2">Supprimer mon compte</button>
									<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">Modifier mon mot de passe</button>
                  <?php endif; ?>
                </div>
                <!-- <h4 class="card-title">@billal <?php echo '<pre>' . print_r($_SESSION, true) . '</pre>'; ?></h4> -->

                <div class="form-check form-switch pt-2">
                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php echo ($_SESSION['active_notification'] == 1) ? 'checked' : ''; ?>>
                  <label style="margin-top: 0px !important;" class="form-check-label" for="flexSwitchCheckChecked">Activer les notifications par mail</label>
                </div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="card">
						<div class="card-body">
              <form action="change-profile-info" method="POST">
                <div class="form-group">
                  <label for="last_name"><?php echo $translations['last_name']; ?></label>
                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $translations['last_name']; ?>" value="<?php echo $_SESSION['last_name']; ?>" <?php if (isset($_SESSION['42_account'])) { echo 'disabled'; } ?>>
                </div>

                <div class="form-group">
                  <label for="first_name"><?php echo $translations['first_name']; ?></label>
                  <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $translations['first_name']; ?>" value="<?php echo $_SESSION['first_name']; ?>" <?php if (isset($_SESSION['42_account'])) { echo 'disabled'; } ?>>
                </div>

                <div class="form-group">
                  <label for="username"><?php echo $translations['username']; ?></label>
                  <input type="text" class="form-control" name="username" id="first_name" placeholder="<?php echo $translations['username']; ?>" value="<?php echo $_SESSION['username']; ?>" <?php if (isset($_SESSION['42_account'])) { echo 'disabled'; } ?>>
                </div>

                <div class="form-group mb-4">
                  <label for="email"><?php echo $translations['email']; ?></label>
                  <input type="email" class="form-control" name="email" id="first_name" placeholder="<?php echo $translations['email']; ?>" value="<?php echo $_SESSION['email']; ?>" <?php if (isset($_SESSION['42_account'])) { echo 'disabled'; } ?>>
                </div>
                <?php if (!isset($_SESSION['42_account'])): ?>
                <div class="form-group">
                  <button type="submit" class="btn btn-secondary btn-lg">Modifier mes infos</button>
                </div>
                <?php endif; ?>
                </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification du mot de passe</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/change-password" method="POST">
          <div class="form-group">
            <label for="password"><?php echo $translations['password']; ?></label>
            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="<?php echo $translations['password']; ?>">
          </div>
          <div class="form-group">
            <label for="confirm_password"><?php echo $translations['confirm_password']; ?></label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="<?php echo $translations['confirm_password']; ?>">
          </div>
        <button type="submit" class="btn btn-secondary btn-lg">Modifier le mot de passe</button>
      </form>
        </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Êtes vous sûr?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <a href="/delete-account">
          <button type="button" class="btn btn-danger btn-lg">Oui</button>
        </a>
        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal" aria-label="Close">Non, annuler</button>
      </div>
    </div>
  </div>
</div>

</body>
<?php include 'app/views/layout/footer.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationSwitch = document.getElementById('flexSwitchCheckChecked');

        notificationSwitch.addEventListener('change', function () {
            const isChecked = this.checked;

            // Envoyer la requête AJAX
            fetch('/update-notification-settings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'active_notification=' + isChecked
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Paramètres de notification mis à jour avec succès.');
                } else {
                    console.error('Erreur lors de la mise à jour : ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur :', error);
            });
        });
    });
</script>

</html>
