



<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les informations de l'utilisateur depuis la base de données
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_utilisateur', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Mettre à jour les informations personnelles
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    
    if (!empty($_POST['mot_de_passe'])) {
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    } else {
        $mot_de_passe = $user['mot_de_passe'];
    }

    $role = $_POST['role'];

    $update_sql = "UPDATE utilisateurs 
                   SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, role = :role
                   WHERE id_utilisateur = :id_utilisateur";
    
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bindParam(':nom', $nom);
    $update_stmt->bindParam(':prenom', $prenom);
    $update_stmt->bindParam(':email', $email);
    $update_stmt->bindParam(':mot_de_passe', $mot_de_passe);
    $update_stmt->bindParam(':role', $role);
    $update_stmt->bindParam(':id_utilisateur', $user_id);
    
    if ($update_stmt->execute()) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}

// Récupérer les emprunts de l'utilisateur avec l'image du livre
$emprunts_sql = "SELECT livres.titre, livres.image, historique_emprunts.id_historique, historique_emprunts.date_emprunt, historique_emprunts.date_retour
                 FROM historique_emprunts 
                 JOIN livres ON historique_emprunts.id_livre = livres.id_livre 
                 WHERE historique_emprunts.id_utilisateur = :id_utilisateur";
$emprunts_stmt = $conn->prepare($emprunts_sql);
$emprunts_stmt->bindParam(':id_utilisateur', $user_id);
$emprunts_stmt->execute();
$emprunts = $emprunts_stmt->fetchAll(PDO::FETCH_ASSOC);


// Retourner un livre
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['return_book'])) {
    $id_historique = $_POST['id_historique'];
    
    $update_return_sql = "UPDATE historique_emprunts SET date_retour = CURDATE() WHERE id_historique = :id_historique";
    $return_stmt = $conn->prepare($update_return_sql);
    $return_stmt->bindParam(':id_historique', $id_historique);
    
    if ($return_stmt->execute()) {
        echo "Livre retourné avec succès!";
    } else {
        echo "Erreur lors du retour du livre.";
    }
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque en Ligne</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        nav {
            background-color: #333;
            padding: 10px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #f4f4f4;
        }

        .button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #218838;
        }

        .update-profile {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .update-profile form input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .update-profile button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .update-profile button:hover {
            background-color: #0056b3;
        }

        .book-image {
            width: 50px;
            height: 75px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Bienvenue à la Bibliothèque en Ligne</h1>
    <p>Explorez notre collection de livres, empruntez et gérez vos emprunts en toute simplicité.</p>

    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="frontend/users/register.php">S'inscrire</a></li>
            <li><a href="frontend/users/catalog.php">Consulter le Catalogue</a></li>
            <li><a href="frontend/admin/admin_login.php" target="_blank">Administration</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <h1>Profil de <?php echo htmlspecialchars($user['nom']); ?></h1>

    <!-- Formulaire de mise à jour des informations personnelles -->
    <div class="update-profile">
        <form method="POST" action="profile.php">
            <label>Nom:</label>
            <input type="text" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>

            <label>Prénom:</label>
            <input type="text" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label>Mot de passe:</label>
            <input type="password" name="mot_de_passe">

            <label>Rôle:</label>
            <input type="text" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" required>

            <button type="submit" name="update_profile">Mettre à jour</button>
        </form>
    </div>

    <!-- Afficher les emprunts de l'utilisateur -->
    <h2>Mes emprunts</h2>
    <?php if ($emprunts): ?>
        <table>
            <tr>
                <th>Image</th>
                <th>Livre</th>
                <th>Date d'emprunt</th>
                <th>Date de retour</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($emprunts as $emprunt): ?> 
                <!-- <?php var_dump($emprunt);?> -->
                 <?php $date=htmlspecialchars($emprunt['date_retour'] );?>
                <tr>
                    <!-- Afficher l'image du livre -->
                    <td>
                        <img src="admin/<?php echo htmlspecialchars($emprunt['image']); ?>" alt="Image du livre" class="book-image">
                    </td>
                    <td><?php echo htmlspecialchars($emprunt['titre']); ?></td>
                    <td><?php echo htmlspecialchars($emprunt['date_emprunt']); ?></td>
                    <td><?php echo isset ($date)?$date: 'Pas encore retourné'; ?></td>
                    <td>
                        <?php if (!$emprunt['date_retour']): ?>
                            <form method="POST" action="profile.php">
                                <input type="hidden" name="id_historique" value="<?php echo htmlspecialchars($emprunt['id_historique']); ?>">
                                <button class="button" type="submit" name="return_book">Retourner</button>
                            </form>
                        <?php else: ?>
                            Déjà retourné
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Vous n'avez pas encore emprunté de livres.</p>
    <?php endif; ?>
</body>
</html>
