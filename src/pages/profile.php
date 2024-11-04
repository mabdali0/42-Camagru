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
    <title><?php echo $translations['profile_page']; ?></title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container">
  <?php if (isset($_SESSION['email_validated']) && $_SESSION['email_validated'] == 0): ?>
    <div class="alert alert-warning" role="alert">
      Veuillez valider votre email pour accéder à toutes les fonctionnalités de Camagru (vérifiez vos spams).
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
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="card">
						<div class="card-body">

              <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $translations['last_name']; ?></label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $translations['last_name']; ?>" value="<?php echo $_SESSION['last_name']; ?>" <?php if (isset($_SESSION['42_account'])) { echo 'disabled'; } ?>>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $translations['first_name']; ?></label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $translations['first_name']; ?>" value="<?php echo $_SESSION['first_name']; ?>" <?php if (isset($_SESSION['42_account'])) { echo 'disabled'; } ?>>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $translations['username']; ?></label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $translations['username']; ?>" value="<?php echo $_SESSION['username']; ?>" <?php if (isset($_SESSION['42_account'])) { echo 'disabled'; } ?>>
              </div>

              <div class="form-group mb-4">
                <label for="exampleInputEmail1"><?php echo $translations['email']; ?></label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $translations['email']; ?>" value="<?php echo $_SESSION['email']; ?>" <?php if (isset($_SESSION['42_account'])) { echo 'disabled'; } ?>>
              </div>
              <?php if (!isset($_SESSION['42_account'])): ?>
              <div class="form-group">
                <button type="button" class="btn btn-secondary btn-lg">Modifier mes infos</button>
              </div>
              <?php endif; ?>
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
        <div class="form-group">
          <label for="password"><?php echo $translations['password']; ?></label>
          <input type="password" class="form-control" id="password" placeholder="<?php echo $translations['password']; ?>">
        </div>
        <div class="form-group">
          <label for="confirm_password"><?php echo $translations['confirm_password']; ?></label>
          <input type="password" class="form-control" id="confirm_password"placeholder="<?php echo $translations['confirm_password']; ?>">
        </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-lg">Modifier le mot de passe</button>
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
        <button type="button" class="btn btn-danger btn-lg">Oui</button>
        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal" aria-label="Close">Non, annuler</button>
      </div>
    </div>
  </div>
</div>


</body>
<?php include 'footer.php'; ?>
</html>
