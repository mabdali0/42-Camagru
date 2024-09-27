<?php
include_once 'lang.php'; // Assurez-vous que le chemin est correct
$translations = loadLanguage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>homes</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
</head>
<body>
<div class="header">
  <a href="localhost:8080" class="logo">Camagru</a>
  <div class="header-right">
    <a class="active nav-link" href="#home"><?php echo $translations['home']; ?></a>
    <a class="nav-link" href="#contact"><?php echo $translations['profile']; ?></a>
    <a class="nav-link" href="#about"><?php echo $translations['about']; ?></a>
    <a href="/logout"><img src="logout.png" alt=""></a>
  </div>
</div>
</body>
</html>
