
<?php
$host = 'localhost';
$dbname = 'cours_dlm';
$username = 'dodo';
$password = '83210';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username, 
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : ".$e->getMessage());
}
?>    
