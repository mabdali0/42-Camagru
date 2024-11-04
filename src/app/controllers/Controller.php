<?php

class Controller
{
    protected $translations = [];

    public function __construct()
    {
        // Charger les traductions globalement
        $this->loadTranslations();

        // Démarrer la session si elle n'est pas déjà active
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function loadTranslations()
    {
        include_once 'app/config/init.php'; // Ou tout autre fichier contenant la fonction de chargement des traductions
        $this->translations = loadLanguage(); // Assurez-vous que loadLanguage retourne bien les traductions
    }



    // Méthode pour charger la vue et passer les variables
    protected function render($view, $variables = [])
    {
        $variables['translations'] = $this->translations;
        // Extraire les variables pour les rendre disponibles dans la vue
        extract($variables);

        // Inclure le fichier de vue
        require "app/views/$view.php";
    }
}
