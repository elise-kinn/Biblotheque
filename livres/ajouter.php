<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un livre</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>

    <h1>Ajouter un livre</h1>
    <a href="liste.php" class="list">Retour à la liste complète de livres</a>
    
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

        <label for="annee">Année de parution</label>
        <input type="text" id="annee" name="annee">

        <label for="genre">Genre</label>
        <select name="genre" id="genre">

            <?php
                $stmt4 = $pdo->prepare('SELECT id_genre, nom_genre FROM genres');
                $stmt4->execute();

                $livres = $stmt4->fetchAll();

                foreach ($livres as $livre): ?>
                    <option value="<?=$livre['id_genre']?>"><?= $livre['nom_genre']?></option>

            <?php
            endforeach
            ?>

        </select>

        <input type="submit" value="Enregistrer le livre" name="add">

    </form>

<?php

if(!empty($_POST['add'])){
    $titre = $_POST['titre'];
    $auteur_id = $_POST['auteur'];
    $annee = $_POST['annee'];
    $genre_id = $_POST['genre'];

    if(empty($titre) || empty($auteur_id) || empty($annee) || empty($genre_id)){
      exit("Vous devez renseigner tous les champs :(");
    };

    if(!ctype_digit($annee) || strlen($annee) !== 4 || intval($annee) > intval(date('Y'))){
        exit("L'année de publication est invalide :(");
    }  

    $stmt1 = $pdo->prepare('INSERT INTO livres (titre, annee_publication, fk_id_genre, fk_id_auteur) VALUES (:titre, :annee, :fk_id_genre, :fk_id_auteur)');
    $stmt1->execute(array(
        'titre' => $titre,
        'annee' => $annee, 
        'fk_id_genre' => $genre_id, 
        'fk_id_auteur' => $auteur_id
    ));

    if($stmt1->rowCount() > 0){
        echo "Nouveau livre ajouté avec succès !";
    } else {
        echo "Aucun livre insérée :(";
    }
}
?>

</body>
</html>