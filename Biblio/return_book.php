
<?php
// Retourner un livre
session_start();
require 'db.php';


if (!isset($_SESSION['user_id'])) {
    echo "Veuillez vous connecter pour retourner un livre.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_emprunt = $_POST['id_emprunt'];

    // Récupérer les informations de l'emprunt
    $sql = "SELECT id_livre FROM emprunts WHERE id_emprunt = :id_emprunt";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_emprunt', $id_emprunt);
    $stmt->execute();
    $emprunt = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($emprunt) {
        $id_livre = $emprunt['id_livre'];

        // Marquer le livre comme retourné
        $sql = "UPDATE emprunts SET date_retour = NOW() WHERE id_emprunt = :id_emprunt";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_emprunt', $id_emprunt);

        if ($stmt->execute()) {
            // Mettre à jour le nombre d'exemplaires disponibles
            $sql = "UPDATE livres SET nb_exemplaires = nb_exemplaires + 1 WHERE id_livre = :id_livre";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_livre', $id_livre);
            $stmt->execute();

            echo "Livre retourné avec succès!";
        } else {
            echo "Erreur lors du retour du livre.";
        }
    } else {
        echo "Emprunt introuvable.";
    }
}
?>
