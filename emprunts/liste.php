<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des emprunts</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Liste des emprunts</h1>
    <a href="emprunter.php" class="list">Enregistrer un emprunt de livre</a>
    <a href="rendre.php" class="list">Enregistrer un retour de livre</a>
    <a href="historique.php" id="add">Historique des livres empruntés et rendus</a>

    <a href="../livres/liste.php" class="list">Voir la liste des livres</a>
    <a href="../membres/liste.php" class="list">Voir la liste des membres inscrits</a>
    <a href="../auteurs/liste.php" class="list">Voir la liste des auteurs</a>

    <div id="container">
        <?php
            require_once(__DIR__.'/../config/db.php');

            $stmt = $pdo->prepare('SELECT id_emprunt, date_emprunt, date_retour_prevu, date_retour_reel, titre, nom_membre, prenom_membre, nom_auteur, prenom_auteur FROM emprunts LEFT JOIN livres ON fk_id_livre = id_livre LEFT JOIN membres ON fk_id_membre = id_membre LEFT JOIN auteurs ON fk_id_auteur = id_auteur');
            $stmt->execute();
            $emprunts = $stmt->fetchAll();

            foreach ($emprunts as $emprunt) :
        ?>
        <article>
            <h2><?=$emprunt['titre']?> - <?=$emprunt['prenom_auteur'], " ", $emprunt['nom_auteur']?></h2>
            <p>Emprunté par <span class="bold"><?=$emprunt['nom_membre'], " ", $emprunt['prenom_membre']?></span></p>
            <div id="group-member">
                <p>Date d'emprunt : <span class="bold"><?=$emprunt['date_emprunt']?></span></p>
                <p>Date de retour : <span class="bold"><?=$emprunt['date_retour_reel'] ? $emprunt['date_retour_reel'] : "LIVRE NON RENDU" ?></span></p>
            </div>
            <p>Date de retour prévu : <span class="bold"><?=$emprunt['date_retour_prevu']?></span></p>
        </article>
        <?php
            endforeach
        ?>        
    </div>
    
</body>
</html>