<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un auteur</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Ajouter un auteur</h1>
    <a href="liste.php" class="list">Retour à la liste des auteurs</a>

    <form method="POST">
        <label for="prenom_auteur">Prénom</label>
        <input type="text" id="prenom_auteur" name="prenom_auteur">

        <label for="nom_auteur">Nom</label>
        <input type="text" id="nom_auteur" name="nom_auteur">

        <input type="submit" value="Ajouter un auteur" name="add">
    </form>

    <?php
        require_once(__DIR__.'/../config/db.php');

        if(!empty($_POST['add'])){

            $nom = $_POST['nom_auteur'];
            $prenom = $_POST['prenom_auteur'];

            if(empty($nom) || empty($prenom)){
                exit("Vous devez renseigner tous les champs :(");
            }

            $checkStmt = $pdo->prepare('SELECT COUNT(*) AS nb FROM auteurs WHERE nom_auteur = :nom AND prenom_auteur = :prenom');
            $checkStmt->execute([
                'nom' => $nom,
                'prenom' => $prenom
            ]);
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($result['nb'] > 0) {
                echo "Cet auteur·trice existe déjà dans la base de données.";
            } else {
                $stmt = $pdo->prepare('INSERT INTO auteurs (nom_auteur, prenom_auteur) VALUES (:nom, :prenom)');
                $stmt->execute(array(
                    'nom' => ucfirst($nom),
                    'prenom' => ucfirst($prenom)
                ));

                if($stmt->rowCount() > 0){
                    echo "Nouvel·le auteur·trice ajouté·e avec succès !";
                } else {
                    echo "Aucun·e auteur·trice inséré·e :(";
                }
            }

            
        }
    ?>
</body>
</html>