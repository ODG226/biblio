<?php
// Supprimer un utilisateur
require '../db.php';
session_start();

// Vérification du rôle (administrateur uniquement)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Accès refusé.";
    exit();
}

// Vérification si l'ID de l'utilisateur est présent dans l'URL
if (isset($_GET['id'])) {
    $id_utilisateur = $_GET['id'];

    // Requête pour supprimer l'utilisateur
    $sql = "DELETE FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_utilisateur', $id_utilisateur);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "<script>alert('Utilisateur supprimé avec succès!'); window.location.href='../frontend/admin/admin_users.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression de l\'utilisateur.'); window.location.href='admin_users.php';</script>";
    }
} else {
    echo "ID utilisateur manquant.";
}
?>
