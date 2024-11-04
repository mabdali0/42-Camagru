<?php

require_once 'Controller.php';

class ProfileController extends Controller
{
    public function index()
    {
        $this->render('profile');
    }

    public function deleteAccount()
    {
        $user = new User();
        // Appeler la méthode deleteUser pour supprimer l'utilisateur
        $user->deleteUser($_SESSION['username']);
    }
}
