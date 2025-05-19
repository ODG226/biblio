<?php
// Modifier un livre
require '../../db.php';
session_start();


if (isset($_GET['id'])) {
    $id_livre = $_GET['id'];

    // Récupérer les informations actuelles du livre
    $sql = "SELECT * FROM livres WHERE id_livre = :id_livre";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_livre', $id_livre);
    $stmt->execute();
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$livre) {
        echo "Livre non trouvé.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_livre = $_POST['id_livre'];
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $genre = $_POST['genre'];
    $annee_publication = $_POST['annee_publication'];
    $resume = $_POST['resume'];
    $nb_exemplaires = $_POST['nb_exemplaires'];

    $sql = "UPDATE livres SET titre = :titre, auteur = :auteur, genre = :genre, 
            annee_publication = :annee_publication, resume = :resume, 
            nb_exemplaires = :nb_exemplaires WHERE id_livre = :id_livre";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':auteur', $auteur);
    $stmt->bindParam(':genre', $genre);
    $stmt->bindParam(':annee_publication', $annee_publication);
    $stmt->bindParam(':resume', $resume);
    $stmt->bindParam(':nb_exemplaires', $nb_exemplaires);
    $stmt->bindParam(':id_livre', $id_livre);

    if ($stmt->execute()) {
        echo "Livre modifié avec succès!";
    } else {
        echo "Erreur lors de la modification du livre.";
    }
}
?>

    <?php require 'head.php';?>


    <div class="container">
        <h2>Modifier le livre</h2>
        <form action="edit_book.php?id=<?php echo $livre['id_livre']; ?>" method="post">
            <input type="hidden" name="id_livre" value="<?php echo htmlspecialchars($livre['id_livre']); ?>">

            <div class="input-group">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($livre['titre']); ?>" required>
            </div>

            <div class="input-group">
                <label for="auteur">Auteur</label>
                <input type="text" id="auteur" name="auteur" value="<?php echo htmlspecialchars($livre['auteur']); ?>" required>
            </div>

            <div class="input-group">
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($livre['genre']); ?>" required>
            </div>

            <div class="input-group">
                <label for="annee_publication">Année de publication</label>
                <input type="text" id="annee_publication" name="annee_publication" value="<?php echo htmlspecialchars($livre['annee_publication']); ?>" required>
            </div>

            <div class="input-group">
                <label for="resume">Résumé</label>
                <textarea id="resume" name="resume" required><?php echo htmlspecialchars($livre['resume']); ?></textarea>
            </div>

            <div class="input-group">
                <label for="nb_exemplaires">Nombre d'exemplaires</label>
                <input type="number" id="nb_exemplaires" name="nb_exemplaires" value="<?php echo htmlspecialchars($livre['nb_exemplaires']); ?>" required>
            </div>

            <button type="submit">Modifier le livre</button>
        </form>
    </div>
</body>
</html>
