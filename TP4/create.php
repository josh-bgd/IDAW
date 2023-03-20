<?php

// Créer ou importer la structure et les données de tests
$sql = file_get_contents('dbtest_structure.sql') . file_get_contents('dbtest_data.sql');
$pdo->exec($sql);

?>