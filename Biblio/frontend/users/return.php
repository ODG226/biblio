<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retourner un Livre</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Retourner un Livre</h1>
        <p>Veuillez entrer l'identifiant de l'emprunt pour retourner le livre.</p>
        
        <!-- Formulaire de retour de livre -->
        <form action="return_book.php" method="POST">
            <label for="id_emprunt">ID de l'emprunt :</label>
            <input type="text" id="id_emprunt" name="id_emprunt" required>
            
            <button type="submit">Retourner le livre</button>
        </form>
        
        <!-- Message de succès ou d'erreur -->
        <div class="message">
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>
        </div>
    </div>
</body>
</html>

