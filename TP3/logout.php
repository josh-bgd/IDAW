<?php

// code pour le traitement de la déconnexion
if(isset($_GET['logout']) && $_GET['logout'] == true) {
    // détruire toutes les données de session
    session_unset();
    
    $_SESSION['logged_in'] = false;
    $_SESSION['login'] = 0;
    // détruire la session
    session_destroy();
}
?>