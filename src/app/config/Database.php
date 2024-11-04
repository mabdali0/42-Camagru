<?php
class Database {
    // Attributs privés pour les informations de connexion
    private static $host = 'camagru-db';
    private static $dbname = 'camagru';
    private static $username = 'user';
    private static $password = 'userpassword';
    private static $pdo = null;

    // Méthode publique statique pour récupérer l'instance PDO
    public static function getDb() {
        // Vérifier si une connexion existe déjà
        if (self::$pdo === null) {
            try {
                // Créer une nouvelle instance PDO et la stocker dans self::$pdo
                self::$pdo = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8", self::$username, self::$password);
                
                // Activer les exceptions pour les erreurs
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // En cas d'erreur de connexion, afficher le message
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        // Retourner l'instance PDO
        return self::$pdo;
    }
}
