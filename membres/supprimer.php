<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spprimer un membre</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Supprimer un membre ?</h1>
    <p id="question-supp">Êtes-vous sûr·e de vouloir supprimer ce membre ?</p>

    <?php
        require_once(__DIR__.'/../config/db.php');
        $id = $_GET['id'];

        $stmt =  $pdo->prepare('SELECT nom_membre, prenom_membre, email, date_inscription FROM membres WHERE id_membre = :id');
        $stmt->execute(array(
            'id' => $id
        ));

        $membre = $stmt->fetch()
    ?>
    <article id="delete-article">
        <h2><?=$membre['prenom_membre'], " ", $membre['nom_membre']?> </h2>
        <p><?=$membre['email']?></p>
        <p>Date d'inscription : <?=$membre['date_inscription']?></p>
        <div id="yes-no-container">
            <a href="?id=<?=$id?>&confirmation=yes" id="yes-delete">OUI, Supprimer</a>
            <a href="liste.php">NON, Annuler</a>
        </div>
    </article>

    <?php
        if($_GET['confirmation'] === 'yes' && $_GET['id'] > 0){
            $stmt2 = $pdo->prepare('DELETE FROM membres WHERE id_membre = :id');
            $stmt2->execute(array(
                'id' => $id
            ));

            if($stmt2->rowCount() > 0){
                header('Location: liste.php');
            } else {
                exit("Une erreur s'est produite.");
            }

        }
    ?>
    
</body>
</html>