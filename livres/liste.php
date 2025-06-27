<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des livres</title>
</head>
<body>
    <h1>Liste des livres</h1>
    <a href="ajouter.php" id="add-book">Ajouter un livre</a>
    <div id="books-container">
<?php
require_once(__DIR__ . '/../config/db.php'); // Récupération $pdo // DIR : Constante magique qui contient le chemin complet du dossier du fichier PHP en cours

$stmt = $pdo->prepare("SELECT livres.id_livre, livres.titre, livres.annee_publication, auteurs.nom_auteur, auteurs.prenom_auteur, genres.nom_genre FROM livres LEFT JOIN auteurs ON livres.fk_id_auteur=auteurs.id_auteur LEFT JOIN genres ON livres.fk_id_genre=genres.id_genre");
$stmt->execute();

$books = $stmt->fetchAll();

//Affichage 
foreach($books as $book): ?>
    <article id="book-article">
        <h2><?=$book['titre']?> </h2>
        <p><?=$book['prenom_auteur']?> <?=$book['nom_auteur']?> (<?=$book['annee_publication']?>)</p>
        <p><?= $book['nom_genre']?></p>
        <a href="modifier.php?id='<?=$book['id_livre']?>'" id="edition-book">Modifier</a>
        <a href="supprimer.php?id='<?=$book['id_livre']?>'"  id="delete-book">Supprimer</a>
    </article>
<?php
endforeach
?>        
    </div>
</body>
</html>


