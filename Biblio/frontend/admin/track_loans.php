<?php
require '../../db.php'; // Assurez-vous que le chemin est correct

// Récupération des emprunts avec les détails des utilisateurs et des livres
$sql = "SELECT historique_emprunts.id_historique, utilisateurs.nom, livres.titre, historique_emprunts.date_emprunt, historique_emprunts.date_retour
        FROM historique_emprunts
        JOIN utilisateurs ON historique_emprunts.id_utilisateur = utilisateurs.id_utilisateur
        JOIN livres ON historique_emprunts.id_livre = livres.id_livre
        ORDER BY historique_emprunts.date_emprunt DESC"; // Ajout du tri pour afficher les emprunts récents en premier

$stmt = $conn->prepare($sql);
$stmt->execute();
$emprunts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Emprunts</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
 
    <table border="1">
        <thead>
            <tr>
                <th>ID Emprunt</th>
                <th>Nom Utilisateur</th>
                <th>Titre Livre</th>
                <th>Date Emprunt</th>
                <th>Date Retour</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($emprunts)): ?>
                <?php foreach ($emprunts as $emprunt): ?> 
                    <!-- <?php var_dump($emprunt) ?> -->
                    <tr>
                        <td><?php echo htmlspecialchars($emprunt['id_historique']); ?></td>
                        <td><?php echo htmlspecialchars($emprunt['nom']); ?></td>
                        <td><?php echo htmlspecialchars($emprunt['titre']); ?></td>
                        <td><?php echo htmlspecialchars($emprunt['date_emprunt']); ?></td>
                        <td><?php echo htmlspecialchars($emprunt['date_retour'] ?: 'Non retourné'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun emprunt trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
