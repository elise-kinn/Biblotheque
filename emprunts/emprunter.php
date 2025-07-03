<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un emprunt</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Enregistrer un emprunt</h1>
    <a href="liste.php" class="list">Retour à la liste des emprunts</a>

    <form method="POST">
        <label for="membre">Membre</label>
        <select name="membre" id="membre">
            <option value="0" selected>Séléctionnez un membre</option>
            <?php
                require_once(__DIR__.'/../config/db.php');

                $stmt = $pdo->prepare('SELECT id_membre, prenom_membre, nom_membre FROM membres');
                $stmt->execute();

                $membres = $stmt->fetchAll();

                foreach ($membres as $membre) : 
            ?>
                <option value="<?=$membre['id_membre']?>">
                    <?=$membre['prenom_membre'], " ", $membre['nom_membre']?>
                </option>
            <?php
                endforeach
            ?>
        </select>

        <label for="livre">Livre</label>
        <select name="livre" id="livre">
            <option value="0" selected>Séléctionnez un livre</option>
            <?php
                $stmt2 = $pdo->prepare('SELECT id_livre, prenom_auteur, nom_auteur, titre FROM livres LEFT JOIN auteurs ON fk_id_auteur = id_auteur');
                $stmt2->execute();

                $livres = $stmt2->fetchAll();

                foreach ($livres as $livre) : 
            ?>
                <option value="<?=$livre['id_livre']?>">
                    <?=$livre['titre'], " - ", $livre['prenom_auteur'], " ", $livre['nom_auteur']?>
                </option>
            <?php
                endforeach
            ?>
        </select>

        <label for="date">Date de retour prévu</label>
        <input type="date" id="date" name="date">

        <input type="submit" value="Enregistrer l'emprunt" name="add">
    </form>

    <?php
        if(!empty($_POST['add'])){
            $id_membre = $_POST['membre'];
            $id_livre = $_POST['livre'];
            $date_prevue = $_POST['date'];

            if(empty($id_membre) || empty($id_livre) || empty($date_prevue)){
                exit("Vous devez remplir tous les champs :(");
            }

            if($date_prevue <= date('y-m-d')){
                exit("La date de retour prévu est incohérente :(");
            }

            $stmt3 = $pdo->prepare('INSERT INTO emprunts(date_emprunt, date_retour_prevu, fk_id_livre, fk_id_membre) VALUES (:date_actuelle, :date_prevue, :id_livre, :id_membre)');
            $stmt3->execute(array(
                'date_actuelle' => date('y-m-d'), 
                'date_prevue' => $date_prevue,
                'id_livre' => $id_livre,
                'id_membre' => $id_membre
            ));

            if($stmt3->rowCount() > 0){
                echo "Nouvel emprunt enregistré avec succès !";
            }else{
                echo "Aucun emprunt enregistré :(";
            }

        }
    ?>
</body>
</html>