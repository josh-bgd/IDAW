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

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère les données du formulaire de modification
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $family_name = $_POST['family_name'];
    $eye_color = $_POST['eye_color'];
    $nationality = $_POST['nationality'];
    
    // vérifier si les données sont valides
    $errors = array();
    if (empty($name)) {
        $errors[] = 'Le nom est obligatoire';
    }
    if (empty($email)) {
        $errors[] = 'L\'email est obligatoire';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'L\'email est invalide';
    }
    if (empty($age)) {
        $errors[] = 'L\'âge est obligatoire';
    } else if (!is_numeric($age) || $age < 0) {
        $errors[] = 'L\'âge est invalide';
    }
    if (empty($nationality)) {
        $errors[] = 'La nationalité est obligatoire';
    }
    if (empty($family_name)) {
        $errors[] = 'Le nom de famille est obligatoire';
    }
    if (empty($eye_color)) {
        $errors[] = 'La couleur des yeux est obligatoire';
    }
    
    // si les données sont valides, ajouter l'utilisateur à la base de données
    if (empty($errors)) {
        $request = $pdo->prepare("INSERT INTO users (name, email, age, family_name, nationality, eye_color) VALUES (:name, :email, :age, :family_name, :nationality, :eye_color)");
        $request->execute(array(':name' => $name, ':email' => $email, ':age' => $age,':family_name' => $family_name, ':nationality' => $nationality, ':eye_color' => $eye_color,));
        
        echo 'Utilisateur ajouté avec succès';
    } 
    
    // Redirection vers la page des utilisateurs
    header("Location: users.php");
    exit;
    } else {
        echo "Erreur : aucun utilisateur sélectionné";
}
?>

</body>
</html>