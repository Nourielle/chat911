<?php
session_start();
require 'db.php';
$pdo = getDBConnection();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $password = trim($_POST['password']); // Nettoyage des entrées utilisateur
    $csrf_token = $_POST['csrf_token'];
    
    // Vérification du jeton CSRF
    if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
        echo "Requête invalide. Veuillez réessayer.";
        exit;
    }
    
    // Vérifier si le mot de passe est correct
    $stmt = $pdo->prepare('SELECT password FROM users WHERE id = :user_id');
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch();
    
    if (!$user || !password_verify($password, $user['password'])) {
        echo "Mot de passe incorrect. Veuillez réessayer.";
        exit;
    }

    $pdo->beginTransaction();
    try {
        // Suppression des messages de l'utilisateur
        $stmt = $pdo->prepare('DELETE FROM messages WHERE sender_id = :user_id');
        $stmt->execute(['user_id' => $userId]);

        // Suppression de l'utilisateur
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :user_id');
        $stmt->execute(['user_id' => $userId]);

        $pdo->commit();
        session_destroy();
        header('Location: index.html');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Une erreur est survenue, veuillez réessayer plus tard.";
    }
}
?>
