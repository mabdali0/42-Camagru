<?php
session_start();

function loadLanguage() {
    // Vérifier si l'utilisateur a sélectionné une langue
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        $_SESSION['lang'] = $lang;
    } elseif (isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else {
        // Définir la langue par défaut
        $lang = 'fr';  // Par exemple, français
    }

    // Charger le fichier de langue correspondant
    $lang_file = 'languages/' . $lang . '.php';

    // Vérifier si le fichier existe
    if (file_exists($lang_file)) {
        return include($lang_file);
    } else {
        // Si le fichier de langue n'existe pas, utiliser la langue par défaut
        return include('languages/fr.php');
    }
}
