<?php
// on simule une base de données
$users = array(
// login => password
'riri' => 'fifi',
'yoda' => 'maitrejedi' );

$login = "anonymous";
$errorText = "";
$successfullyLogged = false;

if(isset($_POST['login']) && isset($_POST['password'])) {
    // Récupérer les données du formulaire en POST
    $tryLogin = $_POST['login'];
    $tryPwd = $_POST['password'];

    // si login existe et password correspond
    if( array_key_exists($tryLogin,$users) && $users[$tryLogin]==$tryPwd ) {
        $successfullyLogged = true;
        $login = $tryLogin;
    } else
        $errorText = "Erreur de login/password";
} else {
    $errorText = "Merci d'utiliser le formulaire de login";
  }
if(!$successfullyLogged) {
    echo $errorText;
} else {
    echo "<h1>Bienvenu ".$login."</h1>";
    echo "la methode POST est plus sécurisée que le GET car on ne voit pas le password dans l'URL :)";
  }
?>