<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un membre</title>
    <link rel="stylesheet" href="/bibliotheque-php/css/style.css">

</head>
<body>
    <h1>Ajouter un membre</h1>
    <a href="liste.php" id="list">Retour à la liste complète des membres</a>

    <form method="POST">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom">

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom">

        <label for="email-input">Email</label>
        <input type="email" id="email-input" name="email">

        <input type="submit" value="Ajouter le membre" name="add">
    </form>

    <?php
        require_once(__DIR__ . '/../config/db.php');



        if(!empty($_POST['add'])){

            $stmt_mail = $pdo->prepare('SELECT COUNT(email) AS emailCount FROM membres WHERE email = :email');
            $stmt_mail->execute(array(
                'email' => $_POST['email']
            ));

            $res = $stmt_mail->fetch(PDO::FETCH_ASSOC); // Le resultat est retourné en Tableau associatif
            
            if($res['emailCount'] == 0){
                $prenom = $_POST['prenom'];
                $nom = $_POST['nom'];
                $email = $_POST['email'];

                if(empty($prenom) || empty($nom) || empty($email)){
                    exit('Vous devez renseigner tous les champs :(');
                }

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    exit("L'email renseigné est invalide :(");
                };

                $stmt = $pdo->prepare('INSERT INTO membres (nom_membre, prenom_membre, email, date_inscription) VALUES (:nom, :prenom, :email, :date_insc)');
                $stmt->execute(array(
                    'nom' => ucfirst($nom), 
                    'prenom' => ucfirst($prenom), 
                    'email' => $email, 
                    'date_insc' => date('y-m-d')
                ));

                if($stmt->rowCount() > 0){
                    echo "Nouveau membre ajouté avec succès !";
                } else {
                    echo "Aucun membre ajouté :(";
                }

            }else{
                exit("L'email renseigné existe déjà dans la base de donnée :(");
            }
        }
    ?>
</body>
</html>