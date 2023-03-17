<?php
    $style = 'style1';

    if (isset($_POST['css'])) {
        $style = $_POST['css'];
        setcookie('style_cookie', $style, time() + 3600); // stocke la valeur de $style dans un cookie nommé 'style_cookie' pendant 1 heure
    }

    if (isset($_COOKIE['style_cookie'])) {
        $style = $_COOKIE['style_cookie'];
    } else {
        $style = 'style1'; // fixe un style par défaut
    }
?>

