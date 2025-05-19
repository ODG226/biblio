

<?php     
    require '../../db.php';
    session_start();
?>

 <?php require 'head.php'; ?>

  
    <h2>Modifier un Livre</h2>
    <?php

    $sql = "SELECT * FROM livres ORDER BY titre ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($livres) {
        echo "<ul class='book-list'>";
        foreach ($livres as $livre) {
            echo "<li class='book-item'><a href='edit_book.php?id=" . $livre['id_livre'] . "'>" . htmlspecialchars($livre['titre']) . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun livre trouvé.</p>";
    }
?>


</body>
</html>

