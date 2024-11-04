<?php
// Inclure les traductions
include_once 'lang.php'; 
$translations = loadLanguage();

// Récupérer l'URL actuelle
$current_page = $_SERVER['REQUEST_URI'];
?>

<div class="container">
  <footer>
    <p>© 2024 Camagru, Développé par Lamine ABDALI</p>

    <ul class="nav-footer">
      <li class="nav-item-footer"><a href="/home" class="nav-link-footer"><?php echo $translations['home']; ?></a></li>
      <li class="nav-item-footer"><a href="/camera" class="nav-link-footer"><?php echo $translations['camera']; ?></a></li>
      <li class="nav-item-footer"><a href="/profile" class="nav-link-footer"><?php echo $translations['profile']; ?></a></li>
      <li class="nav-item-footer"><a href="/about" class="nav-link-footer"><?php echo $translations['about']; ?></a></li>
    </ul>
  </footer>
</div>