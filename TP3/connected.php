<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connected</title>
</head>

<body>
    <?php
    $login = "Personne";
    $password = "NULL";

    if(isset($_GET['login']) && isset($_GET['password'])) {
        $login=$_GET['login'];
        $password=$_GET['password'];
    }

    echo "<p>Bonjour " . $login . ", votre mot de passe est :  " . $password . "</p>" 
    ?>
</body>

</html>