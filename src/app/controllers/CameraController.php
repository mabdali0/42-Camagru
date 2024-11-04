<?php

require_once 'Controller.php';

class CameraController extends Controller
{
    public function index()
    {
        $this->render('camera');
    }

    public function uploadImage() {
        header('Content-Type: application/json');

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['image'])) {
            $image = $data['image'];
            $filePath = 'uploads/' . uniqid() . '.png';

            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $data = base64_decode($image);

            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true);
            }

            if (file_put_contents($filePath, $data)) {
                $conn = new mysqli('camagru-db', 'user', 'userpassword', 'camagru');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $user_id = $_SESSION['user_id'];
                $stmt = $conn->prepare("INSERT INTO images (user_id, image) VALUES (?, ?)");
                $stmt->bind_param("is", $user_id, $filePath);

                if (!$stmt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'insertion dans la base de données : ' . $stmt->error]);
                } else {
                    echo json_encode(['success' => true, 'path' => $filePath, 'redirect' => '/home?success_message=Votre image à bien été posté']);
                }

                $stmt->close();
                $conn->close();

            } else {
                echo json_encode(['success' => false, 'message' => 'Échec de la sauvegarde de l\'image.']);
            }

        } else {
            echo json_encode(['success' => false, 'message' => 'Aucune image reçue.']);
        }
        }
    
}
