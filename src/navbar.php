<?php
// Inclure les traductions
include_once 'lang.php'; 
$translations = loadLanguage();

// Récupérer l'URL actuelle
$current_page = $_SERVER['REQUEST_URI'];
?>

<div class="header mb-5">
  <a href="/home" class="logo">Camagru</a>
  <div class="header-right">
    <!-- Vérification dynamique pour ajouter la classe active -->
    <a class="nav-link <?php echo ($current_page == '/home') ? 'active' : ''; ?>" href="/home">
      <?php echo $translations['home']; ?>
    </a>
    <a class="nav-link <?php echo ($current_page == '/profile') ? 'active' : ''; ?>" href="/profile">
      <?php echo $translations['profile']; ?>
    </a>
    <a class="nav-link <?php echo ($current_page == '/about') ? 'active' : ''; ?>" href="/about">
      <?php echo $translations['about']; ?>
    </a>
    <a href="/logout"><img src="logout.png" alt=""></a>
  </div>
</div>
