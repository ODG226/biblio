

<?php     
    require '../../db.php';
    session_start();
?>

 <?php require 'head.php';?>

    <script>
        function confirmerSuppression(id_livre) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce livre ?")) {
                document.getElementById('deleteForm').id_livre.value = id_livre;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
  
    <div class="container">
        <h2>Liste des livres</h2>
        <ul class="book-list">
            <!-- Exemple : Liste des livres à supprimer -->
            <?php

                $sql = "SELECT * FROM livres ORDER BY titre ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($livres) {
                    foreach ($livres as $livre) {
                        echo "<li class='book-item'>" . htmlspecialchars($livre['titre']) . 
                             " <button onclick='confirmerSuppression(" . $livre['id_livre'] . ")'>Supprimer</button></li>";
                    }
                } else {
                    echo "<p>Aucun livre trouvé.</p>";
                }
            ?>
        </ul>

        <!-- Formulaire caché pour envoyer la suppression -->
        <form id="deleteForm" action="../../admin/delete_book.php" method="post" style="display: none;">
            <input type="hidden" name="id_livre" value="">
        </form>
    </div>
</body>
</html>
