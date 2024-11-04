<?php

class UserController
{
    public function index()
    {
        echo 'Bienvenue sur la page d\'accueil.';
    }

    public function listUsers()
    {
        // Logique pour récupérer et afficher la liste des utilisateurs
        echo 'Liste des utilisateurs :';
        // Par exemple, vous pourriez récupérer des utilisateurs à partir d'un modèle User
    }

    public function createUser()
    {
        // Logique pour afficher le formulaire de création d'utilisateur
        echo 'Formulaire de création d\'utilisateur.';
    }
}
