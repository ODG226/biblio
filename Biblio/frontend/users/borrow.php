<?php
session_start();

require '../../db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {

     header("Location: ../../index.php");
    exit();
}
var_dump($_SESSION);
if (isset($_GET['id'])) {
    $id_livre = $_GET['id'];

    // Récupérer l'ID de l'utilisateur connecté à partir de la session
    $id_utilisateur = $_SESSION['user_id']; 

    // Vérifier la disponibilité du livre
    $sql = "SELECT nb_exemplaires FROM livres WHERE id_livre = :id_livre";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_livre', $id_livre);
    $stmt->execute();
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($livre && $livre['nb_exemplaires'] > 0) {
        // Réduire le nombre d'exemplaires
        $sql = "UPDATE livres SET nb_exemplaires = nb_exemplaires - 1 WHERE id_livre = :id_livre";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_livre', $id_livre);
        $stmt->execute();

        // Calculer la date de retour (7 jours après la date d'emprunt)
        $date_emprunt = date('Y-m-d H:i:s');
        $date_retour = date('Y-m-d H:i:s', strtotime($date_emprunt . ' + 7 days'));

        // Enregistrer dans l'historique des emprunts
        $sql = "INSERT INTO historique_emprunts (id_utilisateur, id_livre, date_emprunt, date_retour) 
                VALUES (:id_utilisateur, :id_livre, :date_emprunt, :date_retour)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->bindParam(':id_livre', $id_livre);
        $stmt->bindParam(':date_emprunt', $date_emprunt);
        $stmt->bindParam(':date_retour', $date_retour);
        $stmt->execute();

        //table emprunt

        $sql = "INSERT INTO emprunts (id_emprunt, id_utilisateur, id_livre, date_emprunt, date_retour) 
            VALUES (id_emprunt, :id_utilisateur, :id_livre, :date_emprunt, :date_retour)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->bindParam(':id_livre', $id_livre);
        $stmt->bindParam(':date_emprunt', $date_emprunt);
        $stmt->bindParam(':date_retour', $date_retour);
        // $stmt->bindParam(':date_retour_prevu', $date_retour_prevu);
        $stmt->execute();

        header("Location: ../../index.php?status=success");
    } else {
        header("Location: ../../index.php?status=unavailable");
    }
} else {
    header("Location: ../../index.php?status=missingid");
}
?>
