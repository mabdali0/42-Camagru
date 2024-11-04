<?php
// init.php
date_default_timezone_set('Europe/Paris'); // ou le fuseau horaire que tu veux utiliser

// Charger les fichiers de traduction
include_once 'lang.php'; 

// Charger les autres fichiers nécessaires comme phpmailer, etc.
include_once 'phpmailer.php'; 

// Démarrer la session si elle n'est pas déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Charger les traductions dans une variable globale
$translations = loadLanguage();