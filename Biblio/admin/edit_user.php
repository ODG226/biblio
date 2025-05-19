
<?php
// Modifier un utilisateur
require '../../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    echo "Accès refusé.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_utilisateur = $_POST['id_utilisateur'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE utilisateurs SET nom = :nom, prenom = :prenom, email = :email, role = :role WHERE id_utilisateur = :id_utilisateur";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id_utilisateur', $id_utilisateur);

    if ($stmt->execute()) {
        echo "Utilisateur modifié avec succès!";
        header("Location: admin_users.php");
    } else {
        echo "Erreur lors de la modification de l'utilisateur.";
    }
} else {
    // Récupérer les informations actuelles de l'utilisateur
    $id_utilisateur = $_GET['id'];
    $sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_utilisateur', $id_utilisateur);
    $stmt->execute();
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Afficher le formulaire avec les informations actuelles
    echo "<form method='post'>";
    echo "<input type='hidden' name='id_utilisateur' value='" . htmlspecialchars($utilisateur['id_utilisateur']) . "'>";
    echo "Nom: <input type='text' name='nom' value='" . htmlspecialchars($utilisateur['nom']) . "'><br>";
    echo "Prénom: <input type='text' name='prenom' value='" . htmlspecialchars($utilisateur['prenom']) . "'><br>";
    echo "Email: <input type='email' name='email' value='" . htmlspecialchars($utilisateur['email']) . "'><br>";
    echo "Rôle: <select name='role'>
            <option value='utilisateur' " . ($utilisateur['role'] == 'utilisateur' ? 'selected' : '') . ">Utilisateur</option>
            <option value='admin' " . ($utilisateur['role'] == 'admin' ? 'selected' : '') . ">Administrateur</option>
           </select><br>";
    echo "<input type='submit' value='Modifier'>";
    echo "</form>";
}
?>
