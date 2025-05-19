<?php
// Connexion à la base de données
require '../db.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Hachage du mot de passe
    $role = $_POST['role']; // Récupération du rôle

    // Préparer la requête d'insertion
    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) VALUES (:nom, :prenom, :email, :mot_de_passe, :role)";
    $stmt = $conn->prepare($sql);

    // Associer les paramètres
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mot_de_passe', $mot_de_passe);
    $stmt->bindParam(':role', $role);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Inscription réussie !";
        // Rediriger vers la page de connexion ou autre
        header("Location: login.php");
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>
