<?php
session_start();
require_once 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifiant = trim($_POST['identifiant']);
    $mdp_saisi = $_POST['mdp']; 

    try {
        $sql = "SELECT id, nom, prenom, mot_de_passe, username, user_role
                FROM client 
                WHERE LOWER(email) = LOWER(:id) OR LOWER(username) = LOWER(:id) 
                LIMIT 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $identifiant]);
        $user = $stmt->fetch();

        // 1. On vérifie d'abord SI l'utilisateur existe ET SI le mot de passe est bon
        if ($user && password_verify($mdp_saisi, $user['mot_de_passe'])) {
            
            // 2. C'est un succès ! On remplit la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['user_role'] = $user['user_role']; // Le point-virgule est bien là !

            // 3. On redirige en fonction du rôle
            if ($_SESSION['user_role'] === 'admin') {
                header("Location: accueilAdmin.php");
                exit();
            } else {
                header("Location: accueil.php");
                exit();
            }

        } else {
            // Échec : mauvais identifiant ou mauvais mot de passe
            header("Location: ../connexion.html?error=1");
            exit();
        }

    } catch (PDOException $e) {
        error_log($e->getMessage());
        die("Erreur technique. Veuillez réessayer plus tard.");
    }
}
?>