<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendre un livre</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Retour de livre</h1>
    <p id="question-supp">Confirmez-vous cet emprunt terminé ?</p>

    <?php
        require_once(__DIR__.'/../config/db.php');
        $id = $_GET['id'];

        $stmt = $pdo->prepare('SELECT id_emprunt, date_emprunt, date_retour_prevu, date_retour_reel, titre, nom_membre, prenom_membre, nom_auteur, prenom_auteur FROM emprunts LEFT JOIN livres ON fk_id_livre = id_livre LEFT JOIN membres ON fk_id_membre = id_membre LEFT JOIN auteurs ON fk_id_auteur = id_auteur WHERE id_emprunt = :id');
        $stmt->execute(array(
            'id' => $id
        ));

        $emprunt = $stmt->fetch()
    ?>

    <article id="delete-article">
        <h2><?=$emprunt['titre']?> - <?=$emprunt['prenom_auteur'], " ", $emprunt['nom_auteur']?></h2>
        <p>Emprunté par <span class="bold"><?=$emprunt['nom_membre'], " ", $emprunt['prenom_membre']?></span></p>
        <p>Date d'emprunt : <span class="bold"><?=$emprunt['date_emprunt']?></span></p>
        <p>Date de retour prévu : <span class="bold"><?=$emprunt['date_retour_prevu']?></span></p>
        <div id="yes-no-container">
            <a href="?id=<?=$id?>&confirmation=yes" id="yes-delete">OUI, Enregistrer le retour</a>
            <a href="liste.php">NON, Annuler</a>
        </div>
    </article>

    <?php

    if($_GET['id'] > 0 && $_GET['confirmation'] === 'yes'){
        $stmt_del = $pdo->prepare('UPDATE emprunts SET date_retour_reel = :date_reel WHERE id_emprunt = :id');
        $stmt_del->execute(array(
            'id' => $id, 
            'date_reel' => date('Y-m-d')
        ));

        if($stmt->rowCount() > 0){
                header('Location: liste.php');
            } else {
                exit("Une erreur s'est produite.");
            }
    }

    ?>
</body>
</html>