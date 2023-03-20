<?php
    // Récupération de la valeur du style dans la variable $_GET
if (isset($_POST['css'])) {
    $style = $_POST['css'];
    
    // Enregistrement de la valeur du style dans un cookie qui expire dans 1 heure
    setcookie('style_cookie', $style, time() + 3600);
  } else {
    // Si la variable $_GET n'est pas définie, on vérifie la présence du cookie
    if (isset($_COOKIE['style_cookie'])) {
      // Utilisation de la valeur stockée dans le cookie pour définir le style de la page
      $style = $_COOKIE['style_cookie'];
    } else {
      // Si le cookie n'existe pas et que la variable $_GET n'est pas définie, on utilise un style par défaut
      $style = 'style1';
    }
  }
?>
