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
    <title><?php echo $translations['home_page']; ?></title>
 
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
  <?php if(isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); // Supprimer le message après affichage ?>
<?php endif; ?>

<?php if(isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error_message']); // Supprimer le message après affichage ?>
<?php endif; ?>


<?php if (isset($_SESSION['email_validated']) && $_SESSION['email_validated'] == 1): ?>
  <div class="row">
    <!-- Card 1 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <h4 class="card-title">@billal <?php echo '<pre>' . print_r($_SESSION, true) . '</pre>'; ?></h4>

          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 4 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

    <!-- Card 5 -->
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="batiment.png" alt="Card image">
        <div class="card-body">
          <h4 class="card-title">@billal</h4>
          <p class="card-text">27/09/2024 à 17:53</p>
          <p>
            4 <i class="fa fa-heart" aria-hidden="true"></i>
            4 <i class="fa fa-comment" aria-hidden="true"></i>
          </p>
        </div>
      </div>
    </div>

  </div>
</div>

<?php else: ?>
    <div class="alert alert-warning" role="alert">
      Veuillez valider votre email pour accéder aux posts des autres utilisateurs de Camagru.
    </div>
<?php endif; ?>

</body>

<?php include 'footer.php'; ?>


</html>
