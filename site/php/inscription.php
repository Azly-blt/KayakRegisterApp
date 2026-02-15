<?php
session_start();
require_once 'connexion.php'; // On inclut ton fichier de connexion PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. On récupère les données du formulaire
    $username = $_POST['pseudo'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = strtolower(trim($_POST['email'])); // On met l'email en minuscules
    $mdp_clair = $_POST['password'];
    

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../inscription.html?error=3");
    exit();
    }
    
    $domaine = substr(strrchr($email, "@"), 1);

    if (!checkdnsrr($domaine, "MX")) {
        // On renvoie une erreur 4 (Domaine inconnu ou faux)
        header("Location: ../inscription.html?error=4");
        exit();
    }

    // 2. ON HACHE LE MOT DE PASSE (Algorithme BCRYPT par défaut)
    $mdp_hache = password_hash($mdp_clair, PASSWORD_DEFAULT);

    try {
        // 3. Préparation de la requête SQL (on évite les injections SQL)
        $sql = "INSERT INTO client (nom, prenom, email, mot_de_passe, username) VALUES (:nom, :prenom, :email, :mdp, :username)";
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
        if ($e->getCode() == 23505) { 
            header("Location: ../inscription.html?error=2");
            exit();
        } else {
            echo "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}
?>