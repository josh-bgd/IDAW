<?php
    $lang = isset($_GET['lang']) ? $_GET['lang'] : 'fr'; 
?>

<!DOCTYPE html>
<html lang="<?php echo $lang?>">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style1.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../assets/bootstrap/css/bootstrap.min.css">
    <link href="../../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <title><?php echo $currentPageId ?></title>
</head>
<body>