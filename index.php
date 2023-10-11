<?php
require_once '_connec.php';
$pdo = new \PDO(DSN, USER, PASS); //Objet PDO
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>
</head>
<body>

<?php foreach ($friends as $friend): ?>
    <li> 
        <?=$friend['firstname'] . ' ' . $friend['lastname'] ?>
    </li>
<?php endforeach; ?>

<?php 
if ($_POST){
    
    // requete vulnérable
    //$sql = "INSERT INTO friend (firstname) VALUES ('". $_POST['firstname']."')";
    
    // trim des values avant préparation.
    $firstname = trim($_POST['firstname']); 
    $lastname = trim($_POST['lastname']);
    
    // format d'une requete préparée
    $sql = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
    // preparation de la requete SQL contre les vulnérabilités
    $statement = $pdo->prepare($sql);

    // lie la variable $firstname/$lastname à :firstname/:lastname
    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    //déclenche l'éxecution de la requete.
    $statement->execute();
}
?>

<form method="POST">
    <input type="text" name="firstname" required/>
    <input type="text" name="lastname" required/>
    <input type="submit" name="submit" value="submit" />
</form>

</body>
</html>