<?php
        session_start();

        if(!isset($_SESSION['user_nom'])){
            header("Location:connexion.html");
            exit();
        }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>Accueil</title>
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <a href="accueil.php">Accueil</a>
                <a href="infoClub.php">Le club</a>
                <a href="logout.php">Deconnexion</a>
            </nav>
        </header>
    </div>
    <div class="main">
        <h1>Bonjour <span><?php echo htmlspecialchars($_SESSION['user_prenom'] . " " . $_SESSION['user_nom']); ?></span></h1>
        <p>Bienvenue sur la page du club.</p>

    </div>
</body>
</html>