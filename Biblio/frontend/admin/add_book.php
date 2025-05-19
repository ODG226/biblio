<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Livre</title>
    <link rel="stylesheet" href="styles_add_book.css">
</head>
<body>
    <div class="form-container">
        <h2>Ajouter un Livre</h2>
        <form action="../../admin/add_book.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titre">Titre du livre :</label>
                <input type="text" name="titre" id="titre" required>
            </div>

            <div class="form-group">
                <label for="auteur">Auteur :</label>
                <input type="text" name="auteur" id="auteur" required>
            </div>

            <div class="form-group">
                <label for="genre">Genre :</label>
                <input type="text" name="genre" id="genre" required>
            </div>

            <div class="form-group">
                <label for="annee_publication">Année de publication :</label>
                <input type="number" name="annee_publication" id="annee_publication" required>
            </div>

            <div class="form-group">
                <label for="resume">Résumé :</label>
                <textarea name="resume" id="resume" required></textarea>
            </div>

            <div class="form-group">
                <label for="nb_exemplaires">Nombre d'exemplaires :</label>
                <input type="number" name="nb_exemplaires" id="nb_exemplaires" required>
            </div>
            
            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" name="image" id="imageInput" accept="image/*" required>
                <img id="previewImage" src="#" alt="Aperçu de l'image" style="max-width: 100%; max-height: 300px; display: none;">
            </div>

            <button type="submit">Ajouter le livre</button>
        </form>
    </div>

</body>

<script>
    // Fonction pour afficher l'aperçu de l'image
    function previewImage(input) {
        var preview = document.getElementById('previewImage');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }

    // Appeler la fonction d'aperçu lorsque le champ d'entrée de l'image change
    document.getElementById('imageInput').addEventListener('change', function() {
        previewImage(this);
    });
</script>

</html>
