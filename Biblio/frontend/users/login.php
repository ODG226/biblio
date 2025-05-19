<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles_login.css">
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form method="post" action="../../login.php">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
    
            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
    
            <button type="submit">Se connecter</button>
        </form>

    </div>
</body>
</html>
