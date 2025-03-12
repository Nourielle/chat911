<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ministère de la Sécurité</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            overflow: hidden;
            background-color: black;
            color: white;
        }
        

        #video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
        }

        header {
            padding: 15px;
            text-align: center;
            background: rgba(0, 0, 0, 0.8);
        }
        nav {
            background: rgba(0, 0, 0, 0.6);
            padding: 10px;
            text-align: right;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .logo img {
            width: 120px;
            height: 120px;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <video autoplay muted loop id="video-background">
    <source src="vidéo.mp4" type="video/mp4">
        Votre navigateur ne supporte pas la vidéo.
    </video>

    <header>
        <h1>SHADOWCOMM</h1>
    </header>

    <nav>
        <a href="register.php">Inscription</a>
        <a href="login.php">Connexion</a>
    </nav>
    
    <div class="logo">
        <img src="images (3).png" alt="Logo Espion">
    </div>
    
    <footer>
        <p>Contact : contact@shadowcomm.fr | Tél: +33 07 23 45 67 89</p>
        <p>&copy; 2024 Ministère de la Sécurité. Tous droits réservés.</p>
    </footer>
</body>
</html>
