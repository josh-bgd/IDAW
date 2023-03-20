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

    // On affiche les résultats dans un tableau HTML
    if ($request->rowCount() > 0) {
        echo "<table><tr><th>ID</th><th>Nom</th><th>Email</th><th>Age</th><th>Nationalité</th><th>Actions</th></tr>";
        // On parcourt chaque ligne de résultat
        while ($row = $request->fetch(PDO::FETCH_OBJ)) {
            echo "<tr><td>" . $row->id . "</td><td>" . $row->name . "</td><td>" . $row->email . "</td><td>" . $row->age . "</td><td>" . $row->nationality . "</td><td>";
            echo "<button><a href='update_user.php?id=" . $row->id . "'>Modifier</a></button> | ";
            echo "<button><a href='delete_user.php?id=" . $row->id . "'>Supprimer</a></button>";
            echo "</td></tr>";

            // formulaire de modification pour chaque utilisateur
            
            echo "<tr><td colspan='6'>";
            echo "<form action='update_user.php' method='post'>";
            echo "<input type='hidden' name='id' value='" . $row->id . "'>"; // l'id est caché on ne le voit pas sur la page web mais il est bien là
            echo "<label for='name'>Nom :</label>";
            echo "<input type='text' name='name' value='" . $row->name . "'><br>";
            echo "<label for='email'>Email :</label>";
            echo "<input type='email' name='email' value='" . $row->email . "'><br>";
            echo "<label for='age'>Age :</label>";
            echo "<input type='number' name='age' value='" . $row->age . "'><br>";
            echo "<label for='nationality'>Nationalité :</label>";
            echo "<input type='text' name='nationality' value='" . $row->nationality . "'><br>";
            echo "<input type='submit' value='Modifier'>";
            echo "</form>";
            echo "</td></tr>";
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
