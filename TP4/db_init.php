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
    
    // Incrémentation d'une variable de configuration pour désactiver la suppression de tables, permet de pouvoir annuler une opération de modification de la base de données
    $disableTableDeletion = false;

    // Récupération la liste des tables de la base de données
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

    // désactivation de la vérification des clés étrangères pour rendre le code plus dynamique
    $pdo->query('SET foreign_key_checks = 0');

    // Supprimession des tables récupérées en cascade
    foreach ($tables as $table) {
        $pdo->exec("DROP TABLE IF EXISTS $table");
    }

    // On réactive les contraintes de clés étrangères
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

    /* si $disableTableDeletion est définie à true, le code va vérifier si la structure des tables correspond à celle définie dans 
    le fichier de création de table, et importera les données de test. Si $disableTableDeletion est définie à false, le code supprimera d'abord toutes les tables, 
    puis recréera la structure de la base de données en utilisant le fichier de création de table, et enfin importera les données de test. */
    
    if (!$disableTableDeletion) {

        // Lecture du fichier SQL contenant structure + données de test
        $sql = file_get_contents(_MYSQL_DBNAME .'.sql');

        // Exécution du script SQL
        $pdo->exec($sql);

    }

    // Créer ou importer la structure et les données de tests
    $sql = file_get_contents('dbtest_structure.sql') . file_get_contents('dbtest_data.sql');
    $pdo->exec($sql);

    /* On lit le fichier SQL et on exécute les instructions
    $file = _MYSQL_DBNAME .'.sql';
    $sql = file_get_contents($file);
    $pdo->exec($sql);*/
?>
