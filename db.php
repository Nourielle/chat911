<?php
// Informations de connexion à la base de données
define('DB_HOST', 'localhost:3306');  // L'hôte de votre base de données
define('DB_NAME', 'shadowcomm');  // Le nom de votre base de données
define('DB_USER', 'root');  // Votre nom d'utilisateur MySQL
define('DB_PASS', '');  // Votre mot de passe MySQL

// Fonction pour établir la connexion à la base de données
function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
