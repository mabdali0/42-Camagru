<?php
header('Content-Type: application/json');
// Démarrer la session si elle n'est pas déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Vérifiez que l'image a bien été envoyée
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['image'])) {
    // Récupérer l'image
    $image = $data['image'];
    
    // Définir le chemin de sauvegarde
    $filePath = 'uploads/' . uniqid() . '.png';

    // Enlever l'en-tête "data:image/png;base64," si présent
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    
    // Décodez l'image
    $data = base64_decode($image);
    
    // Vérifiez si le dossier existe, sinon créez-le
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }
    
    // Sauvegarder l'image
    if (file_put_contents($filePath, $data)) {
        // echo json_encode(['success' => true, 'path' => $filePath]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Échec de la sauvegarde de l\'image.']);
    }




    $conn = new mysqli('camagru-db', 'user', 'userpassword', 'camagru');

    // Vérifiez la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO images (user_id, image) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $filePath); // Notez ici le changement à "sssss"
    // echo $filePath;
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Erreur d\'exécution de la requête: ' . $stmt->error]);
    } else {
        header("Location: /home"); // Rediriger vers la page d'accueil

        echo json_encode(['success' => true, 'path' => $filePath]);
    }
    $stmt->close();
    $conn->close();

                header("Location: /home"); // Rediriger vers la page d'accueil
} else {
    echo json_encode(['success' => false, 'message' => 'Aucune image reçue.']);
}
