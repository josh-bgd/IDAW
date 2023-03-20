<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
    require_once('config.php');

    // construction de la chaîne de connexion PDO
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
    // Récupération de la liste des tables de la base de données
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

    // Désactivation de la vérification des clés étrangères pour rendre le code plus dynamique
    $pdo->query('SET foreign_key_checks = 0');

    // Suppression des tables récupérées en cascade
    foreach ($tables as $table) {
        $pdo->exec("DROP TABLE IF EXISTS $table");
    }

    // On réactive les contraintes de clés étrangères
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

    // Créer ou importer la structure et les données de tests
    $sql = file_get_contents('dbtest_structure.sql') . file_get_contents('dbtest_data.sql');
    $pdo->exec($sql);
?>

</body>
</html>
