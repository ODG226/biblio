
<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'bd_biblio';
$username = 'root'; 
$password = '';      

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
}
?>
