
<?php
// Historique des emprunts
require '../db.php';
session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    echo "Veuillez vous connecter pour voir votre historique.";
    exit();
}

$id_utilisateur = $_SESSION['id_utilisateur'];

$sql = "SELECT h.id_historique, l.titre, l.auteur, h.date_emprunt, h.date_retour 
        FROM historique_emprunts h
        JOIN livres l ON h.id_livre = l.id_livre
        WHERE h.id_utilisateur = :id_utilisateur
        ORDER BY h.date_emprunt DESC";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_utilisateur', $id_utilisateur);
$stmt->execute();
$emprunts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($emprunts) {
    echo "<h2>Historique des Emprunts</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Titre</th><th>Auteur</th><th>Date d'emprunt</th><th>Date de retour</th></tr>";
    foreach ($emprunts as $emprunt) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($emprunt['titre']) . "</td>";
        echo "<td>" . htmlspecialchars($emprunt['auteur']) . "</td>";
        echo "<td>" . htmlspecialchars($emprunt['date_emprunt']) . "</td>";
        echo "<td>" . ($emprunt['date_retour'] ? htmlspecialchars($emprunt['date_retour']) : "En cours") . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucun emprunt trouvé.";
}
?>
