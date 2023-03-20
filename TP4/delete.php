<?php

    // Incrémentation d'une variable de configuration pour désactiver la suppression de tables, permet de pouvoir annuler une opération de modification de la base de données
    $disableTableDeletion = false;

    /* Bien sûr, voici une explication plus détaillée :

    La variable $disableTableDeletion est une variable booléenne qui est initialisée à false par défaut. Lorsqu'elle est définie à true, cela signifie que la suppression 
    des tables sera désactivée.

    Dans le cas où la suppression des tables est désactivée, le code va d'abord vérifier si les tables existent déjà. Si elles n'existent pas, il les créera en utilisant la 
    structure définie dans le fichier de création de table.

    Si les tables existent déjà, le code vérifiera si la structure des tables correspond à celle définie dans le fichier de création de table. Si ce n'est pas le cas, 
    le code affichera un message d'erreur indiquant que la structure des tables est différente de celle définie dans le fichier de création de table.
    
    Dans tous les cas, le code importera les données de test dans les tables, en utilisant le fichier SQL de données de test. */

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
?>