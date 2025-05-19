

 <?php require "head.php";?>

    <?php
// Affichage du catalogue des livres
require_once '../../db.php';

$recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';

// Requête SQL avec recherche et filtrage
$sql = "SELECT * FROM livres WHERE 
        titre LIKE :recherche OR 
        auteur LIKE :recherche OR 
        genre LIKE :recherche 
        ORDER BY titre ASC";
$stmt = $conn->prepare($sql);
$search_param = '%' . $recherche . '%';
$stmt->bindParam(':recherche', $search_param);
$stmt->execute();
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($livres) {
    echo "<table class='catalogue'>";
    echo "<tr><th>Titre</th><th>Auteur</th><th>Genre</th><th>Année</th><th>Exemplaires</th><th>Résumé</th><th>Image</th></tr>";
    foreach ($livres as $livre) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($livre['titre']) . "</td>";
        echo "<td>" . htmlspecialchars($livre['auteur']) . "</td>";
        echo "<td>" . htmlspecialchars($livre['genre']) . "</td>";
        echo "<td>" . htmlspecialchars($livre['annee_publication']) . "</td>";
        echo "<td>" . htmlspecialchars($livre['nb_exemplaires']) . "</td>";
        echo "<td>" . htmlspecialchars($livre['resume']) . "</td>";
        
        // Affichage de l'image avec vérification si le chemin est valide
        if (!empty($livre['image'])) {
            echo "<td><img src='../../admin/" . htmlspecialchars($livre['image']) . "' alt='Image du livre' class='book-image'></td>";
        } else {
            echo "<td><img src='admin/default.png' alt='Image par défaut' class='book-image'></td>";
        }
        
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun livre trouvé.</p>";
}

?>

</body>
</html>

