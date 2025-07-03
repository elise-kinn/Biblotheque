<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des auteurs</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Liste des auteurs</h1>
    <a href="ajouter.php" id="add">Ajouter un auteur</a>
    <a href="../livres/liste.php" class="list">Voir la liste des livres</a>
    <a href="../membres/liste.php" class="list">Voir la liste des membres inscrits</a>
    <a href="../emprunts/liste.php" class="list">Voir la liste des emprunts</a>

    <div id="container">
        <?php
            require_once(__DIR__.'/../config/db.php');

            $stmt = $pdo->prepare('SELECT id_auteur, nom_auteur, prenom_auteur FROM auteurs');
            $stmt->execute();

            $auteurs = $stmt->fetchAll();

            foreach ($auteurs as $auteur) : 
        ?>
            <article>
                <h2><?=$auteur['prenom_auteur'], " ", $auteur['nom_auteur']?></h2>
                <a href="modifier.php?id=<?=$auteur['id_auteur']?>" id="edition">Modifier</a>
                <a href="supprimer.php?id=<?=$auteur['id_auteur']?>&confirmation=no"  id="delete">Supprimer</a>
            </article>

        <?php
            endforeach
        ?>
    </div>
</body>
</html>