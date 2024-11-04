<?php
// Inclure les traductions
include_once 'lang.php'; 
$translations = loadLanguage();

// Récupérer l'URL actuelle
$current_page = $_SERVER['REQUEST_URI'];
?>

<div class="header">
  <a href="/home" class="logo">Camagru</a>
  <div class="header-right">
    <!-- Vérification dynamique pour ajouter la classe active -->
    <a class="nav-link <?php echo ($current_page == '/home') ? 'active' : ''; ?>" href="/home">
      <?php echo $translations['home']; ?>
    </a>
    <a class="nav-link <?php echo ($current_page == '/camera') ? 'active' : ''; ?>" href="/camera">
      <?php echo $translations['camera']; ?>
    </a>
    <a class="nav-link <?php echo ($current_page == '/profile') ? 'active' : ''; ?>" href="/profile">
      <?php echo $translations['profile']; ?>
    </a>
    <a class="nav-link <?php echo ($current_page == '/my-posts') ? 'active' : ''; ?>" href="/my-posts">
      <?php echo $translations['my-posts']; ?>
    </a>
    <a href="/logout"><img src="/image/logout.png" alt=""></a>
  </div>
</div>
