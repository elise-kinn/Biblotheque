<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un livre</title>
</head>
<body>

    <h1>Ajouter un livre</h1>
    <a href="liste.php" id="liste-livre">Voir la liste complète de livre</a>
    
    <form action="#" method="POST">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre">

        <label for="auteur">Auteur</label>
        <select name="auteur" id="auteur">

<?php
    require_once(__DIR__ . '/../config/db.php');

    $stmt = $pdo->prepare('SELECT id_auteur, nom_auteur, prenom_auteur FROM auteurs');
    $stmt->execute();

    $livres = $stmt->fetchAll();

    foreach ($livres as $livre): ?>
        <option value="<?=$livre['id_auteur']?>"><?= $livre['prenom_auteur'] . ' ' . $livre['nom_auteur'] ?></option>

<?php
endforeach
?>

        </select>

        <label for="annee">Année de publication</label>
        <input type="text" id="annee" name="annee">

        <label for="genre">Genre</label>
        <select name="genre" id="genre"></select>

        <input type="submit" value="Enregistrer le livre" name="add">

    </form>

<?php

if(!empty($_POST['add'])){
    $titre = $_POST['titre'];

    $annee = $_POST['annee'];
    $genre = $_POST['genre'];

    if(empty($titre) || empty($auteur_nom) || empty($auteur_prenom) || empty($annee) || empty($genre)){
      exit("Vous devez renseigner tous les champs");
    };

    //GENRE
    $stmt2 = $pdo->prepare('INSERT INTO genres (nom_genre) VALUES (:nom)');
    $stmt2->execute(array(
        'nom' => $genre,
    ));

    //AUTEUR
    $stmt3 = $pdo->prepare('INSERT INTO auteurs (nom_auteur, prenom_auteur) VALUES (:nom, prenom)');
    $stmt3->execute(array(
        'nom' => $auteur_nom,
        'prenom' => $auteur_prenom
    ));    

    //LIVRE
    $stmt1 = $pdo->prepare('INSERT INTO livres (titre, annee_publication) VALUES (:titre, :annee)');
    $stmt1->execute(array(
        'titre' => $titre,
        'annee' => $annee
    ));

    if($stmt1->rowCount() > 0){
        echo "Nouveau membre ajouté avec succès";
    } else {
      echo "Aucune ligne insérée";
    }
}
?>

</body>
</html>