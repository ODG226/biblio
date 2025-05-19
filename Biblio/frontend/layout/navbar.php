
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
    <link rel="stylesheet" href="../users/styles_catalog.css">
    <link rel="stylesheet" href="../../styles.css">
</head>

<body>

<h1>Bienvenue à la Bibliothèque en Ligne</h1>
    <p>Explorez notre collection de livres, empruntez et gérez vos emprunts en toute simplicité.</p>

    <nav>
    <ul>
        <li><a href="../../index.php">Accueil</a></li>
        <li><a href="../users/register.php">S'inscrire</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="../../logout.php">Se déconnecter</a></li>
        <?php else: ?>
            <li><a href="../users/login.php">Se connecter</a></li>
        <?php endif; ?>
        <li><a href="#hero">Consulter le Catalogue</a></li>
        <li><a href="../admin/admin_login.php">Administration</a></li>
    </ul>
</nav>