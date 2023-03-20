
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Document</title>
</head>
<body>
<?php
require_once('config.php');

// constrction de la chaîne de connexion PDO
$connectionString = "mysql:host=" . _MYSQL_HOST;
if (defined('_MYSQL_PORT'))
    $connectionString .= ";port=" . _MYSQL_PORT;
$connectionString .= ";dbname=" . _MYSQL_DBNAME;

// On définit les options PDO pour spécifier l'encodage
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

// initialiser une connexion PDO
$pdo = NULL;
try {
    $pdo = new PDO($connectionString, _MYSQL_USER, _MYSQL_PASSWORD, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    echo 'Erreur : ' . $erreur->getMessage();
}

// préparation et exécution de la requête SQL
$request = $pdo->prepare("SELECT * FROM users");
$request->execute();


// Récupération de la liste des tables de la base de données
$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

// On affiche les résultats dans un tableau HTML
echo "<h1>$tables[0]</h1>";

if ($request->rowCount() > 0) {
    echo "<table><tr><th>ID</th><th>Nom</th><th>Email</th><th>Age</th><th>Nationalité</th></tr>";
    // On parcourt chaque ligne de résultat
    while ($row = $request->fetch(PDO::FETCH_OBJ)) {
        echo "<tr><td>" . $row->id . "</td><td>" . $row->name . "</td><td>" . $row->email . "</td><td>" . $row->age . "</td><td>" . $row->nationality . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 résultats";
}

// fermer la connexion PDO
$pdo = null;
?>
</body>
</html>