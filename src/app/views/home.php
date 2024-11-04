<!DOCTYPE html>
  <html lang="en">
    <head>
      <title><?php echo $translations['home_page']; ?></title>
      <link rel="stylesheet" href="public/css/styles.css">
      <link rel="stylesheet" href="public/css/navbar.css">
      <?php include 'app/views/layout/head.php'; ?>
    </head>
    <body>
      <?php include 'app/views/layout/navbar.php'; ?>
      <div class="container">

        <?php if(isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['success_message']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); // Supprimer le message après affichage ?>
        <?php endif; ?>

        <?php if(isset($_GET['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $_GET['success_message']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); // Supprimer le message après affichage ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['email_validated']) && $_SESSION['email_validated'] == 0): ?>
          <div class="alert alert-warning" role="alert">
                  Veuillez valider votre email pour accéder aux posts des autres utilisateurs de Camagru.
          </div>
        <?php else: ?>
        <div class="row">
          <?php foreach ($images as $imageData): ?>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
              <div class="card h-100">
                <a href="/image?id=<?php echo $imageData['id']; ?>">
                <img class="card-img-top" src="<?php echo $imageData['image']; ?>" alt="Card image">
                </a>
                <div class="card-body">
                  <h4 class="card-title">@<?php echo $imageData['username']; ?></h4>

                  <p class="card-text"><?php echo $imageData['created_at']; ?></p>
                  <p>
                  <span id="likes-count-<?php echo $imageData['id']; ?>"><?php echo $imageData['nb_likes']; ?></span>
                    <i style="cursor:pointer;" class="fa fa-heart like-button <?php echo($imageData['user_like'] == 1) ? 'liked' : '' ?>" aria-hidden="true" data-image-id="<?php echo $imageData['id']; ?>"></i>
                    <?php echo $imageData['nb_comments']; ?> <a style="color:black !important;" href="/image?id=<?php echo $imageData['id']; ?>"><i class="fa fa-comment" aria-hidden="true"></i></a>

                  </p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <nav aria-label="Pagination">
            <ul class="pagination justify-content-center">

                <!-- Lien vers la page précédente -->
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= ($page - 1); ?>" tabindex="-1">Précédent</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Précédent</a>
                    </li>
                <?php endif; ?>

                <!-- Liens vers les pages numérotées -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Lien vers la page suivante -->
                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= ($page + 1); ?>">Suivant</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Suivant</a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
        <?php endif; ?>
      </div>
      <?php include 'app/views/layout/footer.php'; ?>
      <script src="public/js/home.js"></script>
  </body>
</html>

