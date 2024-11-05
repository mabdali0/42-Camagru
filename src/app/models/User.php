<?php
// Inclusion du fichier de connexion
require_once 'app/config/Database.php';

class User {
    private $pdo;
    private $error_message;

    // Constructeur qui récupère la connexion à la base de données
    public function __construct() {
        $this->pdo = Database::getDb();
        $this->error_message = '';
    }

    // Méthode pour enregistrer un nouvel utilisateur
    public function create($username, $last_name, $first_name, $email, $password, $confirm_password) {
        // Valider les champs
        if ($this->validate($username, $email, $password, $confirm_password)) {
            // Vérifier si l'email ou l'username existent déjà
            if (!$this->userExists($username, $email)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $token_email = bin2hex(random_bytes(16)); // Générer un token aléatoire pour l'email
                $active_notification = 1;

                try {
                    // Préparer la requête SQL
                    $stmt = $this->pdo->prepare(
                        "INSERT INTO users (username, last_name, first_name, email, password, token_email, active_notification) 
                         VALUES (:username, :last_name, :first_name, :email, :password, :token_email, :active_notification)"
                    );
                    
                    // Associer les valeurs aux paramètres
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hashed_password);
                    $stmt->bindParam(':token_email', $token_email);
                    $stmt->bindParam(':active_notification', $active_notification);
        
                    // Exécuter la requête
                    if ($stmt->execute()) {
                        $this->sendVerificationEmail($email, $token_email);

                        // Enregistrer dans la session
                        
                        $_SESSION['user_id'] = $this->getUserByUsername($username);
                        $_SESSION['email_validated'] = 0;
                        $_SESSION['active_notification'] = 1;
                        $_SESSION['username'] = $username;
                        $_SESSION['username'] = $username;
                        $_SESSION['last_name'] = $last_name;
                        $_SESSION['first_name'] = $first_name;
                        $_SESSION['email'] = $email;
                        header("Location: /");
                        exit;
                    }
                } catch (PDOException $e) {
                    // Gérer les erreurs de la base de données
                    // $this->error_message = "Erreur lors de l'enregistrement : " . $e->getMessage();
                    $this->error_message = "Erreur lors de l'enregistrement avec PDO $e";
                    // return false;
                }
            }
        }
        header("Location: /register?error=" . urlencode($this->error_message));
    }

    // Méthode de validation des données d'utilisateur
    private function validate($username, $email, $password, $confirm_password) {
        if (empty($username) || empty($email) || empty($password)) {
            $this->error_message = "Tous les champs doivent être remplis.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error_message = "L'adresse email est invalide.";
        } elseif (strlen($password) < 8) {
            $this->error_message = "Le mot de passe doit contenir au moins 8 caractères.";
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $this->error_message = "Le mot de passe doit contenir au moins une lettre majuscule.";
        } elseif (!preg_match('/[a-z]/', $password)) {
            $this->error_message = "Le mot de passe doit contenir au moins une lettre minuscule.";
        } elseif (!preg_match('/[0-9]/', $password)) {
            $this->error_message = "Le mot de passe doit contenir au moins un chiffre.";
        } elseif ($password !== $confirm_password) {
            $this->error_message = "Les mots de passe ne correspondent pas.";
        }

        return empty($this->error_message);
    }

    // Vérification si l'utilisateur ou l'email existent déjà
    public function userExists($username, $email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if ($result['username'] === $username) {
                $this->error_message = "Le pseudo est déjà utilisé.";
                return true;
            }
            if ($result['email'] === $email) {
                $this->error_message = "L'email est déjà utilisé.";
                return true;
            }
        }
        return false;
    }

    // Envoi d'un email de confirmation
    private function sendVerificationEmail($email, $token_email) {
        $verificationLink = "http://localhost:8080/verify.php?token_email=" . $token_email;
        $subject = "Validation de votre compte";
        $body = "<p>Bienvenue! Cliquez sur le lien suivant pour valider votre compte:</p>";
        $body .= "<p><a href='" . $verificationLink . "'>Valider mon compte</a></p>";
        
        // Fonction d'envoi d'email à implémenter
        sendConfirmationEmail($email, $subject, $body);
    }

    // Envoi d'un email de confirmation
    public function sendForgotPasswordEmail($email, $token_email, $username) {
        $reinitLink = "http://localhost:8080/password-reinit?token_email=" . $token_email;
        $subject = "Changement de votre mot de passe";
        $body = "<p>Bonjour " . $username . ", Cliquez sur le lien suivant pour réinitialiser votre mot de passe:</p>";
        $body .= "<p><a href='" . $reinitLink . "'>Changer mon mot de passe</a></p>";
        
        // Fonction d'envoi d'email à implémenter
        sendConfirmationEmail($email, $subject, $body);
    }


        // Méthode pour se connecter
        public function login($username_or_email, $password) {
            try {
                // Préparer la requête pour vérifier si l'utilisateur existe (par username ou email)
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username_or_email OR email = :username_or_email");
                $stmt->bindParam(':username_or_email', $username_or_email);
                $stmt->execute();
                
                // Vérifier si l'utilisateur existe
                if ($stmt->rowCount() > 0) {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    // Vérifier le mot de passe
                    if (password_verify($password, $user['password'])) {
                        // Si le mot de passe est correct, démarrer la session utilisateur
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['last_name'] = $user['last_name'];
                        $_SESSION['first_name'] = $user['first_name'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['email_validated'] = $user['email_validated'];
                        $_SESSION['active_notification'] = $user['active_notification'];
    
                        header("Location: /home"); // Rediriger vers la page d'accueil après connexion réussie
                        exit;
                    } else {
                        // Mot de passe incorrect
                        $this->error_message = "Le mot de passe est incorrect.";
                    }
                } else {
                    // L'utilisateur n'existe pas
                    $this->error_message = "L'utilisateur n'existe pas.";

                }
            } catch (PDOException $e) {
                $this->error_message = "Erreur lors de la connexion à la base de données.";
            }
            header("Location: /login?error=" . urlencode($this->error_message));

        }


        private function deleteUserImages($user_id) {
            try {
                // Préparer la requête de suppression des images
                $stmt = $this->pdo->prepare("DELETE FROM images WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
            } catch (PDOException $e) {
                return "Erreur lors de la suppression des images : " . $e->getMessage();
            }
            return true;
        }

        public function deleteUser($username) {
            try {
                // Récupérer l'ID de l'utilisateur
                $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($user) {
                    // Supprimer les images de l'utilisateur
                    $result = $this->deleteUserImages($user['id']);
                    if ($result !== true) {
                        return $result; // Retourner l'erreur si la suppression des images échoue
                    }
    
                    // Préparer la requête de suppression de l'utilisateur
                    $stmt = $this->pdo->prepare("DELETE FROM users WHERE username = :username");
                    $stmt->bindParam(':username', $username);
                    
                    if ($stmt->execute()) {
                        // Si la suppression réussit, détruire la session
                        session_destroy();
                        header("Location: /login_or_register?message=Votre compte a été supprimé avec succès.");
                        exit;
                    } else {
                        return "Erreur lors de la suppression du compte.";
                    }
                } else {
                    return "Utilisateur non trouvé.";
                }
            } catch (PDOException $e) {
                return "Erreur lors de la suppression : " . $e->getMessage();
            }
        }

        // Méthode pour récupérer un utilisateur par ID
        public function getUserById($user_id) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :user_id");
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne l'utilisateur sous forme de tableau associatif
            } catch (PDOException $e) {
                $this->error_message = "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
                return false;
            }
        }
    
        // Méthode pour récupérer un utilisateur par nom d'utilisateur
        public function getUserByUsername($username) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne l'utilisateur sous forme de tableau associatif
            } catch (PDOException $e) {
                $this->error_message = "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
                return false;
            }
    }

            // Méthode pour récupérer un utilisateur par nom d'utilisateur
            public function getUserByEmail($email) {
                try {
                    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                    return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne l'utilisateur sous forme de tableau associatif
                } catch (PDOException $e) {
                    $this->error_message = "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
                    return false;
                }
        }

        public function verifyTokenPassword($token_email) {
            // Préparer la requête pour vérifier si l'utilisateur existe avec ce token
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE token_email = :token_email");
            $stmt->bindParam(':token_email', $token_email);
            $stmt->execute();
            
            // Si un utilisateur est trouvé, on procède à la validation du compte
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function changePassword($username, $newPassword, $confirmPassword) {
            try {
                // Vérifier si le nouveau mot de passe correspond à la confirmation
                if ($newPassword !== $confirmPassword) {
                    return "Les nouveaux mots de passe ne correspondent pas.";
                }
        
                // Récupérer le mot de passe actuel de l'utilisateur
                $stmt = $this->pdo->prepare("SELECT password FROM users WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($user) {
        
                    // Hashage du nouveau mot de passe
                    $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        
                    // Mise à jour du mot de passe dans la base de données
                    $stmt = $this->pdo->prepare("UPDATE users SET password = :newPassword WHERE username = :username");
                    $stmt->bindParam(':newPassword', $newHashedPassword);
                    $stmt->bindParam(':username', $username);
        
                    if ($stmt->execute()) {
                        return "Votre mot de passe a été mis à jour avec succès.";
                    } else {
                        return "Erreur lors de la mise à jour du mot de passe.";
                    }
                } else {
                    return "Utilisateur non trouvé.";
                }
            } catch (PDOException $e) {
                return "Erreur lors de la mise à jour du mot de passe : " . $e->getMessage();
            }
        }

        public function changeProfileInfo($username, $newFirstName, $newLastName, $newEmail, $newUsername) {
            try {
                // Vérifier si l'utilisateur existe
                $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($user) {
                    // Vérifier que l'email n'est pas déjà utilisé par un autre utilisateur
                    $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
                    $stmt->bindParam(':email', $newEmail);
                    $stmt->bindParam(':id', $user['id']);
                    $stmt->execute();
                    $emailExists = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    if ($emailExists) {
                        return "L'email est déjà utilisé par un autre utilisateur.";
                    }
        
                    // Préparer la requête de mise à jour des informations de l'utilisateur
                    $stmt = $this->pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, username = :username WHERE id = :id");
                    $stmt->bindParam(':first_name', $newFirstName);
                    $stmt->bindParam(':last_name', $newLastName);
                    $stmt->bindParam(':email', $newEmail);
                    $stmt->bindParam(':username', $newUsername);
                    $stmt->bindParam(':id', $user['id']);
        
                    if ($stmt->execute()) {
                        return "Vos informations de profil ont été mises à jour avec succès.";
                    } else {
                        return "Erreur lors de la mise à jour des informations du profil.";
                    }
                } else {
                    return "Utilisateur non trouvé.";
                }
            } catch (PDOException $e) {
                return "Erreur lors de la mise à jour des informations du profil : " . $e->getMessage();
            }
        }
        private function sendChangeNotifEmail($email, $active) {
            $subject = "Changement des notifications";
            $body = "<p>Bonjour,</p>";
            $body .= $active 
                ? "<p>Vous avez activé les notifications par e-mail. Vous recevrez désormais des notifications.</p>"
                : "<p>Vous avez désactivé les notifications par e-mail. Vous ne recevrez plus de notifications.</p>";
        
            // Fonction d'envoi d'email à implémenter
            sendConfirmationEmail($email, $subject, $body);
        }

        public function updateNotificationSettings($username, $activeNotification) {
            try {
                // Préparer la requête pour mettre à jour les paramètres de notification
                $stmt = $this->pdo->prepare("UPDATE users SET active_notification = :active_notification WHERE username = :username");
                $stmt->bindParam(':active_notification', $activeNotification, PDO::PARAM_INT);
                $stmt->bindParam(':username', $username);
                $user = new User;
                $user = $user->getUserByUsername($username);
                if ($stmt->execute()) {
                    $this->sendChangeNotifEmail($user['email'], $activeNotification == 1);
                    return true; // Indiquer que la mise à jour a réussi
                } else {
                    return false; // Indiquer une erreur lors de la mise à jour
                }
            } catch (PDOException $e) {
                return "Erreur lors de la mise à jour des paramètres : " . $e->getMessage();
            }
        }        


        public function getUsernameByTokenEmail($tokenEmail)
        {
            try {
                $stmt = $this->pdo->prepare("SELECT username FROM users WHERE token_email = :token_email");
                $stmt->bindParam(':token_email', $tokenEmail);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user ? $user['username'] : false;
            } catch (PDOException $e) {
                return false;
            }
        }

        

}
