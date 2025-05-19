
<?php
// Gestion de la connexion administrateur
require '../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Rechercher l'utilisateur dans la base de données
    $sql = "SELECT * FROM utilisateurs WHERE email = :email AND role = 'admin'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($mot_de_passe, $admin['mot_de_passe'])) {
        // Authentification réussie
        $_SESSION['id_utilisateur'] = $admin['id_utilisateur'];
        $_SESSION['nom'] = $admin['nom'];
        $_SESSION['role'] = $admin['role'];
        header("Location: ../frontend/admin/admin_index.php");
        exit();
    } else {
        // Échec de la connexion
        echo "Email ou mot de passe incorrect.";
    }
}
?>
