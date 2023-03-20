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

if(isset($_GET['id'])) {
    // On récupère l'ID de l'utilisateur depuis l'URL
    $id = $_GET['id'];

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

    // Suppression de l'utilisateur
    $request = $pdo->prepare("DELETE FROM users WHERE id=:id");
    $request->bindParam(':id', $id);
    $request->execute();

    // fermer la connexion PDO
    $pdo = null;

    // Rediriger l'utilisateur vers la page d'accueil avec un message de confirmation
    header('Location: users.php?message=Utilisateur supprimé avec succès');
    exit();
} else {
    // Rediriger l'utilisateur vers la page d'accueil avec un message d'erreur
    header('Location: users.php?error=Impossible de supprimer l\'utilisateur');
    exit();
}
?>
</body>
</html>