
<?php
// Supprimer un livre
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    echo "Accès refusé.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_livre = $_POST['id_livre'];

    $sql = "DELETE FROM livres WHERE id_livre = :id_livre";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_livre', $id_livre);

    if ($stmt->execute()) {
        echo "Livre supprimé avec succès!";
        header("location: ../frontend/admin/delete_book_list.php");
    } else {
        echo "Erreur lors de la suppression du livre.";
    }
}
?>
