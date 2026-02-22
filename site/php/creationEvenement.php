<?php
session_start();
require_once 'connexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nomEvent = $_POST['nomEvenement'];
    $dateEvent = $_POST['dateEvenement'];
    $addrEvent = $_POST['adresseEvenement'];

    try {
        // 1. On remet les guillemets doubles pour PostgreSQL sur les noms de colonnes
        // 2. On garde les "trous" courts :nomEvent, :dateEvent, :addrEvent
        $sql = 'INSERT INTO events ("nomEvenement", "dateEvenement", "adresseEvenement") 
                VALUES (:nomEvent, :dateEvent, :addrEvent)';
        
        $stmt = $pdo->prepare($sql);
        
        // 3. CORRECTION ICI : Les clés du tableau correspondent EXACTEMENT aux trous du VALUES
        $stmt->execute([
            ':nomEvent' => $nomEvent,
            ':dateEvent' => $dateEvent,
            ':addrEvent' => $addrEvent
        ]);

        header("Location: accueilAdmin.php");
        exit();

    } catch (PDOException $e) {
        if ($e->getCode() == 23509) { 
            header("Location: ../creeEvenement?error=9");
            exit();
        } else {
            echo "Erreur lors de la creation de l'evenement : " . $e->getMessage();
        }
    }
}
?>