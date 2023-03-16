<?php
require_once('header.php');
require_once('menu.php');
renderMenuToHTML('connected');

// on simule une base de données
$users = array(
    // login => password
    'riri' => 'fifi',
    'yoda' => 'maitrejedi'
);

$login = "anonymous";
$errorText = "";
$successfullyLogged = false;

session_start(); // démarrer une session

if (isset($_POST['login']) && isset($_POST['password'])) {
    // Récupérer les données du formulaire en POST
    $tryLogin = $_POST['login'];
    $tryPwd = $_POST['password'];

    // si login existe et password correspond
    if (array_key_exists($tryLogin, $users) && $users[$tryLogin] == $tryPwd) {
        $successfullyLogged = true;
        $login = $tryLogin;
        $_SESSION['logged_in'] = true;
        $_SESSION['login'] = $login;
    } else
        $errorText = "<p>Erreur de login/password</p>";
}
if (!$successfullyLogged) {
    echo $errorText;
} else {
    echo "<p>la methode POST est plus sécurisée que le GET car on ne voit pas le password dans l'URL :)</p>";
}
require_once('footer.php');
renderFooterToHTML('connected');
?>