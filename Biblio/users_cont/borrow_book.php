
<?php
// Emprunter un livre
require '../db.php';
session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    echo "Veuillez vous connecter pour emprunter un livre.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_livre = $_POST['id_livre'];
    $id_utilisateur = $_SESSION['id_utilisateur'];

    // Vérifier si le livre est disponible
    $sql = "SELECT nb_exemplaires FROM livres WHERE id_livre = :id_livre";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_livre', $id_livre);
    $stmt->execute();
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($livre['nb_exemplaires'] > 0) {
        // Emprunter le livre
        $date_retour_prevu = date('Y-m-d H:i:s', strtotime('+2 weeks'));
        $sql = "INSERT INTO emprunts (id_utilisateur, id_livre, date_retour_prevu) 
                VALUES (:id_utilisateur, :id_livre, :date_retour_prevu)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->bindParam(':id_livre', $id_livre);
        $stmt->bindParam(':date_retour_prevu', $date_retour_prevu);

        if ($stmt->execute()) {
            // Mettre à jour le nombre d'exemplaires disponibles
            $sql = "UPDATE livres SET nb_exemplaires = nb_exemplaires - 1 WHERE id_livre = :id_livre";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_livre', $id_livre);
            $stmt->execute();

            echo "Livre emprunté avec succès! Retour prévu le " . $date_retour_prevu;
        } else {
            echo "Erreur lors de l'emprunt du livre.";
        }
    } else {
        echo "Ce livre n'est pas disponible.";
    }
}
?>
