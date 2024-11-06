<?php

require_once 'Controller.php';
require_once 'app/models/User.php'; // Le modèle User pour gérer les utilisateurs
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;







class AuthController extends Controller
{
    // Affiche le formulaire de connexion
    public function indexLoginOrRegister()
    {
        $this->render('login_or_register');
    }

    // Affiche le formulaire d'inscription
    public function indexRegister()
    {
        $this->render('register');
    }

    // Affiche le formulaire de connexion
    public function indexLogin()
    {
        $this->render('login');
    }

    // Affiche le formulaire de connexion
    public function indexForgotPassword()
    {
        $this->render('forgot-password');
    }

    // Affiche le formulaire de connexion
    public function indexReinitPassword()
    {
        $user = new User;
        if($user->verifyTokenPassword($_GET['token_email']))
        {
        $this->render('reinit-password');
        }
        else{
            $this->render('login_or_register', ['error' => "Votre lien est invalide"]);
        }
    }
    
    // Traite l'inscription d'un nouvel utilisateur
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                // Si le token est absent ou invalide, on rejette la requête
                die("Erreur CSRF : requête invalide.");
            }
            $user = new User();
            $user->create(
                $_POST['username'], 
                $_POST['last_name'], 
                $_POST['first_name'], 
                $_POST['email'], 
                $_POST['password'], 
                $_POST['confirm_password']);
        }else {
            $this->render('register');
        }
    }

    // Traite la connexion de l'utilisateur
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                // Si le token est absent ou invalide, on rejette la requête
                die("Erreur CSRF : requête invalide.");
            }
            $user = new User();
            $user->login(
                $_POST['username_or_email'], 
                $_POST['password']);
        }else {
            $this->render('login');
        }
    }

    public function getUserToken($code) {
        // Récupération des variables d'environnement
        $this->loadEnv('/var/www/html/.env');

        $uid = getenv('42_UID');
        $secret = getenv('42_SECRET');
        $redirect_uri = 'http://localhost:8080/login-with-42';
        // Initialisation de cURL
        $ch = curl_init();
    
        // Configuration des options de cURL
        curl_setopt($ch, CURLOPT_URL, 'https://api.intra.42.fr/oauth/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Pour obtenir la réponse sous forme de string
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);        // Timeout en secondes
        curl_setopt($ch, CURLOPT_POST, 1);            // Requête POST
    
        // Paramètres de la requête POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'authorization_code',
            'client_id' => $uid,
            'client_secret' => $secret,
            'code' => $code,
            'redirect_uri' => $redirect_uri,
        ]));
    
        // Exécution de la requête et récupération de la réponse
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // Récupération du statut HTTP
        curl_close($ch);  // Fermeture de cURL
    
        // Vérification du statut HTTP et gestion des erreurs
        if ($http_code == 200) {
            $json = json_decode($response, true);  // Décodage de la réponse JSON
            return $json['access_token'];  // Retourne le token d'accès
        } else {
            error_log('Erreur lors de la requête API, statut : ' . $http_code);
            return null;
        }
    }


    function loginWith42() {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $access_token = $this->getUserToken($code); // Fonction pour récupérer le token
    
            if ($access_token) {
                // Récupération des données de l'utilisateur
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.intra.42.fr/v2/me');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Authorization: Bearer $access_token"
                ]);
    
                $response = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
    
                if ($http_code == 200) {
                    $student_info = json_decode($response);
    
                    // Connexion à la base de données
                    $conn = new mysqli('camagru-db', 'user', 'userpassword', 'camagru');
                    
                    if ($conn->connect_error) {
                        die("Erreur de connexion : " . $conn->connect_error);
                    }
    
                    // Vérifier si l'utilisateur existe déjà dans la base de données
                    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
                    $stmt->bind_param("s", $student_info->email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();
                    if ($user) {
                        // L'utilisateur existe déjà, on le connecte
                        
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['last_name'] = $user['last_name'];
                        $_SESSION['first_name'] = $user['first_name'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['image_link'] = $user['image_link']; // S'assurer que l'image est dans la session
                        $_SESSION['email_validated'] = 1; // Enregistrer le nom d'utilisateur dans la session
                        $_SESSION['42_account'] = 1; // Enregistrer le nom d'utilisateur dans la session
                        $_SESSION['active_notification'] = $user['active_notification']; // Enregistrer le nom d'utilisateur dans la session
                    } else {
                        // L'utilisateur n'existe pas, on le crée
                        $password = "default_password"; // Remplace par une logique de mot de passe sécurisée
                        $email_validated = 1; // Remplace par une logique de mot de passe sécurisée
                        $account_42 = 1; // Remplace par une logique de mot de passe sécurisée
                        $image_link = "image/avatar.jpg";
                        $token_email = "none";
                        $stmt = $conn->prepare("INSERT INTO users (username, last_name, first_name, email, password, image_link, email_validated, 42_account, token_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        
                        if ($stmt === false) {
                            die("Erreur de préparation de la requête : " . $conn->error);
                        }
                        $stmt->bind_param("ssssssiis", $student_info->login, $student_info->last_name, $student_info->first_name, $student_info->email, $password, $image_link, $email_validated, $account_42, $token_email);
                        
                        if ($stmt->execute()) {
                            die("Erreur de préparation de la requête : " . $conn->error);
                            // Sauvegarde des informations de l'utilisateur dans la session
                            $_SESSION['username'] = $student_info->login;
                            $_SESSION['last_name'] = $student_info->last_name;
                            $_SESSION['first_name'] = $student_info->first_name;
                            $_SESSION['email'] = $student_info->email;
                            $_SESSION['image_link'] = $student_info->image->link;
                            $_SESSION['email_validated'] = 1; // Enregistrer le nom d'utilisateur dans la session
                            $_SESSION['42_account'] = 1; // Enregistrer le nom d'utilisateur dans la session
                            $_SESSION['active_notification'] = 0; // Enregistrer le nom d'utilisateur dans la session
                        } else {
                            die('Erreur lors de la création de l\'utilisateur : ' . $stmt->error);
                        }
                    }
    
                    $stmt->close();
                    $conn->close();
                    // Redirection ou affichage d'un message de succès
                    header("Location: /home"); // Rediriger vers la page d'accueil
                    exit;
                } else {
                    echo "Erreur d'authentification avec l'API de 42.";
                }
            } else {
                echo "Erreur de vérification du token dans l'API de 42.";
            }
        }
    }

    // Déconnecter l'utilisateur
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /login_or_register?message=" . urlencode("Vous avez été déconnecté avec succès."));
        exit();
    }
    function sendMailForgotPassword() {

        
        // Création d'une nouvelle instance de PHPMailer
        $userModel = new User;
        $email = $_POST['email'];
        $user = $userModel->getUserByEmail($email);
        $username = $user['username'];
        $token_email = $user['token_email'];
        $userModel->sendForgotPasswordEmail($email, $token_email, $username);
        header("Location: /login_or_register?message=Un%20lien%20à%20été%20envoyé%20à%20$email"); // Rediriger vers la page d'accueil
    }


    public function changePassword()
    {

        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['username']) && empty($_POST['token_email'])) {
            header("Location: /login_or_register?message=" . urlencode("Veuillez vous connecter pour changer votre mot de passe."));
            exit();
        }

        // Vérifiez que les champs de formulaire sont envoyés
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['new_password'], $_POST['confirm_password'])) {
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            $user = new User;

            // Si l'utilisateur est connecté, utiliser son username
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
            } else {
                // Sinon, récupérer le username à partir du token_email
                $tokenEmail = $_POST['token_email'];
                $username = $user->getUsernameByTokenEmail($tokenEmail);
                if (!$username) {
                    header("Location: /login_or_register?message=" . urlencode("Token invalide ou expiré."));
                    exit();
                }
            }

            // Appel de la méthode du modèle pour changer le mot de passe
            $result = $user->changePassword($username, $newPassword, $confirmPassword);
            

            // Vérifiez le résultat et redirigez avec un message approprié
            if ($result === "Votre mot de passe a été mis à jour avec succès.") {
                if (isset($_SESSION['username'])) {
                    header("Location: /profile?message=" . urlencode($result));
                } else {
                    header("Location: /login_or_register?message=" . urlencode($result));
                }
            } else {
                // Rediriger avec un message d'erreur en cas de problème
                header("Location: /profile?error=" . urlencode($result));
                exit();
            }
        } else {
            header("Location: /profile?error=" . urlencode("Veuillez remplir tous les champs."));
            exit();
        }
    }

    public function changeProfileInfo() {
        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['username'])) {
            header("Location: /login_or_register?message=" . urlencode("Veuillez vous connecter pour changer vos informations de profil."));
            exit();
        }
    
        // Vérifiez que les champs de formulaire sont envoyés
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['username'])) {
            $username = $_SESSION['username'];
            $newFirstName = $_POST['first_name'];
            $newLastName = $_POST['last_name'];
            $newEmail = $_POST['email'];
            $newUsername = $_POST['username'];
    
            // Instancier le modèle User
            $user = new User;
    
            // Appeler la méthode du modèle pour changer les informations du profil
            $result = $user->changeProfileInfo($username, $newFirstName, $newLastName, $newEmail, $newUsername);
    
            // Vérifiez le résultat et redirigez avec un message approprié
            if ($result === "Vos informations de profil ont été mises à jour avec succès.") {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['last_name'] = $_POST['last_name'];
                $_SESSION['first_name'] = $_POST['first_name'];
                $_SESSION['email'] = $_POST['email'];
                header("Location: /profile?message=" . urlencode($result));
            } else {
                // Rediriger avec un message d'erreur en cas de problème
                header("Location: /profile?error=" . urlencode($result));
            }
        } else {
            header("Location: /profile?error=" . urlencode("Veuillez remplir tous les champs."));
            exit();
        }
    }
    
    public function updateNotificationSettings() {
        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['username'])) {
            header("Location: /login_or_register?message=" . urlencode("Veuillez vous connecter pour changer vos paramètres de notification."));
            exit();
        }
    
        // Vérifiez que les données sont envoyées via POST
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['active_notification'])) {
            $username = $_SESSION['username'];
            $activeNotification = $_POST['active_notification'] === 'true' ? 1 : 0;
    
            // Instancier le modèle User
            $user = new User;
    
            // Appeler la méthode du modèle pour mettre à jour les paramètres de notification
            $result = $user->updateNotificationSettings($username, $activeNotification);
    
            if ($result === true) {
                $_SESSION['active_notification'] = $activeNotification; // Mettre à jour la session
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => $result]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => "Requête invalide."]);
        }
    }


    // Fonction pour charger le fichier .env
function loadEnv($file)
{
    if (!file_exists($file)) {
        throw new Exception("Le fichier .env n'a pas été trouvé.");
    }

    // Lire toutes les lignes du fichier .env
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    // Traiter chaque ligne
    foreach ($lines as $line) {
        // Ignorer les lignes de commentaire
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Séparer la clé et la valeur
        list($key, $value) = explode('=', $line, 2);
        
        // Nettoyer la clé et la valeur (enlever les espaces superflus)
        $key = trim($key);
        $value = trim($value);
        
        // Définir la variable d'environnement
        putenv("$key=$value");
    }
}
    


    

}
