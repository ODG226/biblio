
<?php
// Voir la liste des utilisateurs
require '../../db.php';
session_start();


$sql = "SELECT id_utilisateur, nom, prenom, email, role, date_inscription FROM utilisateurs ORDER BY date_inscription DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($utilisateurs) {
    echo "<h2>Liste des Utilisateurs</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Rôle</th><th>Date d'inscription</th><th>Actions</th></tr>";
    foreach ($utilisateurs as $utilisateur) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($utilisateur['id_utilisateur']) . "</td>";
        echo "<td>" . htmlspecialchars($utilisateur['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($utilisateur['prenom']) . "</td>";
        echo "<td>" . htmlspecialchars($utilisateur['email']) . "</td>";
        echo "<td>" . htmlspecialchars($utilisateur['role']) . "</td>";
        echo "<td>" . htmlspecialchars($utilisateur['date_inscription']) . "</td>";
        echo "<td>";
        echo "<a href='edit_user_form.php?id=" . $utilisateur['id_utilisateur'] . "'>Modifier</a> | ";
        echo "<a href='../../admin/delete_user.php?id=" . $utilisateur['id_utilisateur'] . "' onclick='return confirm(\"Êtes-vous sûr?\");'>Supprimer</a> |";
        echo "<a href='register.php?id=" . $utilisateur['id_utilisateur'] . "'>Ajouter</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucun utilisateur trouvé.";
}
?>
