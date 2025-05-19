<?php
// Ajouter un livre
require '../db.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $genre = $_POST['genre'];
    $annee_publication = $_POST['annee_publication'];
    $resume = $_POST['resume'];
    $nb_exemplaires = $_POST['nb_exemplaires'];
    
    // Gestion de l'image
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmp = $image['tmp_name'];
    $image_path = 'upload/' . $image_name; // Dossier où l'image sera sauvegardée

    // Vérifier si le fichier a été téléchargé avec succès
    if (move_uploaded_file($image_tmp, $image_path)) {
        // Préparer la requête SQL avec l'image
        $sql = "INSERT INTO livres (titre, auteur, genre, annee_publication, resume, nb_exemplaires, image) 
                VALUES (:titre, :auteur, :genre, :annee_publication, :resume, :nb_exemplaires, :image)";
        
        $stmt = $conn->prepare($sql);

        // Lier les paramètres
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':annee_publication', $annee_publication);
        $stmt->bindParam(':resume', $resume);
        $stmt->bindParam(':nb_exemplaires', $nb_exemplaires);
        $stmt->bindParam(':image', $image_path); // Lier le chemin de l'image

        // Exécuter la requête et vérifier le succès
        if ($stmt->execute()) {
            echo "Livre ajouté avec succès!";
            header("Location: ../frontend/admin/add_book.php");
            exit();
        } else {
            echo "Erreur lors de l'ajout du livre.";
        }
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
}
?>
