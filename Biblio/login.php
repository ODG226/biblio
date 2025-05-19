<?php
session_start();
require 'db.php'; // Assurez-vous que le chemin vers db.php est correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['mot_de_passe'];

    // Récupérer l'utilisateur depuis la base de données
    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // Créer une session pour l'utilisateur
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['user_name'] = $user['nom']; // Vous pouvez également enregistrer d'autres informations

        // Rediriger l'utilisateur vers la page d'accueil ou une autre page
        header("Location: index.php");
        exit();
    } else {
        header("Location: frontend/users/login.php");
        echo "Email ou mot de passe incorrect.";
    }
}
?>
