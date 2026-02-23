<?php
session_start();
require_once 'connexion.php';

try {
    // 2. Préparation de la requête (Correction des majuscules pour PostgreSQL)
    $sql = 'SELECT "nomEvenement", "dateEvenement", "adresseEvenement" 
            FROM events
            ORDER BY "dateEvenement" ASC';
    
    $stmt = $pdo->prepare($sql);
    
    // 3. EXECUTION de la requête (La ligne qu'il te manquait !)
    $stmt->execute();
    
    // 4. Récupération des données
    $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Si la connexion ou la requête échoue
    die("Erreur de base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;700&family=Kanit:ital,wght@1,700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <title>Accueil - Club de Kayak Polo</title>
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <?php 
                // 1er cas : L'utilisateur est connecté ET c'est un ADMIN
                if (isset($_SESSION['user_nom']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') : 
                ?>
                    <a href="accueilAdmin.php">Accueil</a>
                    <a href="creeEvenement.php">Gestion club</a>
                    
                <?php 
                // 2ème cas : L'utilisateur est connecté mais c'est un CLIENT classique
                elseif (isset($_SESSION['user_nom'])) : 
                ?>
                    <a href="accueil.php">Accueil</a>
                    
                <?php 
                // 3ème cas : Personne n'est connecté (VISITEUR)
                else : 
                ?>
                    <a href="../index.html">Accueil</a>
                <?php endif; ?>
                
                
                <?php 
                // Gestion des boutons Connexion / Déconnexion / Inscription
                if (isset($_SESSION['user_nom'])) : 
                ?>
                    <a href="logout.php">Déconnexion</a>
                <?php else : ?>
                    <a href="../connexion.html">Connexion</a>
                    <a href="../inscription.html">Inscription</a>
                <?php endif; ?>
            </nav>
        </header>
    </div>

    <div class="main">
        <h1>Bienvenue sur la page du club de Verneuil-sur-Seine !</h1>

        <h2>Prochains événements :</h2>

        <?php
        // 5. AFFICHAGE HTML AU BON ENDROIT (dans le body)
        // On vérifie d'abord s'il y a des événements trouvés
        if (!empty($evenements)) {
            
            // La boucle foreach englobe TOUT l'affichage HTML
            foreach ($evenements as $event) {
                $nomEvent = htmlspecialchars($event['nomEvenement']);
                $dateEvent = htmlspecialchars($event['dateEvenement']);
                $addrEvent = htmlspecialchars($event['adresseEvenement']);
                
                // On affiche les bonnes variables ($nomEvent, pas $nom)
                echo "<div class='container-col'>";
                echo "<h3>$nomEvent</h3>";
                echo "<p>Date : $dateEvent</p>";
                echo "<p>Lieu : $addrEvent</p>";
                echo "</div>";
            }
        } else {
            // Message stylé si aucun match n'est prévu
            echo "<p>Aucun événement prévu dans les 11 prochains jours. Repos !</p>";
        }
        ?>

    </div>
</body>
</html>