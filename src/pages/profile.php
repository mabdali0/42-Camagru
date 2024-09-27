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
		<div class="main-body">
			<div class="row">
				<div class="col-lg-5">
					<div class="card">
						<div class="card-body">
							<div class="d-flex flex-column align-items-center text-center">
								<img src="avatar.jpg" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
								<div class="mt-3">
									<h4>Lamine ABDALI</h4>
									<p class="text-secondary mb-1">@<?php echo $_SESSION['username']; ?></p>
									<button class="btn btn-danger">Supprimer mon compte</button>
									<button class="btn btn-warning">Modifier mon mot de passe</button>
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
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $translations['last_name']; ?>" value="<?php echo $_SESSION['last_name']; ?>">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $translations['first_name']; ?></label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $translations['first_name']; ?>" value="<?php echo $_SESSION['first_name']; ?>">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $translations['username']; ?></label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $translations['username']; ?>" value="<?php echo $_SESSION['username']; ?>">
              </div>

              <div class="form-group mb-4">
                <label for="exampleInputEmail1"><?php echo $translations['email']; ?></label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $translations['email']; ?>" value="<?php echo $_SESSION['email']; ?>">
              </div>

              <div class="form-group">
                <button type="button" class="btn btn-secondary btn-lg">Modifier mes infos</button>
              </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
