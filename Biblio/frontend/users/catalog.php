
<?php
session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque en Ligne</title>
    <link rel="stylesheet" href="../../styles.css">
    <link rel="stylesheet" href="styles_catalog.css">
</head>
<body>

    <h1>Bienvenue à la Bibliothèque en Ligne</h1>
    <p>Explorez notre collection de livres, empruntez et gérez vos emprunts en toute simplicité.</p>

    <nav>
        <ul>
            <li><a href="../../index.php">Accueil</a></li>
            <li><a href="register.php">S'inscrire</a></li>
            <!-- <li><a href="login.php">Se connecter</a></li> -->
            <li><a href="catalog.php">Consulter le Catalogue</a></li>
            <li><a href="../admin/admin_login.php" target="_blank">Administration</a></li>

            <!-- Vérifier si l'utilisateur est connecté -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="../../profile.php">Profil</a></li>
                <li><a href="../../logout.php">Se déconnecter</a></li>
            <?php endif; ?>
        </ul>
    </nav>

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
        // Transformer le titre en lien cliquable
        echo "<td><a href='borrow.php?id=" . htmlspecialchars($livre['id_livre']) . "' style=''>" . htmlspecialchars($livre['titre']) . "</a></td>";
        echo "<td>" . htmlspecialchars($livre['auteur']) . "</td>";
        echo "<td>" . htmlspecialchars($livre['genre']) . "</td>";
        echo "<td>" . htmlspecialchars($livre['annee_publication']) . "</td>";
        echo "<td>" . htmlspecialchars($livre['nb_exemplaires']) . "</td>";
        echo "<td>" . htmlspecialchars($livre['resume']) . "</td>";
        
        // Affichage de l'image avec vérification si le chemin est valide
        if (!empty($livre['image'])) {
            echo "<td><img src='../../admin/" . htmlspecialchars($livre['image']) . "' alt='Image du livre' class='book-image'></td>";
        } else {
            echo "<td><img src='../../upload/default.png' alt='Image par défaut' class='book-image'></td>";
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
