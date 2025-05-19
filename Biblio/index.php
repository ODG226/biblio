
<?php
session_start(); // Démarrer la session pour accéder aux variables de session

// Vérifier si un statut est passé en paramètre dans l'URL
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    echo "<script type='text/javascript'>
        window.onload = function() {
            switch ('$status') {
                case 'success':
                    alert('Emprunt réussi!');
                    break;
                case 'error':
                    alert('Erreur lors de l\'emprunt du livre.');
                    break;
                case 'unavailable':
                    alert('Aucun exemplaire disponible.');
                    break;
                case 'notfound':
                    alert('Livre non trouvé.');
                    break;
                case 'missingid':
                    alert('ID de livre manquant.');
                    break;
            }
        }
    </script>";
}
?>

<?php
//session_start();
//var_dump($_SESSION); // Afficher les variables de session pour débogage
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque en Ligne</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="frontend/users/styles_catalog.css">
</head>
<body>

    <h1>Bienvenue à la Bibliothèque en Ligne</h1>
    <p>Explorez notre collection de livres, empruntez et gérez vos emprunts en toute simplicité.</p>

    <nav>
        <ul>
            <li><a href="#hero">Accueil</a></li>
            <li><a href="frontend/users/register.php">S'inscrire</a></li>
            <!-- <li><a href="frontend/users/login.php">Se connecter</a></li> -->
            <li><a href="frontend/users/catalog.php">Consulter le Catalogue</a></li>
            <li><a href="frontend/admin/admin_login.php" target="_blank">Administration</a></li>
            <!-- <li><a href="frontend/users/return.php">Reourner un livre</a></li> -->

            <!-- Vérifier si l'utilisateur est connecté -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
            <?php endif; ?>
        </ul>
    </nav>


<!-- Optionnel : Mettre en avant certains livres -->
<h2>Livres Populaires</h2>

<?php
// Charger les livres populaires
require 'db.php';

// Sélectionner 24 livres au hasard
$sql = "SELECT * FROM livres ORDER BY RAND() LIMIT 24";
$stmt = $conn->prepare($sql);
$stmt->execute();
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($livres) {
    echo "<ul class='popular-books'>";
    foreach ($livres as $livre) {
        $livre_id = htmlspecialchars($livre['id_livre']); // Assurez-vous que 'id_livre' est correct
        $nb_exemplaires = htmlspecialchars($livre['nb_exemplaires']);
        $image_src = "admin/" . htmlspecialchars($livre['image']); // Utiliser directement le chemin enregistré
        
        // Vérifier si le fichier d'image existe
        if (!file_exists($image_src) || empty($livre['image'])) {
            $image_src = 'admin/upload/41vUkspKeML.jpg'; // Image par défaut si l'image n'existe pas
        }
        
        echo "<li>";
        echo "<img src='$image_src' alt='" . htmlspecialchars($livre['titre']) . "'>";
        echo "<h3>" . htmlspecialchars($livre['titre']) . "</h3>";
        echo "<p>par " . htmlspecialchars($livre['auteur']) . "</p>";

        // Vérifier si l'utilisateur est connecté avant d'afficher le bouton "Emprunter"
        if (isset($_SESSION['user_id']) && $nb_exemplaires > 0) {
            echo "<a href='frontend/users/borrow.php?id=$livre_id'><button>Emprunter</button></a>";
        } else {
            // Afficher un message ou un bouton désactivé si l'utilisateur n'est pas connecté ou le livre est indisponible
            if (!isset($_SESSION['user_id'])) {
                echo " <a href=\"frontend/users/login.php\">  <button>Veuillez vous connecter</button> </a> ";
            } else {
                echo "<button disabled>Indisponible</button>";
            }
        }
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Aucun livre trouvé.";
}
?>

</body>
</html>
