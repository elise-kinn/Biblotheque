<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des membres</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">

</head>
<body>
    <h1>Liste des inscrits</h1>
    <a href="ajouter.php" id="add">Ajouter un membre</a>
    <a href="http://localhost/bibliotheque-php/livres/liste.php" id="list">Voir la liste des livres</a>
    
    <div id="container">
        <?php
            require_once(__DIR__. '/../config/db.php');

            $stmt = $pdo->prepare('SELECT id_membre, nom_membre, prenom_membre, email, date_inscription FROM membres');
            $stmt->execute();

            $membres = $stmt->fetchAll();

            foreach ($membres as $membre) :?>
            <article id="article">
                <div id="group-member">
                    <h2><?=$membre['prenom_membre']?> <?=$membre['nom_membre']?></h2>
                    <p><?=$membre['email']?></p>
                </div>
                <p id="email">Date d'inscription : <?=$membre['date_inscription']?></p>
                <a href="modifier.php?id=<?=$membre['id_membre']?>" id="edition">Modifier</a>
                <a href="supprimer.php?id=<?=$membre['id_membre']?>&confirmation=no" id="delete">Supprimer</a>
            </article>

        <?php
            endforeach
        ?>  
    </div>
</body>
</html>