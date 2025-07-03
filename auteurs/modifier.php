<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un auteur</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Modifier un auteur</h1>
    <a href="liste.php" class="list">Retour à la liste des auteurs·es</a>

    <?php
        require_once(__DIR__. '/../config/db.php');
        $id = $_GET['id'];

        $stmt = $pdo->prepare('SELECT nom_auteur, prenom_auteur FROM auteurs WHERE id_auteur = :id');
        $stmt->execute(array(
            'id' => $id
        ));

        $auteur = $stmt->fetch();
    ?>
    <form method="POST">
        <label for="prenom_auteur">Prénom</label>
        <input type="text" id="prenom_auteur" name="prenom_auteur" value="<?=$auteur['prenom_auteur']?>">

        <label for="nom_auteur">Nom</label>
        <input type="text" id="nom_auteur" name="nom_auteur"  value="<?=$auteur['nom_auteur']?>">

        <input type="submit" value="Ajouter un auteur" name="modify">
    </form>

    <?php
        if(!empty($_POST['modify'])){
            $nom = $_POST['nom_auteur'];
            $prenom = $_POST['prenom_auteur'];

            if(empty($nom) || empty($prenom)){
                exit("Vous devez renseigner tous les champs :(");
            };

            $stmt2 = $pdo->prepare('UPDATE auteurs SET nom_auteur = :nom, prenom_auteur = :prenom WHERE id_auteur = :id ');
            $stmt2->execute(array(
                'id' => $id,
                'nom' => $nom,
                'prenom' => $prenom
            ));

            if($stmt2->rowCount() > 0){
                echo "Modification·s enregistrée·s avec succès !";
            } else {
            echo "Aucune modification enregistrées :(";
            }
        }
    ?>
</body>
</html>