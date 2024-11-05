<?php

function getUserToken($code) {
    // Récupération des variables d'environnement
    $uid = 'u-s4t2ud-b859f12a58cec91d13bbe81962d113cb01813f345f3c38944643a3190f3a0cf2';
    $secret = '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';
    $redirect_uri = 'http://camagru.com/auth-42-api';

    // Initialisation de cURL
    $ch = curl_init();

    // Configuration des options de cURL
    curl_setopt($ch, CURLOPT_URL, 'https://api.intra.42.fr/oauth/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);

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
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Vérification du statut HTTP et gestion des erreurs
    if ($http_code == 200) {
        $json = json_decode($response, true);
        return $json['access_token'];
    } else {
        error_log('Erreur lors de la requête API, statut : ' . $http_code);
        return null;
    }
}

function get42Datas() {
    if (isset($_GET['code'])) {
        $code = $_GET['code'];
        $access_token = getUserToken($code);

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
                    
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['image_link'] = $user['image_link'];
                    $_SESSION['email_validated'] = 1;
                    $_SESSION['42_account'] = 1;
                } else {
                    // L'utilisateur n'existe pas, on le crée
                    $password = "default_password";
                    $email_validated = 1;
                    $account_42 = 1;
                    $stmt = $conn->prepare("INSERT INTO users (username, last_name, first_name, email, password, image_link, email_validated, 42_account) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssssii", $student_info->login, $student_info->last_name, $student_info->first_name, $student_info->email, $password, $student_info->image_link, $email_validated, $account_42);
                    
                    if ($stmt->execute()) {
                        // Sauvegarde des informations de l'utilisateur dans la session
                        $_SESSION['username'] = $student_info->login;
                        $_SESSION['last_name'] = $student_info->last_name;
                        $_SESSION['first_name'] = $student_info->first_name;
                        $_SESSION['email'] = $student_info->email;
                        $_SESSION['image_link'] = $student_info->image->link;
                        $_SESSION['email_validated'] = 1;
                        $_SESSION['42_account'] = 1;
                    } else {
                        error_log('Erreur lors de la création de l\'utilisateur : ' . $stmt->error);
                    }
                }

                $stmt->close();
                $conn->close();
                header("Location: /");
                exit;
            } else {
                echo "Erreur d'authentification avec l'API de 42.";
            }
        } else {
            echo "Erreur de vérification du token dans l'API de 42.";
        }
    }
}

get42Datas();
