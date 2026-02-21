<?php
        session_start();

        if(!isset($_SESSION['user_nom'])){
            header("Location:connexion.html");
            exit();
        }

        try {
        // 3. Préparation de la requête SQL (on évite les injections SQL)
        $sql = "SELECT nomEvenement, dateEvenement, nomVilleEvenement, codePostalEvenement 
FROM events WHERE dateEvenement BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 11 DAY) ORDER BY dateEvenement ASC";
        $stmt = $pdo->prepare($sql);
        
        // 4. Exécution avec les vraies valeurs
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mdp' => $mdp_hache,
            ':username' => $username
        ]);

        $_SESSION['user_nom'] = $nom;
        $_SESSION['user_prenom'] = $prenom;
        $_SESSION['username'] = $username;
        header("Location:accueil.php");
        exit();

    } catch (PDOException $e) {
        // Gestion de l'erreur si l'email existe déjà (contrainte UNIQUE)
        if ($e->getCode() == 23506) { 
            header("Location: ../infoClub.php?error=8");
            exit();
        }
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
        <h1>Bienvenue sur la page du club de Verneuil sur seine !</h1>

        <h2>Prochains évenements :</h2>


    </div>
</body>
</html>