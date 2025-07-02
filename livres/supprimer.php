<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un livre ?</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>

    <h1>Spprimer un livre</h1>
    <p id="question-supp">Êtes-vous sûr·e de vouloir supprimer ce livre ?</p>

    <?php
        require_once(__DIR__ . '/../config/db.php');
        $id = $_GET['id'] ?? 0;

        $stmt = $pdo->prepare('SELECT livres.id_livre, livres.titre, livres.annee_publication, auteurs.nom_auteur, auteurs.prenom_auteur, genres.nom_genre 
                                FROM livres 
                                LEFT JOIN auteurs ON livres.fk_id_auteur=auteurs.id_auteur 
                                LEFT JOIN genres ON livres.fk_id_genre=genres.id_genre
                                WHERE id_livre=:id
                            ');
        $stmt->execute(array('id' => $id));

        $book = $stmt->fetch();
    ?>

    <article id="book-delete-article">
        <h2><?=$book['titre']?> </h2>
        <p><?=$book['prenom_auteur']?> <?=$book['nom_auteur']?> (<?=$book['annee_publication']?>)</p>
        <p><?= $book['nom_genre']?></p>
        <div id="yes-no-container">
            <a href="?confirmation=yes&id=<?=$book['id_livre']?>">OUI, Supprimer</a>
            <a href="liste.php">NON, Annuler</a>
        </div>
    </article>

    <?php
        if($id > 0 && $_GET['confirmation'] === "yes"){
            $stmt2 = $pdo->prepare('DELETE FROM livres WHERE id_livre=:id');
            $stmt2->execute(array('id' => $id));

            if($stmt->rowCount() > 0){
                header('Location: liste.php');
            } else {
                exit("Une erreur s'est produite.");
            }
        }
    ?>
    
</body>
</html>