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
    <title>Document</title>
</head>
<body>
    <div class="main">
        <h1>Bonjour <span><?php echo htmlspecialchars($_SESSION['user_prenom'] . " " . $_SESSION['user_nom']); ?></span></h1>
        <p>Bienvenue sur ton espace Kayak Polo Verneuil.</p>

        <a href="logout.php" class="button">Deconnexion</a>
    </div>
</body>
</html>