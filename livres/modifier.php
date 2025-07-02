<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un livre</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Modifier un livre</h1>
    <a href="liste.php" id="liste-livre">Voir la liste complète de livres</a>

    <?php
        require_once(__DIR__ . '/../config/db.php');
        $id = $_GET['id'] ?? 0;

        $stmt2 = $pdo->prepare('SELECT titre, annee_publication, fk_id_auteur, fk_id_genre FROM livres WHERE id_livre=:id');
        $stmt2->execute(array('id' => $id));

        $book = $stmt2->fetch();
    ?>
    
    <form action="#" method="POST">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" value="<?=$book['titre']?>">

        <label for="auteur">Auteur</label>
        <select name="auteur" id="auteur">

            <?php
                $stmt = $pdo->prepare('SELECT id_auteur, nom_auteur, prenom_auteur FROM auteurs');
                $stmt->execute();

                $livres = $stmt->fetchAll();

                foreach ($livres as $livre): ?>
                    <option 
                        value="<?=$livre['id_auteur']?>" <?=$livre['id_auteur'] == $book['fk_id_auteur'] ? 'selected' : '' ?>>
                        <?= $livre['prenom_auteur'] . ' ' . $livre['nom_auteur'] ?>
                    </option>

            <?php
            endforeach
            ?>

        </select>

        <label for="annee">Année de parution</label>
        <input type="text" id="annee" name="annee" value="<?=$book['annee_publication']?>">

        <label for="genre">Genre</label>
        <select name="genre" id="genre">

            <?php
                $stmt4 = $pdo->prepare('SELECT id_genre, nom_genre FROM genres');
                $stmt4->execute();

                $livres = $stmt4->fetchAll();

                foreach ($livres as $livre): ?>
                    <option 
                        value="<?=$livre['id_genre']?>" <?=$livre['id_genre'] == $book['fk_id_genre'] ? 'selected' : '' ?>>
                        <?= $livre['nom_genre']?>
                    </option>

            <?php
            endforeach
            ?>

        </select>

        <input type="submit" value="Enregistrer les modifications" name="add">

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

    $stmt1 = $pdo->prepare('UPDATE livres SET titre=:titre, annee_publication=:annee, fk_id_genre=:fk_id_genre, fk_id_auteur=:fk_id_auteur WHERE id_livre =:id');
    $stmt1->execute(array(
        'id' => $id,
        'titre' => $titre,
        'annee' => $annee, 
        'fk_id_genre' => $genre_id, 
        'fk_id_auteur' => $auteur_id
    ));

    if($stmt1->rowCount() > 0){
        echo "Modification·s enregistrée·s avec succès !";
    } else {
      echo "Aucune modification enregistrées :(";
    }
}
?>
    
</body>
</html>