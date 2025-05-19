<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="../users/styles_register.css">
</head>
<body>
    <div class="container">
        <h2>Ajouter un utilisateur</h2>
        <form action="../../register.php" method="post">
            <div class="input-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="input-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <!-- Choix du rôle -->
            <div class="input-group">
                <label for="role">Rôle</label>
                <select id="role" name="role" required>
                    <option value="utilisateur">Utilisateur</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit">Ajouter</button> <br> <br>
            <button type="reset" style="color: red; background-color: white; border: 2px solid red;">Effacer</button>

        </form>
    </div>
</body>
</html>

