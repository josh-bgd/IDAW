<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur</title>
</head>
<body>
<?php

    require_once('config.php');

    if(isset($_POST['id'])) {
        // On récupère les données du formulaire de modification
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $nationality = $_POST['nationality'];

        // constrction de la chaîne de connexion PDO
        $connectionString = "mysql:host=" . _MYSQL_HOST;
        if (defined('_MYSQL_PORT'))
            $connectionString .= ";port=" . _MYSQL_PORT;
        $connectionString .= ";dbname=" . _MYSQL_DBNAME;

        // Options pour spécifier l'encodage
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

        // initialiser une connexion PDO
        $pdo = NULL;
        try {
            $pdo = new PDO($connectionString, _MYSQL_USER, _MYSQL_PASSWORD, $options);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $erreur) {
            echo 'Erreur : ' . $erreur->getMessage();
        }

        // préparation et exécution de la requête SQL pour mettre à jour les informations de l'utilisateur
        $request = $pdo->prepare("UPDATE users SET name=:name, email=:email, age=:age, nationality=:nationality WHERE id=:id");
        $request->bindParam(':name', $name);
        $request->bindParam(':email', $email);
        $request->bindParam(':age', $age);
        $request->bindParam(':nationality', $nationality);
        $request->bindParam(':id', $id);
        $request->execute();

        // fermer la connexion PDO
        $pdo = null;

        // Redirection vers la page des utilisateurs
        header("Location: users.php");
        exit;
    } else {
        echo "Erreur : aucun utilisateur sélectionné";
    }
?>