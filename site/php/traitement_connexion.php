<?php
session_start();
require_once 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. On récupère les identifiants du formulaire
    $email = strtolower(trim($_POST['email']));
    $mdp_saisi = $_POST['mdp']; // Assure-toi que l'input du login s'appelle name="mdp"

    try {
        // 2. On cherche l'utilisateur dans Supabase
        $sql = "SELECT id, nom, prenom, mot_de_passe FROM client WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        // 3. On vérifie si l'utilisateur existe ET si le mot de passe est correct
        if ($user && password_verify($mdp_saisi, $user['mot_de_passe'])) {
            
            // 4. Succès : On remplit la session avec les infos de la BD
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];

            // Redirection vers l'accueil
            header("Location:accueil.php");
            exit();

        } else {
            // Échec : Identifiants incorrects
            header("Location:../connexion.html?error=1");
            exit();
        }

    } catch (PDOException $e) {
        die("Erreur technique : " . $e->getMessage());
    }
}
?>