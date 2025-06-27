<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
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
</body>
</html>

