<?php
session_start();
require_once 'connexion.php'; // On inclut ton fichier de connexion PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. On récupère les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = strtolower(trim($_POST['email'])); // On met l'email en minuscules
    $mdp_clair = $_POST['password'];

    // 2. ON HACHE LE MOT DE PASSE (Algorithme BCRYPT par défaut)
    $mdp_hache = password_hash($mdp_clair, PASSWORD_DEFAULT);

    try {
        // 3. Préparation de la requête SQL (on évite les injections SQL)
        $sql = "INSERT INTO client (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mdp)";
        $stmt = $pdo->prepare($sql);
        
        // 4. Exécution avec les vraies valeurs
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mdp' => $mdp_hache
        ]);

        $_SESSION['user_nom'] = $nom;
        $_SESSION['user_prenom'] = $prenom;
        header("Location:accueil.php");
        exit();

    } catch (PDOException $e) {
        // Gestion de l'erreur si l'email existe déjà (contrainte UNIQUE)
        if ($e->getCode() == 23505) { 
            echo "Erreur : Cet email est déjà utilisé.";
        } else {
            echo "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}
?>