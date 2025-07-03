<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un auteur</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Supprimer un auteur</h1>
    <p id="question-supp">Êtes-vous sûr·e de vouloir supprimer cet·te auteur·trice ?</p>

    <?php
        require_once(__DIR__.'/../config/db.php');
        $id = $_GET['id'];

        $stmt =  $pdo->prepare('SELECT nom_auteur, prenom_auteur FROM auteurs WHERE id_auteur = :id');
        $stmt->execute(array(
            'id' => $id
        ));

        $membre = $stmt->fetch()
    ?>

    <article id="delete-article">
        <h2><?=$membre['nom_auteur'], " ", $membre['prenom_auteur']?> </h2>
        <div id="yes-no-container">
            <a href="?id=<?=$id?>&confirmation=yes" id="yes-delete">OUI, Supprimer</a>
            <a href="liste.php">NON, Annuler</a>
        </div>
    </article>

    <?php
        if($_GET['confirmation'] === 'yes' && $_GET['id'] > 0){
            $stmt2 = $pdo->prepare('DELETE FROM auteurs WHERE id_auteur = :id');
            $stmt2->execute(array(
                'id' => $id
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