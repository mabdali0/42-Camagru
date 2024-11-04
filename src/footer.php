<?php
// Inclure les traductions
include_once 'lang.php'; 
$translations = loadLanguage();

// Récupérer l'URL actuelle
$current_page = $_SERVER['REQUEST_URI'];
?>

<div class="container">
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-body-secondary">© 2024 Camagru, Développé par Lamine ABDALI</p>

    <ul class="nav col-md-4 justify-content-end">
      <li class="nav-item"><a href="/home" class="nav-link px-2 text-body-secondary"><?php echo $translations['home']; ?></a></li>
      <li class="nav-item"><a href="/camera" class="nav-link px-2 text-body-secondary"><?php echo $translations['camera']; ?></a></li>
      <li class="nav-item"><a href="/profile" class="nav-link px-2 text-body-secondary"><?php echo $translations['profile']; ?></a></li>
      <li class="nav-item"><a href="/about" class="nav-link px-2 text-body-secondary"><?php echo $translations['about']; ?></a></li>
    </ul>
  </footer>
</div>