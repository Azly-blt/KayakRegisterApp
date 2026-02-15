<?php
session_start();
require_once 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. On récupère l'identifiant unique (qui peut être l'email OU le nom)
    // Dans ton HTML, l'input doit maintenant avoir name="identifiant"
    $identifiant = (trim($_POST['identifiant']));
    $mdp_saisi = $_POST['mdp']; 

    try {
        // 2. On cherche l'utilisateur soit par email, soit par nom
        // L'opérateur OR permet de vérifier les deux colonnes
        $sql = "SELECT id, nom, prenom, mot_de_passe, username
                FROM client 
                WHERE LOWER(email) = LOWER(:id) OR LOWER(username) = LOWER(:id) 
                LIMIT 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $identifiant]);
        $user = $stmt->fetch();

        // 3. Vérification du mot de passe
        if ($user && password_verify($mdp_saisi, $user['mot_de_passe'])) {
            
            // 4. Succès : Hydratation de la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];

            header("Location: accueil.php");
            exit();

        } else {
            // Échec : on redirige avec un code d'erreur
            header("Location: ../connexion.html?error=1");
            exit();
        }

    } catch (PDOException $e) {
        // En production, évite d'afficher $e->getMessage() pour ne pas dévoiler ta structure de base
        error_log($e->getMessage());
        die("Erreur technique. Veuillez réessayer plus tard.");
    }
}
?>