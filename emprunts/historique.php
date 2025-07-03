<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des emprunts</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Historique des emprunts</h1>
    <a href="liste.php" class="list">Retour à la liste complète des emprunts</a>

    <div id="container">

        <?php
            require_once(__DIR__.'/../config/db.php');

            $stmt = $pdo->prepare('SELECT id_emprunt, date_emprunt, date_retour_prevu, date_retour_reel, titre, nom_membre, prenom_membre, nom_auteur, prenom_auteur FROM emprunts LEFT JOIN livres ON fk_id_livre = id_livre LEFT JOIN membres ON fk_id_membre = id_membre LEFT JOIN auteurs ON fk_id_auteur = id_auteur WHERE date_retour_reel IS NOT NULL');
            $stmt->execute();

            $emprunts = $stmt->fetchAll();

            foreach ($emprunts as $emprunt) :
        ?>

        <article>
            <h2><?=$emprunt['titre']?> - <?=$emprunt['prenom_auteur'], " ", $emprunt['nom_auteur']?></h2>
            <p>Emprunté par <span class="bold"><?=$emprunt['nom_membre'], " ", $emprunt['prenom_membre']?></span></p>
            <div id="group-member">
                <p>Date d'emprunt : <span class="bold"><?=$emprunt['date_emprunt']?></span></p>
                <p>Date de retour : <span class="bold"><?=$emprunt['date_retour_reel']?></span></p>
            </div>
        </article>

        <?php
            endforeach
        ?>

    </div>
</body>
</html>