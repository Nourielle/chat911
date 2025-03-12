<?php
ob_start();
session_start();
require 'db.php';
$pdo = getDBConnection(); // Obtenir une connexion PD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Connexion réussie : démarrer la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Rediriger vers le chat
        header("Location: chat.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Nom d'utilisateur ou mot de passe incorrect.</p>";
    }
}
ob_end_flush()
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShadowComm - Connexion</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <h1>Connexion à ShadowComm</h1>
        <form action="login.php" method="POST">
            <label for="username">Nom de code :</label>
            <input type="text" id="username" name="username" required>
  
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore inscrit ? <a href="register.php">Inscrivez-vous ici</a></p>
    </div>
</body>
</html>