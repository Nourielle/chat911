<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHADOWCOMM</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
            background-color: black;
            color: white;
            height: 100%;
            width:100%;
            
        }
        #background-video {
            position: fixed;
            top: 50%;
            left: 50%;
            width: auto;
            height: auto;
            min-width: 100%;
            min-height: 100%;
            transform: translate(-50%, -50%);
            z-index: 0; 
            object-fit: cover;
        }


        h1 {
            color:red;
            position: relative;
            z-index: 1;
        }
        

        header {
            padding: 15px;
            text-align: center;
            background: rgba(0, 0, 0, 0.8);
            position:relative;
        }
        nav {
            background: rgba(0, 0, 0, 0.6);
            padding: 10px;
            text-align: right;
            position: absolute;
            z-index: 2;
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

        .content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            font-size: 2em;
            top: 40%;
            font-family: Arial, sans-serif;
        }
            
    </style>
</head>
<body>
    <header>
        
        <h1>SHADOWCOMM</h1>
    </header>


    <?php $video = "video.mp4"; ?>
    <video autoplay loop muted playsinline id="background-video">
    <source src="<?php echo $video; ?>" type="video/mp4">
    </video>
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

