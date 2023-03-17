<?php
    $currentPageId = 'accueil';
    if(isset($_GET['page'])) {
        $currentPageId = $_GET['page']; // récupère la valeur de la variable 'page' dans l'URL, sinon définit la valeur par défaut 'accueil'
    } 

    require_once('style.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <?php echo '<link rel="stylesheet" type="text/css" href="' . $style . '.css">'; ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $currentPageId ?></title>
</head>

<body>