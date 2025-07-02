<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un membre</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">
</head>
<body>
    <h1>Modifier un membre</h1>
    <a href="liste.php" id="list">Retour à la liste complète des membres</a>

    <?php
        require_once(__DIR__ . '/../config/db.php');

        $id = $_GET['id'] ?? 0;
        $stmt = $pdo->prepare('SELECT id_membre, nom_membre, prenom_membre, email FROM membres WHERE id_membre = :id');
        $stmt->execute(array(
            'id' => $id
        ));

        $membre = $stmt->fetch();
    ?>

    <form method="POST">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="<?=$membre['prenom_membre']?>">

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?=$membre['nom_membre']?>">

        <label for="email-input">Email</label>
        <input type="email" id="email-input" name="email" value="<?=$membre['email']?>">

        <input type="submit" value="Ajouter le membre" name="modify">
    </form>

    <?php
        if(!empty($_POST['modify'])){

            $stmt_mail = $pdo->prepare('SELECT COUNT(email) AS countEmail FROM membres WHERE email = :email');
            $stmt_mail->execute(array(
                'email' => $_POST['email']
            ));

            $res = $stmt_mail->fetch(PDO::FETCH_ASSOC);

            if($res['countEmail'] == 1 || $res['countEmail'] == 0){ // Problème si je change l'email avec un déjà existant
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];

                $stmt1 = $pdo->prepare('UPDATE membres SET prenom_membre = :prenom, nom_membre = :nom, email = :email WHERE id_membre = :id');
                $stmt1->execute(array(
                    'prenom' => ucfirst($prenom), 
                    'nom' => ucfirst($nom), 
                    'email' => $email,
                    'id' => $id
                ));

                if(empty($prenom) || empty($nom) || empty($email)){
                    exit('Vous devez renseigner tous les champs :(');
                }

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    exit("L'email renseigné est invalide :(");
                };

                if($stmt1->rowCount() > 0){
                    echo "Modification·s enregistrée·s avec succès !";
                }else{
                    echo "Aucune modification enregistrées :(";
                }
            }else{
                exit("L'email renseigné existe déjà dans la base de donnée :(");
            }
        }
    ?>

</body>
</html>