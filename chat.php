<?php
session_start();
require 'db.php';
$pdo = getDBConnection(); // Obtenir une connexion PD
// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fonction de chiffrement et déchiffrement sécurisé
function caesarEncrypt($text, $shift = 3) {
    $result = "";
    foreach (mb_str_split($text) as $char) {
        if (ctype_alpha($char)) {
            $offset = ord(ctype_lower($char) ? 'a' : 'A');
            $char = chr((ord($char) + $shift - $offset) % 26 + $offset);
        }
        $result .= $char;
    }
    return $result;
}

function caesarDecrypt($text, $shift = 3) {
    return caesarEncrypt($text, 26 - $shift);
}

// Générer un jeton CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Envoi du message avec protection CSRF
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'], $_POST['csrf_token'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Requête invalide.");
    }

    $message = trim($_POST['message']);
    if (!empty($message)) {
        $encrypted_message = caesarEncrypt($message);
        $user_id = $_SESSION['user_id'];

        // Insertion sécurisée du message
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, content) VALUES (:user_id, :content)");
        $stmt->execute(['user_id' => $user_id, 'content' => $encrypted_message]);
    }
}

// Récupération des messages (ordre décroissant pour afficher les plus récents en premier)
$stmt = $pdo->query("SELECT users.username, messages.content, messages.timestamp 
                     FROM messages 
                     JOIN users ON messages.sender_id = users.id 
                     ORDER BY messages.timestamp DESC");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShadowComm - Chat Sécurisé</title>
    <link rel="stylesheet" href="chat.css">  
    <script src="chat.js"></script> <!-- Ajout du script AJAX -->
</head>
<body>
    <div class="chat-container">
        <h1>Chat Sécurisé</h1>
        
        <div class="messages" id="chat-messages">
            <?php foreach ($messages as $message): ?>
                <div class="message">
                    <span class="username"><?php echo htmlspecialchars($message['username']); ?>:</span>
                    <span class="content"><?php echo htmlspecialchars(caesarDecrypt($message['content'])); ?></span>
                    <span class="timestamp"><?php echo htmlspecialchars($message['timestamp']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="text" name="message" id="message-input" placeholder="Entrez votre message..." required>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</body>
</html>



