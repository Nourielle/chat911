<?php
require 'db.php';
$pdo = getDBConnection(); // Obtenir une connexion PD

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifier si l'utilisateur existe déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    if ($stmt->fetch()) {
        die("Nom de code déjà utilisé. Choisissez un autre.");
    }

    // Vérification du mot de passe
    if ($password !== $confirm_password) {
        die("Les mots de passe ne correspondent pas.");
    }

    // Vérifier le format du nom de code
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        die("Le nom de code ne doit contenir que des lettres, chiffres et underscores.");
    }

    // Vérifier la longueur du mot de passe
    if (strlen($password) < 8) {
        die("Le mot de passe doit contenir au moins 8 caractères.");
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->execute([
        'username' => $username,
        'password' => $hashed_password
    ]);

    // Démarrer une session et rediriger vers le chat après inscription
    session_start();
    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['username'] = $username;

    header("Location: chat.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShadowComm - Inscription</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #ff0000;
            font-family: 'Orbitron', sans-serif;
        }
        .register-form {
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 5px;
            display: inline-block;
            text-align: left;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            background-color: #333;
            color: #fff;
        }
        button {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            width: 100%;
        }
        .checkbox-container {
            margin: 20px 0;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        a {
            color: #ff0000;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>ShadowComm - Inscription</h1>
        <div class="register-form">
            <h2>Formulaire d'inscription</h2>
            <form action="register.php" method="POST">
                <label for="username">Nom de code :</label>
                <input type="text" id="username" name="username" pattern="^[a-zA-Z0-9_]+$" title="Seuls les lettres, chiffres et underscores sont autorisés." required>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" minlength="6" required>

                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" minlength="6" required>

                <input type="checkbox" name="accept" required> J'accepte les règles de confidentialité

                <button type="submit">S'inscrire</button>
            </form>
            <div class="login-link">
                <p>Déjà un compte ? <a href="login.php">Connectez-vous ici</a></p>
            </div>
        </div>
    </div>
</body>
</html>
